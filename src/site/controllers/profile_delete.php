<?php

use Kirby\Cms\Url;
use Kirby\Exception\Exception;

return function ($kirby, $page) {
  $error = false;

  if ($user = $kirby->user()) {
    if ($kirby->request()->is('POST')) {
      try {
        if (!$user->delete()) {
          throw new Exception('Löschen fehlgeschlagen.');
        }

        go('/login');
      } catch (Exception $e) {
        $error = $e->getMessage();
      }
    }
  } else {
    go('/login?r=' . $page->url());
  }

  return ['error' => $error, 'user' => $user];
};
