<?php
/* Header snippet: includes assets, meta tags etc. */
?>

<!doctype html>
<html lang="de" class="font-sans antialiased leading-normal">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <?php if ($page->isHomePage()) : ?>
    <title><?= $site->title() ?></title>
  <?php else : ?>
    <title><?= $page->title() ?> | <?= $site->title() ?></title>
  <?php endif; ?>

  <?= css(['assets/css/fonts.css', 'assets/css/tailwind.min.css', '@auto']) ?>

  <?= js(
    ['https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', '@auto'],
    ['defer' => true]
  ) ?>

</head>

<body class="font-sans">