<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Home Page -->
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <!-- Static Blog Index -->
    <url>
        <loc>{{ url('/blog') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <!-- Static Contact Page -->
    <url>
        <loc>{{ url('/kontak') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <!-- Dynamic Articles -->
    @foreach ($posts as $post)
        <url>
            <loc>{{ url('/blog/' . $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Dynamic Events -->
    @foreach ($events as $event)
        <url>
            <loc>{{ url('/event/' . $event->slug) }}</loc>
            <lastmod>{{ $event->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
