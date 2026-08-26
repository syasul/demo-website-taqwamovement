<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate the dynamic sitemap XML.
     */
    public function index(): Response
    {
        // Get all published posts
        $posts = Post::published()->orderBy('published_at', 'desc')->get();

        // Get all published events
        $events = Event::published()->orderBy('date', 'desc')->get();

        $content = view('sitemap', compact('posts', 'events'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
