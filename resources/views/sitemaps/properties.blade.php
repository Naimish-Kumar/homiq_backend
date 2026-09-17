{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($properties as $property)
    <url>
        <loc>{{ $property->seo_url }}</loc>
        <lastmod>{{ $property->updated_at?->toAtomString() ?? now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
        @if(!empty($property->images) && is_array($property->images))
            @foreach(array_slice($property->images, 0, 5) as $img)
            <image:image>
                <image:loc>{{ $img }}</image:loc>
                <image:title>{{ htmlspecialchars($property->title) }}</image:title>
                <image:caption>{{ htmlspecialchars($property->address . ' - 0% Brokerage on HomiQ') }}</image:caption>
            </image:image>
            @endforeach
        @endif
    </url>
    @endforeach
</urlset>

