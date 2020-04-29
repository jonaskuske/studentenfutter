<?php
/* Header snippet: includes assets, meta tags etc. */
?>

<!doctype html>
<html lang="de">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <?php if ($page->isHomePage()) : ?>
    <title><?= $site->title() ?></title>
  <?php else : ?>
    <title><?= $page->title() ?> | <?= $site->title() ?></title>
  <?php endif ?>

  <?= css(['assets/css/index.min.css', '@auto']) ?>

</head>

<body class="font-sans">