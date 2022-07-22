<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $dependencies = [];

  $images = $page
    ->body()
    ->toBlocks()
    ->filterBy('type', 'image')
    ->toArray(function ($block) {
      if ($block->location() === 'web') {
        return $block->src()->esc();
      }

      return $block
        ->image()
        ->toFile()
        ->url();
    });

  $dependencies = A::merge($dependencies, $images);

  $kirby->response->header('X-SW-Dependencies', A::join($dependencies));

  return [];
};
