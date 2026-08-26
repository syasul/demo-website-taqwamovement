<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Contact group
            [
                'key' => 'contact.address',
                'value' => 'Jl. Tawangsari No. 12, Malang, Jawa Timur',
                'group' => 'contact',
            ],
            [
                'key' => 'contact.email',
                'value' => 'info@taqwamovement.id',
                'group' => 'contact',
            ],
            [
                'key' => 'contact.phone',
                'value' => '+62 812-3456-7890',
                'group' => 'contact',
            ],
            [
                'key' => 'contact.hours',
                'value' => 'Senin - Jumat, 09.00 - 17.00 WIB',
                'group' => 'contact',
            ],
            [
                'key' => 'contact.maps_iframe',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.2138865611145!2d112.61793737588383!3d-7.976824979517178!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e788280f5ec8189%3A0x6338b556f8f7c9e!2sMalang!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid',
                'group' => 'contact',
            ],

            // Social media group
            [
                'key' => 'social.instagram',
                'value' => 'https://instagram.com/taqwamovement.id',
                'group' => 'social',
            ],
            [
                'key' => 'social.facebook',
                'value' => 'https://facebook.com/taqwamovement.id',
                'group' => 'social',
            ],
            [
                'key' => 'social.linkedin',
                'value' => 'https://linkedin.com/company/taqwamovement',
                'group' => 'social',
            ],
            [
                'key' => 'social.x',
                'value' => 'https://x.com/taqwamovement',
                'group' => 'social',
            ],

            // Footer group
            [
                'key' => 'footer.description',
                'value' => 'Taqwa Movement adalah Spiritual Growth Platform berbasis Event & Community Ecosystem untuk generasi muda yang ingin menemukan kedamaian batin dan arah hidup.',
                'group' => 'footer',
            ],

            // SEO group
            [
                'key' => 'seo.default_title',
                'value' => 'Taqwa Movement - Elevating faith. Empowering life.',
                'group' => 'seo',
            ],
            [
                'key' => 'seo.default_description',
                'value' => 'Ruang aman untuk mengurai bisingnya dunia. Temukan kedamaian batin dan arah hidup melalui rangkaian event dan komunitas spiritual growth Taqwa Movement.',
                'group' => 'seo',
            ],
            [
                'key' => 'seo.default_og_image',
                'value' => '/images/default-og.jpg',
                'group' => 'seo',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::set($setting['key'], $setting['value'], $setting['group']);
        }
    }
}
