<?php

use Kirby\Toolkit\A;

return function ($kirby, $page) {
  if ($kirby->request()->is('POST')) {
    if ($user = $kirby->user()) {
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

  return compact('images');
};
