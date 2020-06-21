<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $user = $kirby->user();
  $favorites = pages([]);

  if ($user) {
    $favorites = $user->favorites()->toPages();
  }

  $kirby->response->header('X-Robots-Tag', 'noindex, nofollow');

  $dependencies = A::merge([], $favorites->pluck('url'));
  $revalidate = [];

  if ($user) {
    $dependencies[] = '/favorites';

    // always revalidate /favorites when updating offline cache
    $revalidate[] = '/favorites';
  }

  $kirby->response->header('X-SW-Dependencies', A::join($dependencies));
  // Always revalidate /favorites when /offline is updated
  $kirby->response->header('X-SW-Revalidate', A::join($revalidate));

  return compact('favorites', 'user');
};
