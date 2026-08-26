<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the blog index page.
     */
    public function index()
    {
        return view('pages.blog-index');
    }

    /**
     * Redirect to the blog index with the category query filter.
     */
    public function category(Category $category)
    {
        return redirect()->route('blog.index', ['c' => $category->slug]);
    }

    /**
     * Display the specified blog post.
     */
    public function show(Post $post)
    {
        // Only allow viewing published posts
        if ($post->status->value !== 'published') {
            abort(404);
        }

        // Session guard to prevent duplicate view count increments
        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            $post->increment('views_count');
            session()->put($sessionKey, true);
        }

        // Fetch related posts (same category, excluding current post, max 3)
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.blog-detail', compact('post', 'relatedPosts'));
    }
}
