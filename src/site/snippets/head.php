<!doctype html>
<html id="tw" lang="de" class="scrollbar-lightgray">
<?php
$site_title = $site->title();
$page_title = isset($page_title) ? $page_title : $page->title();
$title = r($page->isHomePage(), $site_title, "{$page_title} | {$site_title}");

$default_description =
  'Die App mit Rezepten von Studierenden aus ganz Deutschland. Egal, ob Salat, Suppe, Hauptgericht oder Dessert. Hier ist für jede*n etwas dabei.';

$description = isset($page_description) ? $page_description : $default_description;

$default_image = asset('assets/meta/sharing-image.png')->url();

$has_img = $page->template() == 'recipe' && $page->hasImages();
$img = $has_img
  ? $page
    ->image()
    ->crop(1200, 630)
    ->url()
  : $default_image;
?>

<head prefix="og: http://ogp.me/ns#">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?= $title ?></title>

  <link rel="preload" as="font" href="<?= asset(
    'assets/fonts/Chivo_Light-Italic.woff2'
  )->url() ?>" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?= asset(
    'assets/fonts/Chivo_Regular.woff2'
  )->url() ?>" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?= asset(
    'assets/fonts/Chivo_Regular-Italic.woff2'
  )->url() ?>" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?= asset(
    'assets/fonts/Chivo_Bold-Italic.woff2'
  )->url() ?>" crossorigin="anonymous">

  <?= css([
    $kirby->option('production') ? 'assets/css/tailwind.min.css' : 'assets/css/tailwind.dev.css',
    '@auto'
  ]) ?>

  <link rel="manifest" href="<?= asset('assets/meta/site.webmanifest')->url() ?>" />
  <link
    rel="apple-touch-icon"
    sizes="180x180"
    href="<?= asset('assets/meta/apple-touch-icon.png')->url() ?>"
  >
  <link
    rel="icon"
    type="image/png"
    sizes="32x32"
    href="<?= asset('assets/meta/favicon-32x32.png')->url() ?>"
  >
  <link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="<?= asset('assets/meta/favicon-16x16.png')->url() ?>"
  >
  <link rel="manifest" href="<?= asset('assets/meta/site.webmanifest')->url() ?>">
  <link
    rel="mask-icon"
    href="<?= asset('assets/meta/safari-pinned-tab.svg')->url() ?>"
    color="#f28b85"
  >
  <link rel="shortcut icon" href="<?= asset('assets/meta/favicon.ico')->url() ?>">
  <meta name="apple-mobile-web-app-title" content="studentenfutter">
  <meta name="application-name" content="studentenfutter">
  <meta name="msapplication-TileColor" content="#F28B85">
  <meta name="msapplication-config" content="<?= asset('assets/meta/browserconfig.xml')->url() ?>">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="theme-color" content="#FFFFFF">

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

  <!-- Sharing Info -->
  <meta name="description" content="<?= $description ?>" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta property="og:type" content="website" />
  <meta property="og:description" content="<?= $description ?>" />
  <meta property="og:image" content="<?= $img ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />

  <meta property="og:url" content="<?= $page->url() ?>" />
  <meta property="og:title" content="<?= $title ?>" />

  <link rel="canonical" href="<?= $page->url(['params' => params()]) ?>" />

  <?= js(['assets/js/polyfills.js', 'assets/js/utils.js', '@auto'], ['defer' => true]) ?>

  <?= js('assets/js/vendor/alpine.min.js', ['type' => 'module']) ?>
  <?= js('assets/js/vendor/alpine-ie11.min.js', ['nomodule' => true, 'defer' => true]) ?>

  <script type="module">
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        const ONE_SECOND = 1000
        const ONE_MINUTE = 60 * ONE_SECOND
        const ONE_HOUR = 60 * ONE_MINUTE
        const ONE_DAY = 24 * ONE_HOUR

        const handleRegistration = async (registration) => {
          if ('periodicSync' in registration) {
            try {
              const p = await navigator.permissions.query({ name: 'periodic-background-sync' })
              if (p.state === 'granted') {
                await navigator.serviceWorker.ready
                await registration.periodicSync.register('UPDATE_CACHE', { minInterval: ONE_HOUR })
                console.log('%c[sw] %cregistered background sync', 'color:darkgray', 'font-weight:bold')
              }
            } catch(error) {
              console.error(error)
            }
          }
        }

    
        navigator.serviceWorker.register('/service-worker.js').then(
          handleRegistration,
          (error) => {
            console.error('%c[sw] %cfailed to register', 'color: darkgray', 'font-weight:bold', error)
          }
        )
      })
    }

    window.addEventListener('beforeinstallprompt', (event) => {
      event.preventDefault()
      window.INSTALL_EVENT = event
    })
  </script>
  <script async defer data-website-id="f827d061-2bbc-428a-b4bd-314f343007f0" data-domains="studentenfutter.app" src="https://copernicus.joku.co/sentinel.js"></script>
</head>

<body
  <?= attr(['class' => isset($body_class) ? $body_class : '']) ?>
  :class="standalone && 'user-drag-none'"
  x-data="{ standalone: isStandalone() }"
  x-init="matchMedia('(display-mode:standalone),(display-mode:window-controls-overlay)').addListener(function(e) { standalone=e.matches })"
  @contextmenu="standalone && !$event.target.matches('p,span,input,select,textarea') && $event.preventDefault()"
  @dragstart="standalone && !$event.target.matches('p,span,input,select,textarea') && $event.preventDefault()"
>

<script>
  'use strict'
  ;(function detectScrollbar(doc) {
    var el = doc.body.appendChild(doc.createElement('div'))

    el.style.cssText =
      'width:100px;height:100px;overflow:scroll !important;position:absolute;top:-100vh'

    var hasScrollbar = el.offsetWidth - el.clientWidth > 0
    if (hasScrollbar) doc.documentElement.classList.add('has-scrollbar')

    doc.body.removeChild(el)
  })(document)
</script>
