<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Prepare test roles and permissions
    Role::findOrCreate('super-admin');
    $accessPermission = Permission::findOrCreate('access-admin');
    
    $editor = Role::findOrCreate('editor');
    $editor->givePermissionTo($accessPermission);
});

test('guests are redirected from admin dashboard', function () {
    $response = $this->get('/admin');
    $response->assertRedirect('/login');
});

test('non-admin users get 403 access denied on admin dashboard', function () {
    $user = User::factory()->create(); // Standard user without roles
    
    $response = $this->actingAs($user)->get('/admin');
    $response->assertStatus(403);
});

test('authorized users can access the admin dashboard', function () {
    $admin = User::factory()->create();
    $admin->givePermissionTo('access-admin');

    $response = $this->actingAs($admin)->get('/admin');
    $response->assertStatus(200);
});

test('authorized users can access all admin CMS extension resources', function () {
    $admin = User::factory()->create();
    $admin->givePermissionTo('access-admin');

    $resources = [
        'admin.ticket-types.index',
        'admin.promo-codes.index',
        'admin.event-sessions.index',
        'admin.orders.index',
        'admin.reports.index',
    ];

    foreach ($resources as $route) {
        $response = $this->actingAs($admin)->get(route($route));
        $response->assertStatus(200);
    }
});

test('authorized users can download CSV sales reports', function () {
    $admin = User::factory()->create();
    $admin->givePermissionTo('access-admin');

    $response = $this->actingAs($admin)->get(route('admin.reports.export'));
    $response->assertStatus(200);
    $response->assertHeader('Content-Disposition', 'attachment; filename=laporan-transaksi.csv');
});
