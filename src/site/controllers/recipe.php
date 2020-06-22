<?php

use Kirby\Toolkit\A;
use Kirby\Toolkit\F;

return function ($kirby, $site, $page) {
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

  $kirby->response->header('X-SW-Index-ID', $page->uid());
  $kirby->response->header('X-SW-Index-Title', $page->title() . ' | ' . $site->title());
  $kirby->response->header('X-SW-Index-Description', $page->info()->excerpt(160));
  if ($image = $page->image()) {
    $src = $image->crop(128, 128)->url();
    $kirby->response->header('X-SW-Index-Icon', $src);
    $kirby->response->header('X-SW-Index-Icon-Sizes', '128x128');
    $kirby->response->header('X-SW-Index-Icon-Type', F::mime($src));
  }

  return compact('images');
};
