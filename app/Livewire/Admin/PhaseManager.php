<?php

namespace App\Livewire\Admin;

use App\Enums\PhaseStatus;
use App\Models\Phase;
use Illuminate\Support\Str;
use Livewire\Component;

class PhaseManager extends Component
{
    public $phases;
    public $phaseId;
    public $title;
    public $subtitle;
    public $description;
    public $status = 'upcoming';
    public $isEdit = false;
    public $confirmingDeletion = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string|in:upcoming,active,completed',
    ];

    public function mount()
    {
        $this->loadPhases();
    }

    public function loadPhases()
    {
        $this->phases = Phase::orderBy('order', 'asc')->get();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->subtitle = '';
        $this->description = '';
        $this->status = 'upcoming';
        $this->phaseId = null;
        $this->isEdit = false;
    }

    public function save()
    {
        $this->validate();

        $slug = Str::slug($this->title);
        $originalSlug = $slug;
        $count = 1;
        $excludeId = $this->phaseId ?? 0;
        
        while (Phase::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        if ($this->isEdit) {
            $phase = Phase::find($this->phaseId);
            $phase->update([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'status' => $this->status,
                'slug' => $slug,
            ]);

            activity()
                ->performedOn($phase)
                ->log('mengubah fase event');

            session()->flash('success', 'Fase berhasil diperbarui.');
        } else {
            $maxOrder = Phase::max('order') ?? 0;
            $phase = Phase::create([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'status' => $this->status,
                'order' => $maxOrder + 1,
                'slug' => $slug,
            ]);

            activity()
                ->performedOn($phase)
                ->log('membuat fase event baru');

            session()->flash('success', 'Fase berhasil ditambahkan.');
        }

        $this->resetFields();
        $this->loadPhases();
        $this->dispatch('close-modal', 'phase-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $phase = Phase::find($id);
        $this->phaseId = $phase->id;
        $this->title = $phase->title;
        $this->subtitle = $phase->subtitle;
        $this->description = $phase->description;
        $this->status = $phase->status->value;
        $this->isEdit = true;
        
        $this->dispatch('open-modal', 'phase-modal');
    }

    public function moveUp($id)
    {
        $currentPhase = Phase::find($id);
        $previousPhase = Phase::where('order', '<', $currentPhase->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousPhase) {
            $temp = $currentPhase->order;
            $currentPhase->update(['order' => $previousPhase->order]);
            $previousPhase->update(['order' => $temp]);
        }

        $this->loadPhases();
    }

    public function moveDown($id)
    {
        $currentPhase = Phase::find($id);
        $nextPhase = Phase::where('order', '>', $currentPhase->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextPhase) {
            $temp = $currentPhase->order;
            $currentPhase->update(['order' => $nextPhase->order]);
            $nextPhase->update(['order' => $temp]);
        }

        $this->loadPhases();
    }

    public function confirmDelete($id)
    {
        $this->phaseId = $id;
        $this->confirmingDeletion = true;
        $this->dispatch('open-modal', 'delete-confirm-modal');
    }

    public function delete()
    {
        $phase = Phase::find($this->phaseId);
        
        activity()
            ->performedOn($phase)
            ->log('menghapus fase event');

        $phase->delete();

        session()->flash('success', 'Fase berhasil dihapus.');
        $this->confirmingDeletion = false;
        $this->dispatch('close-modal', 'delete-confirm-modal');
        $this->loadPhases();
    }

    public function render()
    {
        return view('livewire.admin.phase-manager');
    }
}
