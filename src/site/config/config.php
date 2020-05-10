<?php

/**
 * All config options:
 * https://getkirby.com/docs/reference/system/options
 */

use Kirby\Http\Server;

$is_dev = Server::host() === 'localhost' && Server::port() === 8080;

return [
  'production' => !$is_dev,
  'debug' => $is_dev,
  'routes' => [
    [
      'pattern' => 'logout',
      'action' => function () {
        if ($user = kirby()->user()) {
          $user->logout();
        }

        go('login');
      },
    ],
  ],
];
