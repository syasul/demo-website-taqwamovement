<?php

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Phase;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

// Helper function to build dummy event hierarchy
function createDummyEventHierarchy() {
    $phase = Phase::create([
        'title' => 'Fase 1: Spiritual Awakening',
        'subtitle' => 'Subtitle test',
        'description' => 'Description test',
        'order' => 1,
        'status' => \App\Enums\PhaseStatus::ACTIVE,
        'slug' => 'fase-1-test',
    ]);

    $event = Event::create([
        'phase_id' => $phase->id,
        'title' => 'Taqwa Movement Event Test',
        'tagline' => 'Tagline test',
        'description' => 'Description test',
        'date' => now()->addDays(14),
        'location' => 'Malang Creative Center',
        'status' => \App\Enums\EventStatus::PUBLISHED,
        'slug' => 'taqwa-event-test',
    ]);

    return $event;
}

test('guest can access booking page', function () {
    $event = createDummyEventHierarchy();
    $response = $this->get('/event/' . $event->slug . '/booking');
    $response->assertStatus(200);
});

test('authenticated user can access booking page', function () {
    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    $response = $this->actingAs($user)->get('/event/' . $event->slug . '/booking');
    $response->assertStatus(200);
});

test('checkout status page requires authentication', function () {
    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    
    $order = Order::create([
        'order_number' => 'TQW-TEST-123',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'pending',
        'subtotal' => 100000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 105000,
        'expired_at' => now()->addHour(),
    ]);

    $response = $this->get(route('checkout.status', $order->order_number));
    $response->assertRedirect(route('login'));
});

test('authenticated owner can view checkout status page', function () {
    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    
    $order = Order::create([
        'order_number' => 'TQW-TEST-123',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'pending',
        'subtotal' => 100000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 105000,
        'expired_at' => now()->addHour(),
    ]);

    $response = $this->actingAs($user)->get(route('checkout.status', $order->order_number));
    $response->assertStatus(200);
});

test('midtrans callback with valid signature marks order as paid and generates e-tickets', function () {
    Mail::fake();
    Queue::fake();

    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    
    $ticketType = TicketType::create([
        'event_id' => $event->id,
        'name' => 'Early Pass',
        'price' => 100000,
        'quota' => 10,
        'sold_count' => 1,
        'max_per_transaction' => 2,
        'sale_start_at' => now()->subDays(2),
        'sale_end_at' => now()->addDays(5),
        'description' => 'Description ticket',
        'is_active' => true,
    ]);

    $order = Order::create([
        'order_number' => 'TQW-TEST-SIGNATURE',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'pending',
        'subtotal' => 100000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 105000,
        'expired_at' => now()->addHour(),
    ]);

    $orderItem = OrderItem::create([
        'order_id' => $order->id,
        'ticket_type_id' => $ticketType->id,
        'qty' => 1,
        'price_each' => 100000,
        'attendee_name' => 'Fulanah',
        'attendee_email' => 'fulanah@example.com',
    ]);

    // Midtrans parameters config
    config(['services.midtrans.server_key' => 'dummy-server-key']);

    // Construct valid signature payload
    $orderId = $order->order_number;
    $statusCode = '200';
    $grossAmount = '105000.00';
    $serverKey = 'dummy-server-key';
    $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

    $payload = [
        'order_id' => $orderId,
        'status_code' => $statusCode,
        'gross_amount' => $grossAmount,
        'signature_key' => $signature,
        'transaction_status' => 'settlement',
        'payment_type' => 'qris',
        'transaction_id' => 'midtrans-trans-id-abc',
    ];

    $response = $this->postJson(route('checkout.callback'), $payload);
    $response->assertStatus(200);

    // Verify database updates
    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'paid',
    ]);

    $this->assertDatabaseHas('payments', [
        'order_id' => $order->id,
        'status' => 'settlement',
        'gateway_transaction_id' => 'midtrans-trans-id-abc',
    ]);

    $this->assertDatabaseHas('e_tickets', [
        'order_item_id' => $orderItem->id,
        'is_checked_in' => false,
    ]);

    // Check that notification job was dispatched
    Queue::assertPushed(\App\Jobs\SendTicketNotificationJob::class);
});

test('midtrans callback with invalid signature returns 403', function () {
    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    
    $order = Order::create([
        'order_number' => 'TQW-TEST-INVALID-SIG',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'pending',
        'subtotal' => 100000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 105000,
        'expired_at' => now()->addHour(),
    ]);

    $payload = [
        'order_id' => $order->order_number,
        'status_code' => '200',
        'gross_amount' => '105000.00',
        'signature_key' => 'wrong-signature-hash',
        'transaction_status' => 'settlement',
    ];

    $response = $this->postJson(route('checkout.callback'), $payload);
    $response->assertStatus(403);
});

