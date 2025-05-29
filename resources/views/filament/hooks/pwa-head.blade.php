<!-- PWA Meta Tags -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('icon/ios/152.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">

<!-- PWA iOS Support -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="light">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

<!-- PWA Service Worker -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }
</script>
