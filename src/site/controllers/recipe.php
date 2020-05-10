<?php

return function ($kirby, $page) {
  if ($kirby->request()->is('POST')) {
    if ($user = $kirby->user()) {
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

    $return_to = get('return_to');
    $page_url = $page->url() . r($return_to, '?return_to=' . $return_to, '');

    go($page_url);
  }
};
