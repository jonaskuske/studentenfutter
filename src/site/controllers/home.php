<?php

return function ($site) {
  $recipes = $site
    ->find('recipes')
    ->children()
    ->listed();

  $category_options = $recipes
    ->first()
    ->blueprint()
    ->field('category')['options'];


  return [
    'recipes' => $recipes,
    'category_options' => $category_options,
  ];
};
