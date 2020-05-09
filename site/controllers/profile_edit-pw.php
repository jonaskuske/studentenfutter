<?php

use Kirby\Cms\Url;

return function ($kirby) {
  $error = false;

  if ($user = $kirby->user()) {
    if ($kirby->request()->is('POST')) {

      if (($old_pw = get('old_password')) && ($pw = get('password'))) {

        try {
          $user->validatePassword($old_pw);
          $user->changePassword($pw);

          go('/profile');
        } catch (Exception $e) {
          $error = $e->getMessage();
        }
      } else {
        $error = 'Nicht alle Felder ausgefüllt!';
      }
    }
  } else {
    go('/login?return_to=' . Url::current());
  }

  return ['error' => $error, 'user' => $user];
};
