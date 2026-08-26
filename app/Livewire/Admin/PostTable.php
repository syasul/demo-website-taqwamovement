<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostTable extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $query = Post::with('category')->orderBy('published_at', 'desc');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $posts = $query->paginate(10);

        return view('livewire.admin.post-table', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function deleteSelected(array $ids)
    {
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada artikel yang dipilih.');
            return;
        }

        $posts = Post::whereIn('id', $ids)->get();
        foreach ($posts as $post) {
            activity()
                ->performedOn($post)
                ->log('menghapus artikel blog (bulk)');
            $post->delete();
        }

        session()->flash('success', count($ids) . ' artikel terpilih berhasil dihapus.');
    }
}
