<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BlogSearch extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public $search = '';

    #[Url(as: 'c', history: true)]
    public $selectedCategory = '';

    /**
     * Reset pagination when search query updates.
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Filter blog posts by category.
     */
    public function selectCategory($categorySlug)
    {
        $this->selectedCategory = $categorySlug;
        $this->resetPage();
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $postsQuery = Post::published()
            ->with('category')
            ->orderBy('published_at', 'desc');

        // Apply Category Filter
        if ($this->selectedCategory) {
            $postsQuery->whereHas('category', function ($query) {
                $query->where('slug', $this->selectedCategory);
            });
        }

        // Apply Live Search Filter
        if (trim($this->search) !== '') {
            $searchTerm = '%' . trim($this->search) . '%';
            $postsQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                      ->orWhere('excerpt', 'like', $searchTerm)
                      ->orWhere('content', 'like', $searchTerm);
            });
        }

        $posts = $postsQuery->paginate(8);

        return view('livewire.public.blog-search', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
}
