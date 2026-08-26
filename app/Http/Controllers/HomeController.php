<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Enums\PostStatus;
use App\Models\Event;
use App\Models\Phase;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // 1. Get current active published event (with its sessions and speakers)
        $activeEvent = Event::where('status', EventStatus::PUBLISHED)
            ->with(['sessions.topics', 'speakers'])
            ->first();

        // 2. Get all phases ordered by order
        $phases = Phase::orderBy('order', 'asc')->get();

        // 3. Get features (value propositions)
        $features = Testimonial::where('type', 'feature')
            ->orderBy('order', 'asc')
            ->get();

        // 4. Get active testimonials
        $testimonials = Testimonial::where('type', 'testimonial')
            ->orderBy('order', 'asc')
            ->get();

        // 5. Get 4 latest published blog posts
        $latestPosts = Post::published()
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        return view('pages.home', compact('activeEvent', 'phases', 'features', 'testimonials', 'latestPosts'));
    }
}
