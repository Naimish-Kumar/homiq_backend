<!-- ==========================================
     HOMIQ ANALYTICS & GROWTH INFRASTRUCTURE (TASKS 46, 47, 48, 49)
     ========================================== -->

<!-- 1. Google Tag Manager / DataLayer Initialization -->
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
</script>

<!-- 2. Microsoft Clarity Session Recording with Privacy Masking (Task 49) -->
@php
    $clarityId = config('services.clarity.project_id', 'clarity_homiq_prod');
@endphp
@if(!empty($clarityId))
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "{{ $clarityId }}");

    // Enforce privacy masking for all PII fields (phones, emails, passwords, notes)
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('input[type="tel"], input[type="email"], input[type="password"], textarea, [data-clarity-mask="true"]').forEach(function(el) {
            el.setAttribute('data-clarity-mask', 'true');
        });
    });
</script>
@endif

<!-- 3. Unified HomiQ Event Tracking Client (Tasks 46 & 47) -->
<script>
    window.homiqTrack = function(eventName, params = {}, funnelType = null, funnelStep = null) {
        // 1. Dispatch to GA4 / GTM DataLayer
        if (window.dataLayer) {
            window.dataLayer.push({
                event: eventName,
                funnel_type: funnelType,
                funnel_step: funnelStep,
                timestamp: new Date().toISOString(),
                ...params
            });
        }

        // 2. Dispatch custom event tag to Microsoft Clarity
        if (typeof window.clarity === 'function') {
            try {
                window.clarity("event", eventName);
            } catch (e) {}
        }

        // 3. Persist to HomiQ Analytics Ingestion Endpoint
        const payload = {
            event_name: eventName,
            funnel_type: funnelType,
            funnel_step: funnelStep,
            metadata: params,
            property_id: params.property_id || null
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
            || '{{ csrf_token() }}';

        if (navigator.sendBeacon) {
            const blob = new Blob([JSON.stringify(payload)], { type: 'application/json' });
            // sendBeacon payload
            try {
                fetch('/analytics/events', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload),
                    keepalive: true
                }).catch(() => {});
            } catch (err) {}
        } else {
            fetch('/analytics/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).catch(() => {});
        }
    };

    // Auto-hook common interaction selectors
    document.addEventListener('DOMContentLoaded', function() {
        // Track Search Started
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            let searchStartedFired = false;
            searchInput.addEventListener('focus', function() {
                if (!searchStartedFired) {
                    window.homiqTrack('search_started', { source: 'hero_search_input' }, 'seeker', 'search');
                    searchStartedFired = true;
                }
            });
        }

        // Track Search Completed
        const searchForm = document.getElementById('search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                const q = document.getElementById('search-input')?.value || '';
                window.homiqTrack('search_completed', { query: q }, 'seeker', 'search');
            });
        }

        // Track App Download Clicks
        document.querySelectorAll('a[href*="play.google.com"], a[href*="apps.apple.com"]').forEach(function(el) {
            el.addEventListener('click', function() {
                const store = this.href.includes('apple.com') ? 'apple_app_store' : 'google_play';
                window.homiqTrack('app_download_clicked', { store: store, url: this.href }, 'general', 'app_download');
            });
        });

        // Track List Property Owner CTA Starts
        document.querySelectorAll('a[href*="/list-property"], a[href*="/owners"], a[href="#list-free"]').forEach(function(el) {
            el.addEventListener('click', function() {
                window.homiqTrack('listing_started', { source: this.innerText.trim() }, 'owner', 'list_property');
            });
        });
    });
</script>

