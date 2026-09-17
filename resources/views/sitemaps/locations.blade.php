{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($locations as $loc)
    <url>
        <loc>{{ $loc['url'] }}</loc>
        <lastmod>{{ $loc['lastmod'] ?? now()->toAtomString() }}</lastmod>
        <changefreq>{{ $loc['changefreq'] ?? 'daily' }}</changefreq>
        <priority>{{ $loc['priority'] ?? '0.9' }}</priority>
    </url>
    @endforeach
</urlset>

