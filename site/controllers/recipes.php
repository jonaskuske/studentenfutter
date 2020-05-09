<?php

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
        $category = null;
    }

    return [
        'recipes' => $recipes,
        'selected_category' => $category,
        'category_options' => $category_options,
    ];
};
