<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryManager extends Component
{
    public $categories;
    public $categoryId;
    public $name;
    public $slug;
    public $isEdit = false;
    public $confirmingDeletion = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::orderBy('name', 'asc')->get();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->categoryId = null;
        $this->isEdit = false;
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $count = 1;
        $excludeId = $this->categoryId ?? 0;

        while (Category::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        if ($this->isEdit) {
            $category = Category::find($this->categoryId);
            $category->update([
                'name' => $this->name,
                'slug' => $slug,
            ]);

            activity()
                ->performedOn($category)
                ->log('mengubah kategori blog');

            session()->flash('success', 'Kategori berhasil diperbarui.');
        } else {
            $category = Category::create([
                'name' => $this->name,
                'slug' => $slug,
            ]);

            activity()
                ->performedOn($category)
                ->log('membuat kategori blog baru');

            session()->flash('success', 'Kategori berhasil ditambahkan.');
        }

        $this->resetFields();
        $this->loadCategories();
        $this->dispatch('close-modal', 'category-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $category = Category::find($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->isEdit = true;

        $this->dispatch('open-modal', 'category-modal');
    }

    public function confirmDelete($id)
    {
        $this->categoryId = $id;
        $this->confirmingDeletion = true;
        $this->dispatch('open-modal', 'delete-confirm-modal');
    }

    public function delete()
    {
        $category = Category::find($this->categoryId);

        // Prevent deleting category if it has posts
        if ($category->posts()->exists()) {
            session()->flash('error', 'Kategori tidak dapat dihapus karena memiliki artikel aktif.');
            $this->confirmingDeletion = false;
            $this->dispatch('close-modal', 'delete-confirm-modal');
            return;
        }

        activity()
            ->performedOn($category)
            ->log('menghapus kategori blog');

        $category->delete();

        session()->flash('success', 'Kategori berhasil dihapus.');
        $this->confirmingDeletion = false;
        $this->dispatch('close-modal', 'delete-confirm-modal');
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.admin.category-manager');
    }
}