test('artisan command expires unpaid orders and releases ticket stocks', function () {
    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    
    $ticketType = TicketType::create([
        'event_id' => $event->id,
        'name' => 'Regular Pass',
        'price' => 50000,
        'quota' => 10,
        'sold_count' => 3,
        'max_per_transaction' => 4,
        'sale_start_at' => now()->subDays(2),
        'sale_end_at' => now()->addDays(5),
        'description' => 'Regular ticket description',
        'is_active' => true,
    ]);

    // Create an order that is expired (expired_at is in the past)
    $order = Order::create([
        'order_number' => 'TQW-TEST-EXPIRED',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'pending',
        'subtotal' => 100000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 105000,
        'expired_at' => now()->subMinutes(10), // Expired 10 minutes ago
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'ticket_type_id' => $ticketType->id,
        'qty' => 2,
        'price_each' => 50000,
        'attendee_name' => 'Fulan',
        'attendee_email' => 'fulan@example.com',
    ]);

    // Run the scheduler console command
    Artisan::call('orders:expire-unpaid');

    // Verify order is marked as expired
    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'expired',
    ]);

    // Verify ticketType sold_count is decremented (reclaiming 2 tickets: 3 - 2 = 1)
    $ticketType->refresh();
    expect($ticketType->sold_count)->toBe(1);
});

test('user can view my tickets dashboard page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('dashboard.my-tickets'));
    $response->assertStatus(200);
});

test('user can view transactions list dashboard page', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('dashboard.transactions'));
    $response->assertStatus(200);
});

test('user can view specific ticket detail dashboard page', function () {
    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    $order = Order::create([
        'order_number' => 'TQW-DASH-123',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'paid',
        'subtotal' => 100000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 105000,
        'expired_at' => now()->addHour(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard.ticket.show', $order->order_number));
    $response->assertStatus(200);
});

test('scanner page is restricted to admin role users', function () {
    $user = User::factory()->create(['role' => 'user']);
    $response = $this->actingAs($user)->get(route('admin.check-in'));
    $response->assertStatus(403); // Forbidden
});

test('admin can view scanner page', function () {
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'access-admin']);
    $admin = User::factory()->create();
    $admin->givePermissionTo('access-admin');

    $response = $this->actingAs($admin)->get(route('admin.check-in'));
    $response->assertStatus(200);
});

test('scan request with valid signature checks in attendee', function () {
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'access-admin']);
    $admin = User::factory()->create();
    $admin->givePermissionTo('access-admin');

    $user = User::factory()->create();
    $event = createDummyEventHierarchy();
    
    $ticketType = TicketType::create([
        'event_id' => $event->id,
        'name' => 'Regular Pass',
        'price' => 50000,
        'quota' => 10,
        'sold_count' => 1,
        'max_per_transaction' => 4,
        'sale_start_at' => now()->subDays(2),
        'sale_end_at' => now()->addDays(5),
        'description' => 'Regular ticket description',
        'is_active' => true,
    ]);

    $order = Order::create([
        'order_number' => 'TQW-TEST-SCAN-SUCCESS',
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'paid',
        'subtotal' => 50000,
        'discount' => 0,
        'admin_fee' => 5000,
        'total' => 55000,
        'expired_at' => now()->addHour(),
    ]);

    $orderItem = OrderItem::create([
        'order_id' => $order->id,
        'ticket_type_id' => $ticketType->id,
        'qty' => 1,
        'price_each' => 50000,
        'attendee_name' => 'Ahmad',
        'attendee_email' => 'ahmad@example.com',
    ]);

    $ticketCode = 'TQW-EVT-AHMAD123';
    $qrPayload = json_encode([
        'ticket_code' => $ticketCode,
        'order_number' => $order->order_number,
        'attendee_name' => 'Ahmad',
        'attendee_email' => 'ahmad@example.com',
        'hash' => hash_hmac('sha256', $ticketCode, config('app.key')),
    ]);

    $eTicket = \App\Models\ETicket::create([
        'order_item_id' => $orderItem->id,
        'ticket_code' => $ticketCode,
        'qr_payload' => $qrPayload,
        'is_checked_in' => false,
    ]);

    $response = $this->actingAs($admin)->postJson(route('admin.check-in.scan'), [
        'qr_payload' => $qrPayload
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Registrasi Check-In Berhasil!',
        ]);

    $eTicket->refresh();
    expect($eTicket->is_checked_in)->toBeTrue();
});


