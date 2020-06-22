<?php

$files = [
  '/assets/css/fonts.css',
  '/assets/css/tailwind' . (kirby()->option('production') ? '.min.css' : '.dev.css'),
  '/assets/css/templates/recipe.css',
  '/assets/js/polyfills.js',
  '/assets/js/utils.js',
  '/assets/js/templates/recipe.js',
  '/assets/js/vendor/alpine.min.js',
  '/assets/js/vendor/focus-visible.min.js',
  '/assets/js/vendor/object-fit-images.min.js',
  '/assets/js/vendor/smoothscroll-polyfill.min.js',
  '/assets/js/vendor/smoothscroll-anchor-polyfill.min.js',
  '/assets/fonts/Chivo_Light-Italic.woff2',
  '/assets/fonts/Chivo_Regular.woff2',
  '/assets/fonts/Chivo_Regular-Italic.woff2',
  '/assets/fonts/Chivo_Bold-Italic.woff2',
];

$hashedFiles = array_map(function ($path) {
  if (preg_match('/\/assets\/(css|js)/', $path)) {
    return $path . '?v=' . md5_file(__DIR__ . '/../..' . $path);
  } else {
    return $path;
  }
}, $files);

$asset_manifest = json_encode($hashedFiles, JSON_PRETTY_PRINT);
$asset_hash = md5($asset_manifest);
