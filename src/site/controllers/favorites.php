<?php

use Kirby\Toolkit\A;

return function ($kirby, $site, $page) {
  $user = $kirby->user();

  if ($user) {
    $favorites = $user->favorites()->toPages();

    $dependencies = $favorites->pluck('url');
    $kirby->response->header('X-SW-Dependencies', A::join($dependencies));

    return compact('favorites');
  } else {
    go('login?r=' . $page->url());
  }
};
