<?php

use Kirby\Cms\Url;

return function ($kirby, $page) {
  $error = false;

  if ($user = $kirby->user()) {
    if ($kirby->request()->is('POST')) {

      if (($name = get('name')) && ($email = get('email'))) {

        try {
          $user->changeName($name);
          $user->changeEmail($email);

          go('/profile');
        } catch (Exception $e) {
          $error = $e->getMessage();
        }
      } else {
        $error = 'Nicht alle Felder ausgefüllt!';
      }
    }
  } else {
    go('/login?r=' . $page->url());
  }

  return ['error' => $error, 'user' => $user];
};
