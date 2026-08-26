<?php

use App\Livewire\Public\ContactForm;
use App\Mail\ContactAutoreplyMail;
use App\Mail\ContactNotificationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('contact form stores message in database and sends queued notifications', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Budi Santoso')
        ->set('email', 'budi@gmail.com')
        ->set('phone', '08123456789')
        ->set('message', 'Halo Taqwa, saya tertarik bergabung program berikutnya.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('successMessage', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda kembali.');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Budi Santoso',
        'email' => 'budi@gmail.com',
    ]);

    Mail::assertQueued(ContactNotificationMail::class);
    Mail::assertQueued(ContactAutoreplyMail::class);
});

test('honeypot filled submissions do not save to database and block email dispatch', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Spam Bot')
        ->set('email', 'bot@spam.com')
        ->set('message', 'This is dynamic spam message.')
        ->set('honeypot', 'i_am_a_bot') // Fills honeypot trap
        ->call('submit');

    $this->assertDatabaseMissing('contact_messages', [
        'name' => 'Spam Bot',
    ]);

    Mail::assertNotQueued(ContactNotificationMail::class);
    Mail::assertNotQueued(ContactAutoreplyMail::class);
});
