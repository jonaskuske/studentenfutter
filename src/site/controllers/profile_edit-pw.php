<?php

return function ($kirby, $page) {
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
    go('/login?r=' . $page->url());
  }

  return ['error' => $error, 'user' => $user];
};
