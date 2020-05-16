<?php

use Kirby\Toolkit\A;

return function ($site) {
    $category = get('category');

    $recipes = $site
        ->find('recipes')
        ->children()
        ->listed();

    $category_options = $recipes
        ->first()
        ->blueprint()
        ->field('category')['options'];

    if (!array_key_exists($category, $category_options)) {
        $category = '';
    }

    return [
        'recipes' => $recipes,
        'category_options' => $category_options,
        'selected_category' => $category,
        'selected_category_name' => A::get($category_options, $category),
    ];
};
