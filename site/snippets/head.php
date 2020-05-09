<?php
/* Header snippet: includes assets, meta tags etc. */
?>

<!doctype html>
<html lang="de" class="font-sans antialiased leading-normal scroll-smooth scroll-pt-20">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>
    <?= e($page->isHomePage(), $site->title(), "{$page->title()} | {$site->title()}") ?>
  </title>

  <?= css(['assets/css/fonts.css', 'assets/css/tailwind.min.css', '@auto']) ?>

  <?= js(
    ['https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', '@auto'],
    ['defer' => true]
  ) ?>

  <script>
    (function loadPolyfills(doc, cdn, smoothscroll) {
      if (!('scrollBehavior' in doc.documentElement.style)) {
        insertScript(cdn + smoothscroll + '-polyfill/dist/' + smoothscroll + '.min.js')
        insertScript(cdn + smoothscroll + '-anchor-polyfill')
      }

      function insertScript(src, onload) {
        return doc.head.appendChild(Object.assign(doc.createElement('script'), {
          src,
          onload
        }))
      }
    })(document, '//unpkg.com/', 'smoothscroll')
  </script>

</head>

<body class="font-sans">