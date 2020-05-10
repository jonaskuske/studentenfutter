<!doctype html>
<html lang="de" class="h-full font-sans antialiased leading-normal scroll-smooth scroll-pt-20">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>
    <?= e($page->isHomePage(), $site->title(), "{$page->title()} | {$site->title()}") ?>
  </title>

  <?= css([
    'assets/css/fonts.css',
    r($kirby->option('production'), 'assets/css/tailwind.min.css', 'assets/css/tailwind.dev.css'),
    '@auto',
  ]) ?>

  <link rel="manifest" href="<?= asset('assets/site.webmanifest')->url() ?>" />
  <meta name="theme-color" content="#F28B85" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  <?= js('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', [
    'type' => 'module',
  ]) ?>

  <?= js('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js', [
    'nomodule' => true,
    'defer' => true,
  ]) ?>

  <?= js(['assets/js/polyfills.js', '@auto'], ['defer' => true]) ?>

</head>