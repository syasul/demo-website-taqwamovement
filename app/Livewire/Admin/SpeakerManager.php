<?php

namespace App\Livewire\Admin;

use App\Models\Speaker;
use Livewire\Component;
use Livewire\WithFileUploads;

class SpeakerManager extends Component
{
    use WithFileUploads;

    public $speakers;
    public $speakerId;
    public $name;
    public $role_title;
    public $bio;
    public $instagram_url;
    public $photo; // For file uploads
    public $photoUrl; // Safe URL holder to avoid querying DB inside Blade template
    
    public $isEdit = false;
    public $confirmingDeletion = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'role_title' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'instagram_url' => 'nullable|url|max:255',
        'photo' => 'nullable|image|max:2048', // max 2MB
    ];

    public function mount()
    {
        $this->loadSpeakers();
    }

    public function loadSpeakers()
    {
        $this->speakers = Speaker::orderBy('name', 'asc')->get();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->role_title = '';
        $this->bio = '';
        $this->instagram_url = '';
        $this->photo = null;
        $this->photoUrl = null;
        $this->speakerId = null;
        $this->isEdit = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'role_title' => $this->role_title,
            'bio' => $this->bio,
            'instagram_url' => $this->instagram_url,
        ];

        if ($this->isEdit) {
            $speaker = Speaker::find($this->speakerId);
            $speaker->update($data);

            if ($this->photo) {
                $speaker->clearMediaCollection('photo');
                $speaker->addMedia($this->photo->getRealPath())
                    ->usingFileName($this->photo->getClientOriginalName())
                    ->toMediaCollection('photo');
            }

            activity()
                ->performedOn($speaker)
                ->log('mengubah data pembicara');

            session()->flash('success', 'Data pembicara berhasil diperbarui.');
        } else {
            $speaker = Speaker::create($data);

            if ($this->photo) {
                $speaker->addMedia($this->photo->getRealPath())
                    ->usingFileName($this->photo->getClientOriginalName())
                    ->toMediaCollection('photo');
            }

            activity()
                ->performedOn($speaker)
                ->log('menambahkan pembicara baru');

            session()->flash('success', 'Pembicara baru berhasil ditambahkan.');
        }

        $this->resetFields();
        $this->loadSpeakers();
        $this->dispatch('close-modal', 'speaker-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $speaker = Speaker::find($id);
        $this->speakerId = $speaker->id;
        $this->name = $speaker->name;
        $this->role_title = $speaker->role_title;
        $this->bio = $speaker->bio;
        $this->instagram_url = $speaker->instagram_url;
        $this->photoUrl = $speaker->hasMedia('photo') ? $speaker->getFirstMediaUrl('photo', 'thumb') : null;
        $this->isEdit = true;

        $this->dispatch('open-modal', 'speaker-modal');
    }

    public function confirmDelete($id)
    {
        $this->speakerId = $id;
        $this->confirmingDeletion = true;
        $this->dispatch('open-modal', 'delete-confirm-modal');
    }

    public function delete()
    {
        $speaker = Speaker::find($this->speakerId);
        
        activity()
            ->performedOn($speaker)
            ->log('menghapus pembicara');

        $speaker->delete();

        session()->flash('success', 'Pembicara berhasil dihapus.');
        $this->confirmingDeletion = false;
        $this->dispatch('close-modal', 'delete-confirm-modal');
        $this->loadSpeakers();
    }

    public function deleteSelected(array $ids)
    {
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada pembicara yang dipilih.');
            return;
        }

        $speakers = Speaker::whereIn('id', $ids)->get();
        foreach ($speakers as $speaker) {
            activity()
                ->performedOn($speaker)
                ->log('menghapus pembicara (bulk)');
            $speaker->delete();
        }

        session()->flash('success', count($ids) . ' pembicara terpilih berhasil dihapus.');
        $this->loadSpeakers();
    }

    public function render()
    {
        return view('livewire.admin.speaker-manager');
    }
}
