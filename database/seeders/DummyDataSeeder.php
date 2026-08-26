<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventAgendaItem;
use App\Models\EventAudiencePoint;
use App\Models\EventSession;
use App\Models\EventTopic;
use App\Models\Phase;
use App\Models\Post;
use App\Models\Speaker;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Users (Super Admin, Editor, Content Writer)
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@taqwamovement.id'],
            [
                'name' => 'Super Admin Taqwa',
                'password' => bcrypt('password'),
                'role' => 'super-admin',
            ]
        );
        $superAdminUser->assignRole('super-admin');

        $editorUser = User::firstOrCreate(
            ['email' => 'editor@taqwamovement.id'],
            [
                'name' => 'Editor Taqwa',
                'password' => bcrypt('password'),
                'role' => 'editor',
            ]
        );
        $editorUser->assignRole('editor');

        $writerUser = User::firstOrCreate(
            ['email' => 'writer@taqwamovement.id'],
            [
                'name' => 'Writer Taqwa',
                'password' => bcrypt('password'),
                'role' => 'content-writer',
            ]
        );
        $writerUser->assignRole('content-writer');

        // 2. Create Event Phases
        $phase1 = Phase::create([
            'title' => 'Fase 1: Spiritual Awakening',
            'subtitle' => 'Menemukan kedamaian di tengah kekacauan hidup',
            'description' => 'Fase awal yang berfokus pada pengenalan diri, merapikan hati, dan membangun tawakal sebagai pilar ketenangan batin.',
            'order' => 1,
            'status' => \App\Enums\PhaseStatus::ACTIVE,
            'slug' => 'fase-1-spiritual-awakening',
        ]);

        $phase2 = Phase::create([
            'title' => 'Fase 2: Purposeful Living',
            'subtitle' => 'Menemukan arah dan kontribusi hidup',
            'description' => 'Fase lanjutan untuk menerjemahkan ketenangan batin menjadi aksi nyata dan kebermanfaatan bagi sekitar.',
            'order' => 2,
            'status' => \App\Enums\PhaseStatus::UPCOMING,
            'slug' => 'fase-2-purposeful-living',
        ]);

        $phase3 = Phase::create([
            'title' => 'Fase 3: Faithful Ecosystem',
            'subtitle' => 'Bertumbuh bersama dalam komunitas positif',
            'description' => 'Membangun ekosistem berkelanjutan dan kolaborasi antar pemuda Muslim untuk perubahan sosial yang positif.',
            'order' => 3,
            'status' => \App\Enums\PhaseStatus::UPCOMING,
            'slug' => 'fase-3-faithful-ecosystem',
        ]);

        // 3. Create Speakers
        $speaker1 = Speaker::create([
            'name' => 'Koh Dennis Lim',
            'role_title' => 'Da\'i & Pembina Spiritual',
            'bio' => 'Koh Dennis Lim adalah da\'i muda yang aktif berdakwah di kalangan generasi Z dan milenial. Melalui kisah hidup dan penyampaiannya yang hangat dan logis, beliau membantu ribuan pemuda Muslim menemukan makna hidup sejati.',
            'instagram_url' => 'https://instagram.com/kohdennislim',
        ]);

        // 4. Create Main Event under Phase 1
        $event = Event::create([
            'phase_id' => $phase1->id,
            'title' => 'Taqwa Movement: Level Up Your Iman',
            'tagline' => 'Level Up Your Iman',
            'description' => 'Muslim youth ecosystem pertama di Yogyakarta. Spiritual Growth Event yang dirancang khusus untuk membantumu menemukan kembali arah dan ketenangan batin di tengah hiruk-pikuk dunia.',
            'date' => \Carbon\Carbon::parse('2026-11-08 09:00:00'),
            'location' => 'Kamala Ballroom, Sleman City Hall, Yogyakarta',
            'ticket_url' => 'https://artatix.co.id/event/taqwa-level-up-your-iman',
            'status' => \App\Enums\EventStatus::PUBLISHED,
            'meta_title' => 'Taqwa Movement: Level Up Your Iman',
            'meta_description' => 'Muslim youth ecosystem pertama di Yogyakarta bersama Koh Dennis Lim.',
            'slug' => 'taqwa-movement-level-up-your-iman',
        ]);

        // Associate Speaker to Event
        $event->speakers()->attach($speaker1->id);

        // 5. Create Event Sessions
        $session1 = EventSession::create([
            'event_id' => $event->id,
            'session_number' => 1,
            'title' => 'Ketika Hidup Tak Sesuai Rencana',
            'description' => 'Mengurai bisingnya ekspektasi dunia dan berdamai dengan kenyataan yang tidak berjalan mulus.',
            'start_time' => '09:00',
            'end_time' => '11:00',
        ]);

        $session2 = EventSession::create([
            'event_id' => $event->id,
            'session_number' => 2,
            'title' => 'Ternyata Allah Sedang Mengarahkan',
            'description' => 'Membangun optimisme iman dan menyadari bahwa takdir Allah adalah arahan terbaik menuju versi diri yang lebih mulia.',
            'start_time' => '13:00',
            'end_time' => '15:00',
        ]);

        // 6. Create Event Topics Focus
        // Session 1 Topics
        EventTopic::create([
            'event_session_id' => $session1->id,
            'order' => 1,
            'topic_text' => 'Memahami akar kekecewaan saat harapan patah.',
        ]);
        EventTopic::create([
            'event_session_id' => $session1->id,
            'order' => 2,
            'topic_text' => 'Langkah praktis mengurai kecemasan masa depan (overthinking).',
        ]);
        EventTopic::create([
            'event_session_id' => $session1->id,
            'order' => 3,
            'topic_text' => 'Seni berdamai dengan kegagalan melalui kacamata iman.',
        ]);

        // Session 2 Topics
        EventTopic::create([
            'event_session_id' => $session2->id,
            'order' => 1,
            'topic_text' => 'Menemukan hikmah tersembunyi di balik penolakan takdir.',
        ]);
        EventTopic::create([
            'event_session_id' => $session2->id,
            'order' => 2,
            'topic_text' => 'Bagaimana tawakal membebaskan jiwa dari rasa lelah berlebih.',
        ]);
        EventTopic::create([
            'event_session_id' => $session2->id,
            'order' => 3,
            'topic_text' => 'Membangun fondasi spiritual untuk terus melangkah maju.',
        ]);

        // 7. Create Event Agenda Items (Rundowns)
        // Session Group 1 (Sesi 1 Rundown)
        EventAgendaItem::create([
            'event_id' => $event->id,
            'session_group' => 1,
            'order' => 1,
            'title' => 'Registrasi & Welcoming Session',
            'subtitle' => 'Pendaftaran ulang peserta dan pembagian journal kit.',
            'description' => 'Peserta melakukan check-in dan mendapatkan journal book khusus event.',
            'duration_label' => '08.00 - 09.00',
        ]);
        EventAgendaItem::create([
            'event_id' => $event->id,
            'session_group' => 1,
            'order' => 2,
            'title' => 'Sesi Utama 01: Mengurai Bising Batin',
            'subtitle' => 'Materi utama bersama Ust. Dennis Lim.',
            'description' => 'Memahami cara menenangkan hati dan berdamai dengan ketetapan Allah.',
            'duration_label' => '09.00 - 10.30',
        ]);
        EventAgendaItem::create([
            'event_id' => $event->id,
            'session_group' => 1,
            'order' => 3,
            'title' => 'Q&A & Refleksi Bimbingan',
            'subtitle' => 'Tanya jawab interaktif dan sesi menulis jurnal personal.',
            'description' => 'Peserta menulis refleksi diri dan menanyakan hal-hal yang mengganjal dalam hati.',
            'duration_label' => '10.30 - 11.30',
        ]);

        // Session Group 2 (Sesi 2 Rundown)
        EventAgendaItem::create([
            'event_id' => $event->id,
            'session_group' => 2,
            'order' => 1,
            'title' => 'Istirahat & Sholat Berjamaah',
            'subtitle' => 'Makan siang dan sholat Dzuhur berjamaah.',
            'description' => 'Waktu istirahat dan berjejaring dengan peserta lain.',
            'duration_label' => '11.30 - 13.00',
        ]);
        EventAgendaItem::create([
            'event_id' => $event->id,
            'session_group' => 2,
            'order' => 2,
            'title' => 'Sesi Utama 02: Arah Baru dari Allah',
            'subtitle' => 'Materi sesi kedua bersama Ust. Dennis Lim.',
            'description' => 'Membangun langkah nyata ke depan berlandaskan rasa percaya kepada Allah.',
            'duration_label' => '13.00 - 14.30',
        ]);
        EventAgendaItem::create([
            'event_id' => $event->id,
            'session_group' => 2,
            'order' => 3,
            'title' => 'Closing Prayer & Networking Community',
            'subtitle' => 'Doa bersama dan pembentukan circle kecil.',
            'description' => 'Doa penutup dan berjejaring dalam grup mentoring komunitas pasca-event.',
            'duration_label' => '14.30 - 15.30',
        ]);

        // 8. Create Event Audience Points
        EventAudiencePoint::create([
            'event_id' => $event->id,
            'order' => 1,
            'text' => 'Sering merasa cemas dan lelah dengan tekanan ekspektasi sosial.',
        ]);
        EventAudiencePoint::create([
            'event_id' => $event->id,
            'order' => 2,
            'text' => 'Sedang mengalami patah hati, kegagalan karir, atau disorientasi arah hidup.',
        ]);
        EventAudiencePoint::create([
            'event_id' => $event->id,
            'order' => 3,
            'text' => 'Ingin memperdalam keimanan dengan cara yang logis, santun, dan menenangkan.',
        ]);
        EventAudiencePoint::create([
            'event_id' => $event->id,
            'order' => 4,
            'text' => 'Mencari support system positif dan lingkungan tumbuh yang sehat.',
        ]);

        // 9. Create Blog Categories
        $cat1 = Category::create(['name' => 'Spiritual Growth', 'slug' => 'spiritual-growth']);
        $cat2 = Category::create(['name' => 'Self Reflection', 'slug' => 'self-reflection']);
        $cat3 = Category::create(['name' => 'Mental Health', 'slug' => 'mental-health']);

        // 10. Create Blog Posts (real articles from WP)
        Post::create([
            'category_id' => $cat1->id,
            'title' => 'Tawakal: Obat Anti-Overthinking Masa Depan',
            'slug' => 'tawakal-obat-anti-overthinking-masa-depan',
            'excerpt' => 'Seringkali kita lelah karena memikul beban esok hari yang belum terjadi. Mari temukan bagaimana tawakal membebaskan batin kita.',
            'content' => '<p>Seringkali kita merasa lelah bukan karena apa yang sedang kita jalani hari ini, melainkan karena mencemaskan apa yang belum tentu terjadi esok hari. Overthinking adalah sinyal bahwa kita sedang berusaha mengontrol apa yang bukan menjadi otoritas kita.</p><p>Di sinilah tawakal hadir bukan sebagai sikap pasrah yang pasif, melainkan sebagai penyerahan aktif yang membebaskan batin. Ketika kita melakukan yang terbaik yang kita bisa, lalu meletakkan hasilnya di tangan Allah, ketakutan akan masa depan perlahan memudar digantikan oleh kedamaian batin.</p><p>Sebagaimana Allah berfirman: <em>"Dan barangsiapa bertawakal kepada Allah, niscaya Allah akan mencukupkan (keperluan)nya."</em> (QS. At-Talaq: 3). Mencukupkan di sini bukan hanya perihal materi, tapi kecukupan rasa damai dalam dada.</p>',
            'author_name' => 'Taqwa Writer Team',
            'status' => \App\Enums\PostStatus::PUBLISHED,
            'published_at' => now()->subDays(2),
            'meta_title' => 'Tawakal: Obat Anti-Overthinking Masa Depan',
            'meta_description' => 'Temukan bagaimana mengamalkan tawakal untuk mengatasi overthinking dan kecemasan masa depan.',
        ]);

        Post::create([
            'category_id' => $cat2->id,
            'title' => 'Menemukan Kedamaian di Ruang Tunggu Takdir',
            'slug' => 'menemukan-kedamaian-di-ruang-tunggu-takdir',
            'excerpt' => 'Menunggu jawaban doa bisa terasa melelahkan, namun di ruang tunggu itulah iman kita sedang ditempa dengan ketulusan tertinggi.',
            'content' => '<p>Menunggu adalah salah satu ujian terberat dalam hidup. Menunggu kesembuhan, menunggu jodoh, menunggu pekerjaan, atau sekadar menunggu arah hidup yang lebih jelas. Kita seringkali terburu-buru ingin segera keluar dari fase ini.</p><p>Padahal, jika kita bersedia merenung lebih dalam, ruang tunggu takdir adalah tempat terbaik di mana keikhlasan kita diuji dan iman kita ditempa. Di sanalah kita belajar untuk tidak mendikte Allah, melainkan tunduk pada kebijaksanaan waktu-Nya yang sempurna.</p><p>Di dalam ruang tunggu, kita dilatih untuk berbaik sangka bahwa keterlambatan bukan berarti penolakan, melainkan perlindungan dan persiapan Allah untuk memberi sesuatu yang jauh lebih baik di saat yang paling tepat.</p>',
            'author_name' => 'Taqwa Writer Team',
            'status' => \App\Enums\PostStatus::PUBLISHED,
            'published_at' => now()->subDay(),
            'meta_title' => 'Menemukan Kedamaian di Ruang Tunggu Takdir',
            'meta_description' => 'Tips rohani untuk tetap tenang, berbaik sangka, dan menemukan kedamaian saat menunggu doa-doa kita dikabulkan.',
        ]);

        // 11. Create Testimonials & Features
        // Features
        Testimonial::create([
            'order' => 1,
            'icon' => 'sparkles',
            'title' => 'Reflective Session',
            'description' => 'Sesi kajian mendalam yang interaktif dan mengajak batin merenung secara personal.',
            'type' => 'feature',
        ]);
        Testimonial::create([
            'order' => 2,
            'icon' => 'chat-bubble-left-right',
            'title' => 'Curated Q&A',
            'description' => 'Tanya jawab terpilih untuk mengurai kebingungan hidup dengan jawaban yang logis dan menenangkan.',
            'type' => 'feature',
        ]);
        Testimonial::create([
            'order' => 3,
            'icon' => 'user-group',
            'title' => 'Post-Event Community',
            'description' => 'Komunitas pasca-event untuk saling menguatkan dan bertumbuh bersama secara spiritual.',
            'type' => 'feature',
        ]);

        // Testimonials
        Testimonial::create([
            'order' => 1,
            'icon' => 'heart',
            'title' => 'Menemukan Arah Hidup',
            'description' => 'Event ini benar-benar menjadi oase di tengah kekacauan hidup saya. Penyampaian materi sangat mengena dan atmosfer komunitasnya sangat menenangkan.',
            'type' => 'testimonial',
        ]);
        Testimonial::create([
            'order' => 2,
            'icon' => 'heart',
            'title' => 'Belajar Pasrah Aktif',
            'description' => 'Menemukan perspektif baru tentang tawakal yang selama ini hanya saya dengar teorinya. Di sini diajarkan bagaimana menerapkannya secara logis dalam aktivitas sehari-hari.',
            'type' => 'testimonial',
        ]);

        // 12. Create Ticket Types for the Event
        $ticketEarly = \App\Models\TicketType::create([
            'event_id' => $event->id,
            'name' => 'Early Bird Access',
            'price' => 125000.00,
            'quota' => 50,
            'sold_count' => 0,
            'max_per_transaction' => 2,
            'sale_start_at' => now()->subDays(2),
            'sale_end_at' => now()->addDays(5),
            'description' => 'Akses penuh ke seluruh sesi, mendapatkan Journal Kit fisik, dan snack.',
            'is_active' => true,
        ]);

        $ticketRegular = \App\Models\TicketType::create([
            'event_id' => $event->id,
            'name' => 'Regular Pass',
            'price' => 185000.00,
            'quota' => 150,
            'sold_count' => 0,
            'max_per_transaction' => 4,
            'sale_start_at' => now()->subDays(2),
            'sale_end_at' => now()->addDays(14),
            'description' => 'Akses masuk standard ke seluruh sesi dan snack.',
            'is_active' => true,
        ]);

        // 13. Create Promo Codes
        \App\Models\PromoCode::create([
            'code' => 'TAQWAGLOW',
            'discount_type' => 'fixed',
            'discount_value' => 25000.00,
            'quota' => 30,
            'used_count' => 0,
            'valid_from' => now()->subDays(2),
            'valid_until' => now()->addDays(14),
            'ticket_type_id' => null, // Applies to all types
        ]);
    }
}
