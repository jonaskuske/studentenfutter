<?php

return function ($kirby, $page) {
  if ($kirby->request()->is('POST')) {
    if ($user = $kirby->user()) {
      try {
        $favorites = $user->favorites()->toPages();

        if (get('favorite') === 'true') {
          $user->update(['favorites' => $favorites->add($page)]);
        } else {
          $user->update(['favorites' => $favorites->remove($page)]);
        }
      } catch (Exception $e) {
        /* Silence is golden. */
      }
    }

    $return_to = get('return_to');
    $page_url = $page->url() . r($return_to, '?return_to=' . $return_to, '');

    go($page_url);
  }
};
