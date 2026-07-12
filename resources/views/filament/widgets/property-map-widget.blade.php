<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3 mb-4">
            <h2 class="text-lg font-bold text-gray-950 dark:text-white">Active Properties Map</h2>
        </div>

        <div id="properties-map" style="height: 450px; width: 100%; border-radius: 0.5rem; z-index: 10;"></div>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                initMap();
            });
            
            // For Livewire navigation
            document.addEventListener('livewire:navigated', function () {
                initMap();
            });

            function initMap() {
                const mapEl = document.getElementById('properties-map');
                if (!mapEl) return;
                
                // Prevent re-initialization error
                if (mapEl._leaflet_id) {
                    return;
                }

                const properties = @json($properties);
                
                let centerLat = 20.0;
                let centerLng = 0.0;
                let zoom = 2;
                
                if (properties.length > 0) {
                    centerLat = properties.reduce((acc, curr) => acc + parseFloat(curr.latitude), 0) / properties.length;
                    centerLng = properties.reduce((acc, curr) => acc + parseFloat(curr.longitude), 0) / properties.length;
                    zoom = 4;
                }

                const map = L.map('properties-map').setView([centerLat, centerLng], zoom);

                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);

                properties.forEach(property => {
                    if (property.latitude && property.longitude) {
                        L.marker([property.latitude, property.longitude])
                            .addTo(map)
                            .bindPopup(`<b>${property.title}</b><br>$${property.price}`);
                    }
                });
            }
            
            // Fallback for dynamic component loading
            setTimeout(initMap, 500);
        </script>
    </x-filament::section>
</x-filament-widgets::widget>
