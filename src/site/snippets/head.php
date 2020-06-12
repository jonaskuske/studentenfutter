<!doctype html>
<html lang="de" class="h-full font-sans antialiased leading-normal scroll-smooth scroll-pt-20 scrollbar-lightgray">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>
    <?php $page_title = isset($page_title) ? $page_title : $page->title(); ?>
    <?= e($page->isHomePage(), $site->title(), "{$page_title} | {$site->title()}") ?>
  </title>

  <?= css([
    'assets/css/fonts.css',
    r($kirby->option('production'), 'assets/css/tailwind.min.css', 'assets/css/tailwind.dev.css'),
    '@auto',
  ]) ?>

  <link rel="manifest" href="<?= asset('assets/meta/site.webmanifest')->url() ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/meta/apple-touch-icon.png')->url() ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('assets/meta/favicon-32x32.png')->url() ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('assets/meta/favicon-16x16.png')->url() ?>">
  <link rel="manifest" href="<?= asset('assets/meta/site.webmanifest')->url() ?>">
  <link rel="mask-icon" href="<?= asset('assets/meta/safari-pinned-tab.svg')->url() ?>" color="#f28b85">
  <link rel="shortcut icon" href="<?= asset('assets/meta/favicon.ico')->url() ?>">
  <meta name="apple-mobile-web-app-title" content="studentenfutter">
  <meta name="application-name" content="studentenfutter">
  <meta name="msapplication-TileColor" content="#F28B85">
  <meta name="msapplication-config" content="<?= asset('assets/meta/browserconfig.xml')->url() ?>">
  <meta name="theme-color" content="#F28B85" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  <!-- Splashscreen iOS -->
  <!-- iPhone Xs Max (1242px x 2688px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" href="assets/meta/apple-launch-1242x2688.png">
  <!-- iPhone Xr (828px x 1792px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" href="assets/meta/apple-launch-828x1792.png">
  <!-- iPhone X, Xs (1125px x 2436px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="assets/meta/apple-launch-1125x2436.png">
  <!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="assets/meta/apple-launch-1242x2208.png">
  <!-- iPhone 8, 7, 6s, 6 (750px x 1334px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="assets/meta/apple-launch-750x1334.png">
  <!-- iPad Pro 12.9" (2048px x 2732px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" href="assets/meta/apple-launch-2048x2732.png">
  <!-- iPad Pro 11” (1668px x 2388px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" href="assets/meta/apple-launch-1668x2388.png">
  <!-- iPad Pro 10.5" (1668px x 2224px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" href="assets/meta/apple-launch-1668x2224.png">
  <!-- iPad Mini, Air (1536px x 2048px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" href="assets/meta/apple-launch-1536x2048.png">

  <?= js(['assets/js/polyfills.js', '@auto'], ['defer' => true]) ?>

  <?= js('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', [
    'type' => 'module',
  ]) ?>

  <?= js('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js', [
    'nomodule' => true,
    'defer' => true,
  ]) ?>

  <script>
    if ('serviceWorker' in navigator && location.hostname !== '__localhost') {
      navigator.serviceWorker.register('/service-worker.js').then(
        () => console.log('Service Worker registered.'),
        (error) => console.error('Service Worker failed to register', error),
      )
    }
  </script>
</head>