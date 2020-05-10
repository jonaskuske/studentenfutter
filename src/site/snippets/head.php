<!doctype html>
<html lang="de" class="h-full font-sans antialiased leading-normal scroll-smooth scroll-pt-20">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>
    <?= e($page->isHomePage(), $site->title(), "{$page->title()} | {$site->title()}") ?>
  </title>

  <?= css(['assets/css/fonts.css', 'assets/css/tailwind.min.css', '@auto']) ?>

  <link rel="manifest" href="<?= asset('assets/site.webmanifest')->url() ?>" />
  <meta name="theme-color" content="#F28B85" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  <?= js(
    ['https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', '@auto'],
    ['defer' => true],
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

<body class="flex flex-col min-h-full font-sans">