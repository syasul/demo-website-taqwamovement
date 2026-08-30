<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. AREA ADMIN (SUBDOMAIN: hq.taqwamovement.co.id)
// =========================================================================
// Kita hapus prefix('admin') karena subdomain sudah menjadi penggantinya.
Route::domain('hq.taqwamovement.co.id')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {

        require __DIR__.'/auth.php';


        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/phases', function () {
            return view('admin.phases.index');
        })->name('phases.index');

        Route::delete('/events/bulk', [\App\Http\Controllers\Admin\EventController::class, 'bulkDestroy'])->name('events.bulk-destroy');
        Route::resource('/events', \App\Http\Controllers\Admin\EventController::class)->except(['show']);

        Route::get('/speakers', function () {
            return view('admin.speakers.index');
        })->name('speakers.index');

        Route::get('/testimonials', function () {
            return view('admin.testimonials.index');
        })->name('testimonials.index');

        Route::resource('/posts', \App\Http\Controllers\Admin\PostController::class)->except(['show']);

        Route::get('/messages', function () {
            return view('admin.messages.index');
        })->name('messages.index');

        Route::get('/settings', function () {
            return view('admin.settings.index');
        })->name('settings.index');

        Route::get('/categories', function () {
            return view('admin.categories.index');
        })->name('categories.index');

        Route::get('/users', function () {
            return view('admin.users.index');
        })->name('users.index');

        Route::get('/activity-log', function () {
            return view('admin.activity-log.index');
        })->name('activity-log.index');

        // QR Check-in System
        Route::get('/check-in', [\App\Http\Controllers\Admin\CheckInController::class, 'showScanner'])->name('check-in');
        Route::post('/check-in/scan', [\App\Http\Controllers\Admin\CheckInController::class, 'processScan'])->name('check-in.scan');

        // CMS Extensions Resources CRUD
        Route::delete('/ticket-types/bulk', [\App\Http\Controllers\Admin\TicketTypeController::class, 'bulkDestroy'])->name('ticket-types.bulk-destroy');
        Route::resource('/ticket-types', \App\Http\Controllers\Admin\TicketTypeController::class)->except(['show']);

        Route::delete('/promo-codes/bulk', [\App\Http\Controllers\Admin\PromoCodeController::class, 'bulkDestroy'])->name('promo-codes.bulk-destroy');
        Route::resource('/promo-codes', \App\Http\Controllers\Admin\PromoCodeController::class)->except(['show']);

        Route::delete('/event-sessions/bulk', [\App\Http\Controllers\Admin\EventSessionController::class, 'bulkDestroy'])->name('event-sessions.bulk-destroy');
        Route::resource('/event-sessions', \App\Http\Controllers\Admin\EventSessionController::class)->except(['show']);

        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/reports', [\App\Http\Controllers\Admin\OrderController::class, 'report'])->name('reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('reports.export');
    });


// =========================================================================
// 2. AREA PUBLIK & USER BIASA (DOMAIN UTAMA)
// =========================================================================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    $activeEvent = \App\Models\Event::where('status', \App\Enums\EventStatus::PUBLISHED)
        ->with(['phase', 'sessions', 'speakers'])
        ->first();
    return view('pages.about', compact('activeEvent'));
})->name('about');
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{event:slug}', [EventController::class, 'show'])->name('event.show');
Route::get('/event/{event:slug}/booking', [EventController::class, 'booking'])->name('event.booking');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategori/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/kontak', [ContactController::class, 'show'])->name('contact.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Logika Redirect Cerdas (Tetap dipertahankan)
// Jika admin login, akan otomatis dilempar ke rute admin.dashboard (yang sekarang ada di hq.)
Route::get('/dashboard', function () {
    if (auth()->check() && (auth()->user()->role === 'super-admin' || auth()->user()->role === 'editor' || auth()->user()->is_admin)) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('dashboard.my-tickets');
})->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard Routes
    Route::get('/dashboard/tiket-saya', [\App\Http\Controllers\Dashboard\TicketController::class, 'index'])->name('dashboard.my-tickets');
    Route::get('/dashboard/tiket-saya/{order:order_number}', [\App\Http\Controllers\Dashboard\TicketController::class, 'show'])->name('dashboard.ticket.show');
    Route::get('/dashboard/tiket-saya/{order:order_number}/pdf', [\App\Http\Controllers\Dashboard\TicketController::class, 'downloadPdf'])->name('dashboard.ticket.pdf');
    Route::get('/dashboard/riwayat-transaksi', [\App\Http\Controllers\Dashboard\TicketController::class, 'transactions'])->name('dashboard.transactions');
});

// File auth.php ini menangani rute /login, /register, dll.
// Dibiarkan di luar agar bisa diakses dari domain utama maupun subdomain hq.

// Payment & Checkout Routes
Route::post('/checkout/callback', [\App\Http\Controllers\Checkout\PaymentCallbackController::class, 'handle'])->name('checkout.callback');
Route::get('/checkout/{order:order_number}/status', [\App\Http\Controllers\Checkout\CheckoutController::class, 'status'])->name('checkout.status');
Route::get('/checkout/{order:order_number}/status/json', [\App\Http\Controllers\Checkout\CheckoutController::class, 'checkStatusJson'])->name('checkout.status.json');
Route::post('/checkout/{order:order_number}/simulate-pay', [\App\Http\Controllers\Checkout\CheckoutController::class, 'simulatePay'])->name('checkout.simulate-pay');

Route::get('/design-system', function () {
    return view('pages.design-system');
})->name('design-system');