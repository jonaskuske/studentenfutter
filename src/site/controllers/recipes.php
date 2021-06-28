<?php

use Kirby\Toolkit\A;

return function ($site) {
  $recipes = $site
    ->find('recipes')
    ->children()
    ->listed();

  $category_options = $recipes
    ->first()
    ->blueprint()
    ->field('category')['options'];

  $selected_category = get('category');

  if (!array_key_exists($selected_category, $category_options)) {
    $selected_category = '';
  }

  $selected_category_name = A::get($category_options, $selected_category);

  $structuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => $selected_category_name ?? 'Alle Rezepte',
    'itemListElement' => []
  ];

  $i = 0;
  foreach ($recipes as $recipe) {
    $is_displayed = !$selected_category || $recipe->category()->toString() === $selected_category;

    if ($is_displayed) {
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
