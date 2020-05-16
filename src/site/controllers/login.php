<?php

use Kirby\Cms\Html;

return function ($kirby) {
  if ($kirby->user()) {
    go('/');
  }

  $error = false;

  if ($kirby->request()->is('POST')) {

    if ($user = $kirby->user(get('email'))) {

      try {
        if (!csrf(get('csrf_token'))) {
          throw new Exception("CSRF Token ungültig.");
        }

        $user->login(get('password'), ['long' => true]);

        go(get('r') ? Html::decode(get('r')) : '/');
      } catch (Exception $e) {
        $error = $e->getMessage();
      }
    } else {
      $error = 'User existiert nicht.';
    }
  }

  return ['error' => $error];
};
