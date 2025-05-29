<!-- PWA Meta Tags -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="<?php echo e(asset('icon/ios/152.png')); ?>">
<link rel="manifest" href="<?php echo e(asset('/manifest.json')); ?>">

<!-- PWA iOS Support -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="light">
<meta name="apple-mobile-web-app-title" content="<?php echo e(config('app.name')); ?>">

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
<?php /**PATH /Users/pais/Documents/Kuliah/Semester 5/capstone/transkripKU/resources/views/filament/hooks/pwa-head.blade.php ENDPATH**/ ?>