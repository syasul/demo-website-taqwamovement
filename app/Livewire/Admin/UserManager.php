<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserManager extends Component
{
    public $users;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $role = 'editor';
    public $isEdit = false;
    public $confirmingDeletion = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->userId ?? 0),
            'password' => $this->isEdit ? 'nullable|string|min:8' : 'required|string|min:8',
            'role' => 'required|string|in:super-admin,editor',
        ];
    }

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::orderBy('name', 'asc')->get();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'editor';
        $this->userId = null;
        $this->isEdit = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $user = User::find($this->userId);
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
            ];

            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($this->password);
            }

            $user->update($updateData);

            // Sync role in Spatie Permission
            $user->syncRoles([$this->role]);

            activity()
                ->performedOn($user)
                ->log('mengubah data user admin');

            session()->flash('success', 'User berhasil diperbarui.');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);

            // Assign role in Spatie Permission
            $user->assignRole($this->role);

            activity()
                ->performedOn($user)
                ->log('membuat user admin baru');

            session()->flash('success', 'User berhasil ditambahkan.');
        }

        $this->resetFields();
        $this->loadUsers();
        $this->dispatch('close-modal', 'user-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $user = User::find($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->isEdit = true;

        $this->dispatch('open-modal', 'user-modal');
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->confirmingDeletion = true;
        $this->dispatch('open-modal', 'delete-confirm-modal');
    }

    public function delete()
    {
        // Don't allow self-deletion
        if ($this->userId === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            $this->confirmingDeletion = false;
            $this->dispatch('close-modal', 'delete-confirm-modal');
            return;
        }

        $user = User::find($this->userId);

        activity()
            ->performedOn($user)
            ->log('menghapus user admin');

        $user->delete();

        session()->flash('success', 'User berhasil dihapus.');
        $this->confirmingDeletion = false;
        $this->dispatch('close-modal', 'delete-confirm-modal');
        $this->loadUsers();
    }

    public function deleteSelected(array $ids)
    {
        $ids = array_diff($ids, [auth()->id()]);
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada user valid yang dapat dihapus.');
            return;
        }

        $users = User::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            activity()
                ->performedOn($user)
                ->log('menghapus user admin (bulk)');
            $user->delete();
        }

        session()->flash('success', count($ids) . ' user terpilih berhasil dihapus.');
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.user-manager');
    }
}
