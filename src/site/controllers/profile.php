<?php

return function ($kirby) {
  $user = $kirby->user();

  if (!$user) {
    go('/login');
  }

  return ['user' => $user];
};
