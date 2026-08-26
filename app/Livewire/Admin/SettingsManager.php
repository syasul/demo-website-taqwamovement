<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class SettingsManager extends Component
{
    public $activeTab = 'general';

    // General Settings
    public $site_name;
    public $site_tagline;
    public $site_description;
    public $phone;
    public $email;
    public $address;

    // Socials & Integrations Settings
    public $instagram;
    public $tiktok;
    public $youtube;
    public $facebook;
    public $twitter;
    public $whatsapp_link;
    public $map_link;

    protected $rules = [
        'site_name' => 'required|string|max:255',
        'site_tagline' => 'nullable|string|max:255',
        'site_description' => 'nullable|string',
        'phone' => 'required|string|max:50',
        'email' => 'required|email|max:255',
        'address' => 'required|string',
        
        'instagram' => 'nullable|url|max:255',
        'tiktok' => 'nullable|url|max:255',
        'youtube' => 'nullable|url|max:255',
        'facebook' => 'nullable|url|max:255',
        'twitter' => 'nullable|url|max:255',
        'whatsapp_link' => 'nullable|url|max:255',
        'map_link' => 'nullable|url|max:500',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->site_name = Setting::get('site_name', 'Taqwa Movement');
        $this->site_tagline = Setting::get('site_tagline', 'Spiritual Growth Platform');
        $this->site_description = Setting::get('site_description', 'Platform pengembangan diri spiritual Muslim.');
        $this->phone = Setting::get('contact.phone', '+62 812-3456-7890');
        $this->email = Setting::get('contact.email', 'admin@taqwamovement.id');
        $this->address = Setting::get('contact.address', 'Lowokwaru, Kota Malang, Jawa Timur');
        
        $this->instagram = Setting::get('social.instagram', 'https://instagram.com/taqwamovement');
        $this->tiktok = Setting::get('social.tiktok', 'https://tiktok.com/@taqwamovement');
        $this->youtube = Setting::get('social.youtube', 'https://youtube.com/c/taqwamovement');
        $this->facebook = Setting::get('social.facebook', 'https://facebook.com/taqwamovement');
        $this->twitter = Setting::get('social.x', 'https://twitter.com/taqwamovement');
        $this->whatsapp_link = Setting::get('social.whatsapp', 'https://wa.me/6281234567890');
        $this->map_link = Setting::get('contact.maps_iframe', 'https://maps.google.com');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function save()
    {
        $this->validate();

        $settings = [
            'site_name' => $this->site_name,
            'site_tagline' => $this->site_tagline,
            'site_description' => $this->site_description,
            'contact.phone' => $this->phone,
            'contact.email' => $this->email,
            'contact.address' => $this->address,
            'social.instagram' => $this->instagram,
            'social.tiktok' => $this->tiktok,
            'social.youtube' => $this->youtube,
            'social.facebook' => $this->facebook,
            'social.x' => $this->twitter,
            'social.whatsapp' => $this->whatsapp_link,
            'contact.maps_iframe' => $this->map_link,
        ];

        foreach ($settings as $key => $value) {
            $group = 'global';
            if (str_starts_with($key, 'contact.')) {
                $group = 'contact';
            } elseif (str_starts_with($key, 'social.')) {
                $group = 'social';
            }
            Setting::set($key, $value, $group);
        }

        activity()->log('memperbarui pengaturan global website');

        session()->flash('success', 'Pengaturan berhasil disimpan dan diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
