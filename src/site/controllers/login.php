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
        $user->login(get('password'), ['long' => true]);

        go(get('return_to') ? Html::decode(get('return_to')) : '/');
      } catch (Exception $e) {
        $error = $e->getMessage();
      }
    } else {
      $error = 'User existiert nicht.';
    }
  }

  return ['error' => $error];
};
