<?php

return function ($site) {
    $query = get('q');

    $results = $site
        ->find('recipes')
        ->children()
        ->listed()
        ->search($query, 'title');

    return ['query' => $query, 'results' => $results];
};
