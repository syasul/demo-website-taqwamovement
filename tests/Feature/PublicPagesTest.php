<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page resolves to 200', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('about page resolves to 200', function () {
    $response = $this->get('/about');
    $response->assertStatus(200);
});

test('event index page resolves to 200', function () {
    $response = $this->get('/event');
    $response->assertStatus(200);
});

test('blog index page resolves to 200', function () {
    $response = $this->get('/blog');
    $response->assertStatus(200);
});

test('contact page resolves to 200', function () {
    $response = $this->get('/kontak');
    $response->assertStatus(200);
});

test('sitemap xml resolves to 200 and returns xml content type', function () {
    $response = $this->get('/sitemap.xml');
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/xml');
});
