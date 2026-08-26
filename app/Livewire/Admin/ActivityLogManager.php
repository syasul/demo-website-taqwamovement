<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLogManager extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmClearLogs()
    {
        $this->confirmingDeletion = true;
        $this->dispatch('open-modal', 'clear-logs-confirm-modal');
    }

    public function clearLogs()
    {
        Activity::truncate();
        session()->flash('success', 'Semua log audit aktivitas berhasil dibersihkan.');
        $this->confirmingDeletion = false;
        $this->dispatch('close-modal', 'clear-logs-confirm-modal');
    }

    public function render()
    {
        $query = Activity::with('causer')->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('log_name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('causer', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $logs = $query->paginate(15);

        return view('livewire.admin.activity-log-manager', [
            'logs' => $logs
        ]);
    }
}
