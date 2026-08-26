<?php

namespace App\Livewire\Admin;

use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class InboxTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedMessageId;
    public $viewingMessage = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function showMessage($id)
    {
        $this->selectedMessageId = $id;
        $message = ContactMessage::find($id);
        
        if ($message) {
            $this->viewingMessage = $message;

            // Auto-mark as read
            if ($message->status->value === 'unread') {
                $message->update(['status' => ContactMessageStatus::READ]);
                
                activity()
                    ->performedOn($message)
                    ->log('membaca pesan masuk');
            }

            $this->dispatch('open-modal', 'inbox-detail-modal');
        }
    }

    public function toggleStatus($id)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            $newStatus = $message->status->value === 'unread' ? ContactMessageStatus::READ : ContactMessageStatus::UNREAD;
            $message->update(['status' => $newStatus]);

            activity()
                ->performedOn($message)
                ->log($newStatus === 'read' ? 'menandai pesan dibaca' : 'menandai pesan belum dibaca');
        }
    }

    public function delete($id)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            activity()
                ->performedOn($message)
                ->log('menghapus pesan masuk');

            $message->delete();
            session()->flash('success', 'Pesan berhasil dihapus.');
            
            if ($this->selectedMessageId === $id) {
                $this->viewingMessage = null;
                $this->dispatch('close-modal', 'inbox-detail-modal');
            }
        }
    }

    public function deleteSelected(array $ids)
    {
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada pesan yang dipilih.');
            return;
        }

        $messages = ContactMessage::whereIn('id', $ids)->get();
        foreach ($messages as $message) {
            activity()
                ->performedOn($message)
                ->log('menghapus pesan masuk (bulk)');
            $message->delete();
        }

        session()->flash('success', count($ids) . ' pesan terpilih berhasil dihapus.');
        if (in_array($this->selectedMessageId, $ids)) {
            $this->viewingMessage = null;
            $this->dispatch('close-modal', 'inbox-detail-modal');
        }
    }

    public function render()
    {
        $query = ContactMessage::orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $messages = $query->paginate(10);

        return view('livewire.admin.inbox-table', [
            'messages' => $messages,
        ]);
    }
}
