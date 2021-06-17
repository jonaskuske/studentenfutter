<?php

return function ($kirby) {
  if ($kirby->user()) {
    go('/profile');
  }

  $error = false;

  if ($kirby->request()->is('POST')) {
    if (($name = get('name')) && ($email = get('email')) && ($password = get('password'))) {
      $kirby->impersonate('kirby');

      $users = $kirby->users();

      try {
        $user = $users->create([
          'name' => $name,
          'email' => $email,
          'password' => $password,
          'language' => 'de',
          'role' => 'User'
        ]);

        $user->login($password);

        go('/profile');
      } catch (Exception $e) {
        $error = $e->getMessage();
      }
    } else {
      $error = 'Nicht alle Felder sind ausgefüllt.';
    }
  }

  $kirby->impersonate();

  return [
    'error' => $error
  ];
};
