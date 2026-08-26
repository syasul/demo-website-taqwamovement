<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;

class TestimonialManager extends Component
{
    public $testimonials;
    public $testimonialId;
    public $title;
    public $description;
    public $icon = 'heart';
    public $type = 'feature';
    public $order = 0;

    public $isEdit = false;
    public $confirmingDeletion = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'nullable|string|max:255',
        'type' => 'required|string|in:feature,testimonial',
    ];

    public function mount()
    {
        $this->loadTestimonials();
    }

    public function loadTestimonials()
    {
        $this->testimonials = Testimonial::orderBy('type', 'asc')->orderBy('order', 'asc')->get();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
        $this->icon = 'heart';
        $this->type = 'feature';
        $this->testimonialId = null;
        $this->isEdit = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'type' => $this->type,
        ];

        if ($this->isEdit) {
            $testimonial = Testimonial::find($this->testimonialId);
            $testimonial->update($data);

            activity()
                ->performedOn($testimonial)
                ->log('mengubah testimoni/feature');

            session()->flash('success', 'Testimoni/Feature berhasil diperbarui.');
        } else {
            $maxOrder = Testimonial::where('type', $this->type)->max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
            
            $testimonial = Testimonial::create($data);

            activity()
                ->performedOn($testimonial)
                ->log('menambahkan testimoni/feature baru');

            session()->flash('success', 'Testimoni/Feature baru berhasil ditambahkan.');
        }

        $this->resetFields();
        $this->loadTestimonials();
        $this->dispatch('close-modal', 'testimonial-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $testimonial = Testimonial::find($id);
        $this->testimonialId = $testimonial->id;
        $this->title = $testimonial->title;
        $this->description = $testimonial->description;
        $this->icon = $testimonial->icon;
        $this->type = $testimonial->type;
        $this->isEdit = true;

        $this->dispatch('open-modal', 'testimonial-modal');
    }

    public function moveUp($id)
    {
        $current = Testimonial::find($id);
        $previous = Testimonial::where('type', $current->type)
            ->where('order', '<', $current->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previous) {
            $temp = $current->order;
            $current->update(['order' => $previous->order]);
            $previous->update(['order' => $temp]);
        }

        $this->loadTestimonials();
    }

    public function moveDown($id)
    {
        $current = Testimonial::find($id);
        $next = Testimonial::where('type', $current->type)
            ->where('order', '>', $current->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($next) {
            $temp = $current->order;
            $current->update(['order' => $next->order]);
            $next->update(['order' => $temp]);
        }

        $this->loadTestimonials();
    }

    public function confirmDelete($id)
    {
        $this->testimonialId = $id;
        $this->confirmingDeletion = true;
        $this->dispatch('open-modal', 'delete-confirm-modal');
    }

    public function delete()
    {
        $testimonial = Testimonial::find($this->testimonialId);
        
        activity()
            ->performedOn($testimonial)
            ->log('menghapus testimoni/feature');

        $testimonial->delete();

        session()->flash('success', 'Data berhasil dihapus.');
        $this->confirmingDeletion = false;
        $this->dispatch('close-modal', 'delete-confirm-modal');
        $this->loadTestimonials();
    }

    public function deleteSelected(array $ids)
    {
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada data yang dipilih.');
            return;
        }

        $testimonials = Testimonial::whereIn('id', $ids)->get();
        foreach ($testimonials as $testimonial) {
            activity()
                ->performedOn($testimonial)
                ->log('menghapus testimoni/feature (bulk)');
            $testimonial->delete();
        }

        session()->flash('success', count($ids) . ' data terpilih berhasil dihapus.');
        $this->loadTestimonials();
    }

    public function render()
    {
        return view('livewire.admin.testimonial-manager');
    }
}
