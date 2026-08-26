<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactMessageStatus;
use App\Enums\EventStatus;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Post;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // 1. Stats Cards Data
        $activeEventsCount = Event::where('status', EventStatus::PUBLISHED)->count();
        $unreadMessagesCount = ContactMessage::where('status', ContactMessageStatus::UNREAD)->count();
        $publishedPostsCount = Post::where('status', PostStatus::PUBLISHED)->count();
        $subscribersCount = NewsletterSubscriber::where('status', 'active')->count();

        // 2. Recent Activity Log (Spatie Activity Log)
        $recentActivities = Activity::with('causer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Chart Data: Monthly Contact Messages (Last 6 Months)
        $monthlyMessages = ContactMessage::select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw("count(id) as count")
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                // Map month number to Indonesian name
                $monthName = match($item->month) {
                    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                    '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags',
                    '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
                    default => $item->month
                };
                return [
                    'label' => $monthName,
                    'count' => $item->count
                ];
            });

        // 4. Chart Data: Top Viewed Articles
        $topArticles = Post::published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get(['title', 'views_count'])
            ->map(function ($post) {
                return [
                    'label' => strlen($post->title) > 20 ? substr($post->title, 0, 17) . '...' : $post->title,
                    'views' => $post->views_count
                ];
            });

        return view('admin.dashboard', compact(
            'activeEventsCount',
            'unreadMessagesCount',
            'publishedPostsCount',
            'subscribersCount',
            'recentActivities',
            'monthlyMessages',
            'topArticles'
        ));
    }
}
