<?php

return function ($site) {
    $query = get('q');

    $results = $site
        ->find('recipes')
        ->children()
        ->listed()
        ->search($query, 'title|tags');

    return ['query' => $query, 'results' => $results];
};
