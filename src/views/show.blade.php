<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($sitemap as $page)
    <url>
        <loc>{{ url($page['locate']) }}</loc>
        <lastmod>{{ $page['lastMod'] }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
</urlset>