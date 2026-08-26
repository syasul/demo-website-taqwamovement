<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;

class PostForm extends Component
{
    public $post;
    public $isEdit = false;

    // Selection lists
    public $categories = [];

    // Form inputs
    public $category_id;
    public $title;
    public $slug;
    public $excerpt;
    public $content;
    public $author_name;
    public $status = 'draft';
    public $published_at;
    public $meta_title;
    public $meta_description;

    public $activeTab = 'editor';

    protected $rules = [
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'excerpt' => 'nullable|string',
        'content' => 'required|string',
        'author_name' => 'required|string|max:255',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
    ];

    public function mount($post = null)
    {
        $this->categories = Category::orderBy('name', 'asc')->get();
        $this->author_name = auth()->user()->name; // Default to active user name

        if ($post) {
            $this->post = $post;
            $this->isEdit = true;

            $this->category_id = $post->category_id;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt;
            $this->content = $post->content;
            $this->author_name = $post->author_name;
            $this->status = $post->status->value;
            $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : null;
            $this->meta_title = $post->meta_title;
            $this->meta_description = $post->meta_description;
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->isEdit) {
            $this->slug = Str::slug($value);
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function save()
    {
        // Auto-generate excerpt from content if empty
        if (empty($this->excerpt)) {
            $plainText = strip_tags($this->content);
            $this->excerpt = Str::limit($plainText, 160);
        }

        // Validate fields
        $this->validate();

        $data = [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'status' => $this->status,
            'published_at' => $this->published_at ?: null,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];

        if ($this->isEdit) {
            $this->post->update($data);
            $post = $this->post;

            activity()
                ->performedOn($post)
                ->log('mengubah artikel blog');

            session()->flash('success', 'Artikel berhasil diperbarui.');
        } else {
            $post = Post::create($data);

            activity()
                ->performedOn($post)
                ->log('menulis artikel blog baru');

            session()->flash('success', 'Artikel baru berhasil ditambahkan.');
        }

        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.post-form');
    }
}
