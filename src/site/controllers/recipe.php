<?php

use Kirby\Toolkit\A;
use Kirby\Toolkit\F;

return function ($kirby, $site, $page) {
  $user = $kirby->user();

  if ($kirby->request()->is('POST')) {
    if ($user) {
      try {
        $favorites = $user->favorites()->toPages();

        if (get('favorite') === 'true') {
          $favorites->add($page);
        } else {
          $favorites->remove($page);
        }

        $user->update(['favorites' => $favorites->toArray()]);
      } catch (Exception $e) {
        /* Silence is golden. */
      }
    }

    go($page->url());
  }

  $images = $page->images()->map(function ($img) {
    return $img->thumb(['width' => 900]);
  });

  $dependencies = [];
  $dependencies = A::merge($dependencies, $images->pluck('url'));

  $kirby->response->header('X-SW-Dependencies', A::join($dependencies));

  $kirby->response->header('X-SW-Index-ID', $page->id());

  $isFavorite = $user
    ? $user
      ->favorites()
      ->toPages()
      ->has($page)
    : false;

  return compact('images', 'user', 'isFavorite');
};
