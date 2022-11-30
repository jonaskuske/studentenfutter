<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $recipes = $site
    ->find('recipes')
    ->children()
    ->listed();

  $category_options = A::append(
    ['' => 'Alle Rezepte'],
    $recipes
      ->first()
      ->blueprint()
      ->field('category')['options']
  );

  if (get('category') !== null) {
    go(page()->url(['params' => ['category' => get('category')]]));
    die();
  }

  $selected_category = param('category') ?? '';
  $selected_category_name = A::get($category_options, $selected_category);

  if (!$selected_category_name) {
    $kirby->response()->code(404);
    echo $site->errorPage()->render();
    die();
  }

  $structuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => $selected_category_name,
    'itemListElement' => []
  ];

  $i = 0;
  foreach ($recipes as $recipe) {
    if (!$selected_category || $selected_category === $recipe->category()->toString()) {
      $structuredData['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => ++$i,
        'url' => $recipe->url()
      ];
    }
  }

  return compact(
    'recipes',
    'category_options',
    'selected_category',
    'selected_category_name',
    'structuredData'
  );
};
