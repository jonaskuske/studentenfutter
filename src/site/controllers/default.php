<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $dependencies = [];

  $images = $page
    ->editor()
    ->blocks()
    ->filterBy('type', 'image')
    ->map(function ($block) {
      $img = $block->image();
      return $img ? $img->url() : $block->attrs()->src();
    });

  $dependencies = A::merge($dependencies, $images);

  $kirby->response->header('X-SW-Dependencies', A::join($dependencies));

  return [];
};
