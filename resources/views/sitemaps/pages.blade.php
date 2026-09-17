{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <lastmod>{{ $page['lastmod'] ?? now()->toAtomString() }}</lastmod>
        <changefreq>{{ $page['changefreq'] ?? 'weekly' }}</changefreq>
        <priority>{{ $page['priority'] ?? '0.8' }}</priority>
    </url>
    @endforeach
</urlset>

