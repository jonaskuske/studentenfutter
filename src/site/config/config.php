<?php

/**
 * All config options:
 * https://getkirby.com/docs/reference/system/options
 */

use Kirby\Http\Server;
use Kirby\Cms\Response;

$is_dev = Server::host() === 'localhost' && Server::port() === 8080;

return [
  'production' => !$is_dev,
  'debug' => $is_dev,
  'bvdputte.fingerprint.query' => true,
  'routes' => [
    [
      'pattern' => 'service-worker.js',
      'action' => function () {
        $path_to_sw = __DIR__ . '/../../assets/js/service-worker.js';

        return Response::file($path_to_sw);
      },
    ],
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
