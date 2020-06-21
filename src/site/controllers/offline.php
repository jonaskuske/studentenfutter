<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $user = $kirby->user();
  $favorites = pages([]);

  if ($user) {
    $favorites = $user->favorites()->toPages();
  }

  $kirby->response->header('X-Robots-Tag', 'noindex, nofollow');

  $urlsToCache = A::join($favorites->pluck('url'));
  $kirby->response->header('X-SW-Cache', $urlsToCache);

  return compact('favorites', 'user');
};
