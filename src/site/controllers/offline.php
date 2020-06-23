<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $user = $kirby->user();
  $favorites = pages([]);

  if ($user) {
    $favorites = $user->favorites()->toPages();
  }

  $kirby->response->header('X-Robots-Tag', 'noindex, nofollow');

  $dependencies = [];
  $revalidate = [];

  if ($user) {
    $dependencies[] = '/favorites';

    // always revalidate /favorites as /offline directly embeds
    // favorites, so it has transitive dependencies
    $revalidate[] = '/favorites';
  }

  $kirby->response->header('X-SW-Dependencies', A::join($dependencies));
  $kirby->response->header('X-SW-Revalidate', A::join($revalidate));

  return compact('favorites', 'user');
};
