<?php

namespace App\Livewire\Public;

use App\Mail\ContactAutoreplyMail;
use App\Mail\ContactNotificationMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $message = '';
    
    // Honeypot field for bot prevention
    public $honeypot = '';

    public $successMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string|min:10|max:1000',
        'honeypot' => 'nullable|string|max:0', // Must be empty
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'message.required' => 'Pesan wajib diisi.',
        'message.min' => 'Pesan minimal berisi 10 karakter.',
        'honeypot.max' => 'Terdeteksi spam bot.',
    ];

    public function submit()
    {
        $this->validate();

        // 1. Honeypot check
        if (!empty($this->honeypot)) {
            // Silently ignore bot requests
            $this->resetForm();
            return;
        }

        // 2. Rate Limiting check (max 3 submissions per IP per hour)
        $ip = request()->ip();
        $rateLimitKey = 'contact-form-submission:' . $ip;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            $this->addError('message', "Terlalu banyak mengirim pesan. Silakan coba lagi dalam {$minutes} menit.");
            return;
        }

        RateLimiter::hit($rateLimitKey, 3600); // 1 hour expiry

        // 3. Save Message to Database
        $contactMessage = ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'ip_address' => $ip,
        ]);

        // 4. Send Queue-based Mails
        $adminEmail = Setting::get('email', 'admin@taqwamovement.id');

        // Dispatch queued notification to Admin
        Mail::to($adminEmail)->queue(new ContactNotificationMail($contactMessage));

        // Dispatch queued receipt to Sender
        Mail::to($this->email)->queue(new ContactAutoreplyMail($contactMessage));

        // 5. Success state
        $this->successMessage = 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda kembali.';
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
        $this->honeypot = '';
    }

    public function render()
    {
        return view('livewire.public.contact-form');
    }
}
