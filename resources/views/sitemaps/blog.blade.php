{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($articles as $article)
    <url>
        <loc>{{ $article['url'] }}</loc>
        <lastmod>{{ $article['lastmod'] ?? now()->toAtomString() }}</lastmod>
        <changefreq>{{ $article['changefreq'] ?? 'weekly' }}</changefreq>
        <priority>{{ $article['priority'] ?? '0.7' }}</priority>
    </url>
    @endforeach
</urlset>

