<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        activity()
            ->performedOn($post)
            ->log('menghapus postingan blog');

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil di-soft-delete.');
    }
}
