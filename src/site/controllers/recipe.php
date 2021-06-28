<?php

use Kirby\Toolkit\A;

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

  $category_options = $page->blueprint()->field('category')['options'];

  $structuredData = [
    '@context' => 'https://schema.org/',
    '@type' => 'Recipe',
    'name' => $page->title()->toString(),
    'author' => [],
    'keywords' => '',
    'image' => [],
    'recipeCategory' => A::get($category_options, $page->category()->toString()),
    'recipeIngredient' => [],
    'recipeInstructions' => []
  ];

  if ($page->author()->isNotEmpty()) {
    $structuredData['author'] = ['@type' => 'Person', 'name' => $page->author()->toString()];
  }

  if ($page->tags()->isNotEmpty()) {
    $structuredData['keywords'] = $page->tags()->toString();
  }

  if ($image = $page->image()) {
    $img_sizes = [
      ['width' => 1600, 'height' => 1600], // 1:1
      ['width' => 1600, 'height' => 1200], // 4:3
      ['width' => 1600, 'height' => 900] // 16:9
    ];

    foreach ($img_sizes as $opts) {
      $structuredData['image'][] = $image->thumb($opts)->url();
    }
  }

  foreach ($page->ingredients()->toStructure() as $ingredient) {
    $structuredData['recipeIngredient'][] = $ingredient
      ->textarea()
      ->kti()
      ->toString();
  }

  foreach ($page->preparation()->toStructure() as $step) {
    $structuredData['recipeInstructions'][] = [
      '@type' => 'HowToStep',
      'text' => $step
        ->textarea()
        ->kti()
        ->toString()
    ];
  }

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

  return compact('images', 'user', 'isFavorite', 'structuredData');
};
