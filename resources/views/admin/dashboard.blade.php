<x-layouts.admin>
    @section('page_title', 'Dashboard Overview')

    <!-- KPI Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat card: Event Aktif -->
        <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-caption text-brand-ink/55 block font-medium">Event Aktif</span>
                <span class="text-h2 font-serif font-bold text-brand-primary block leading-none">{{ $activeEventsCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Stat card: Inbox Belum Dibaca -->
        <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-caption text-brand-ink/55 block font-medium">Pesan Belum Dibaca</span>
                <span class="text-h2 font-serif font-bold text-brand-primary block leading-none">{{ $unreadMessagesCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-accent/10 text-brand-primary flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Stat card: Artikel Blog -->
        <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-caption text-brand-ink/55 block font-medium">Artikel Blog</span>
                <span class="text-h2 font-serif font-bold text-brand-primary block leading-none">{{ $publishedPostsCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-secondary/10 text-brand-secondary flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
        </div>

        <!-- Stat card: Subscribers -->
        <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-caption text-brand-ink/55 block font-medium">Subscribers</span>
                <span class="text-h2 font-serif font-bold text-brand-primary block leading-none">{{ $subscribersCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Quick Action Shortcuts -->
        <div class="lg:col-span-4 bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex flex-col justify-between">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary mb-6">Pintasan Cepat</h3>
            <div class="space-y-3 flex-grow">
                <a href="/admin/events/create" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-brand-primary hover:bg-brand-blush-lt/5 transition-all text-body font-semibold text-brand-primary">
                    <span class="p-1.5 bg-brand-primary/10 rounded-lg text-brand-primary shrink-0">+</span>
                    Buat Event Baru
                </a>
                <a href="/admin/posts/create" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-brand-primary hover:bg-brand-blush-lt/5 transition-all text-body font-semibold text-brand-primary">
                    <span class="p-1.5 bg-brand-primary/10 rounded-lg text-brand-primary shrink-0">+</span>
                    Tulis Artikel Baru
                </a>
                <a href="/admin/settings" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-brand-primary hover:bg-brand-blush-lt/5 transition-all text-body font-semibold text-brand-primary">
                    <span class="p-1.5 bg-brand-primary/10 rounded-lg text-brand-primary shrink-0">&bull;</span>
                    Update Pengaturan Kontak
                </a>
            </div>
        </div>

        <!-- Recent Audit Activity Log -->
        <div class="lg:col-span-8 bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary mb-6">Aktivitas Terakhir</h3>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-4 text-caption leading-relaxed p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-brand-primary shrink-0">
                            {{ $activity->causer ? substr($activity->causer->name, 0, 1) : 'S' }}
                        </div>
                        <div class="flex-grow">
                            <p class="text-brand-ink/90 font-medium">
                                <span class="font-bold text-brand-primary">{{ $activity->causer->name ?? 'System' }}</span>
                                {{ $activity->description }}
                                <span class="font-bold text-slate-700">#{{ $activity->subject_id }}</span>
                            </p>
                            <span class="text-xs text-brand-ink/50 block mt-0.5">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-caption text-brand-ink/50 italic py-6 text-center">Belum ada log aktivitas admin.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Chart Graphs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Line Chart Pesan Kontak -->
        <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary mb-6">Tren Pesan Kontak Masuk</h3>
            <div class="h-64 relative">
                <canvas id="messagesChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Bar Chart Artikel Terpopuler -->
        <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary mb-6">Top Jurnal Terpopuler (Views)</h3>
            <div class="h-64 relative">
                <canvas id="articlesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Load Chart.js CDN for Admin Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Line Chart: Monthly message trends
            const messagesCtx = document.getElementById('messagesChart').getContext('2d');
            const monthlyLabels = {!! json_encode($monthlyMessages->pluck('label')) !!};
            const monthlyData = {!! json_encode($monthlyMessages->pluck('count')) !!};

            new Chart(messagesCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels.length ? monthlyLabels : ['Belum ada data'],
                    datasets: [{
                        label: 'Jumlah Pesan',
                        data: monthlyData.length ? monthlyData : [0],
                        borderColor: '#502E88',
                        backgroundColor: 'rgba(80, 46, 136, 0.05)',
                        borderWidth: 2.5,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // Bar Chart: Top viewed articles
            const articlesCtx = document.getElementById('articlesChart').getContext('2d');
            const articleLabels = {!! json_encode($topArticles->pluck('label')) !!};
            const articleData = {!! json_encode($topArticles->pluck('views')) !!};

            new Chart(articlesCtx, {
                type: 'bar',
                data: {
                    labels: articleLabels.length ? articleLabels : ['Belum ada data'],
                    datasets: [{
                        label: 'Views',
                        data: articleData.length ? articleData : [0],
                        backgroundColor: '#CA80DC',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.admin>
