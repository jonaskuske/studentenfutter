<?php

use Kirby\Http\Server;
use Kirby\Cms\Response;
use Kirby\Toolkit\F;

$is_dev = Server::host() === 'localhost' && Server::port() === 8080;

return [
  'production' => !$is_dev,
  'debug' => $is_dev,
  'bvdputte.fingerprint.query' => true,
  'routes' => [
    [
      'pattern' => 'service-worker.js',
      'action' => function () {
        require_once __DIR__ . '/asset-manifest.php';

        $sw_path = __DIR__ . '/../../assets/js/service-worker.js';
        $sw_mime = F::extensionToMime(F::extension($sw_path));
        $sw_code = F::read($sw_path);

        $sw = preg_replace(
          ['/__ASSET_HASH__/', '/__ASSET_MANIFEST__/'],
          [$asset_hash, $asset_manifest],
          $sw_code,
        );

        return new Response($sw, $sw_mime);
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
    [
      'pattern' => 'content-index/(:all)',
      'action' => function ($id) {
        $page = page($id);

        if (!$page) {
          return null;
        }

        $sizes = [128, 256, 512, 1024];
        $icon = $page->image() ?? asset('assets/meta/sharing-image.png');

        $response = [
          'id' => $page->id(),
          'title' => $page->title(),
          'description' => $page->info()->excerpt(160),
          'url' => $page->url(),
          'launchUrl' => $page->url(),
          'icon' => array_map(function ($size) use ($icon) {
            $src = $icon->crop($size, $size)->url();
            return ['src' => $src, 'sizes' => $size . 'x' . $size, 'type' => F::mime($src)];
          }, $sizes),
        ];

        return $response;
      },
    ],
  ],
];
