<?php

use Kirby\Http\Environment;
use Kirby\Cms\Response;
use Kirby\Filesystem\F;
use Kirby\Toolkit\I18n;

$environment = new Environment();
$is_dev = $environment->host() === 'localhost' && $environment->port() === 8000;

return [
  'url' => ['https://studentenfutter.app', 'http://localhost:8000'],
  'updates' => [
    'kirby' => 'security',
    'plugins' => true
  ],
  'production' => true,
  'debug' => false,
  'hooks' => [
    'route:after' => function () {
      I18n::$locale = 'de';
    }
  ],
  'bvdputte.fingerprint.parameter' => true,
  'sitemap.ignore' => [
    'error',
    'offline',
    'install',
    'favorites',
    'profile',
    'profile/edit',
    'profile/edit-pw',
    'profile/delete'
  ],
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
          $sw_code
        );

        return new Response($sw, $sw_mime);
      }
    ],
    [
      'pattern' => 'logout',
      'action' => function () {
        if ($user = kirby()->user()) {
          $user->logout();
        }

        go('login');
      }
    ],
    [
      'pattern' => 'sitemap',
      'action' => function () {
        return go('sitemap.xml', 301);
      }
    ],
    [
      'pattern' => 'sitemap.xml',
      'action' => function () {
        $pages = site()
          ->pages()
          ->index();

        $recipes_page = $pages->find('recipes');

        $category_options = $recipes_page
          ->children()
          ->listed()
          ->first()
          ->blueprint()
          ->field('category')['options'];

        foreach ($category_options as $option => $option_name) {
          $pages->append(
            $recipes_page->clone([
              'url' => $recipes_page->url(['params' => ['category' => $option]]),
              'id' => $recipes_page->id() . $option,
              'uuid' => $recipes_page->uuid() . $option,
              'slug' => $recipes_page->slug() . $option
            ])
          );
        }

        // fetch the pages to ignore from the config settings,
        // if nothing is set, we ignore the error page
        $ignore = kirby()->option('sitemap.ignore', ['error']);

        $content = snippet('sitemap', compact('pages', 'ignore'), true);

        return new Response($content, 'application/xml');
      }
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
          'title' => $page->title()->toString(),
          'description' => $page->info()->excerpt(160),
          'url' => $page->url(),
          'launchUrl' => $page->url(),
          'icons' => array_map(function ($size) use ($icon) {
            $src = $icon->crop($size, $size)->url();
            return ['src' => $src, 'sizes' => $size . 'x' . $size, 'type' => F::mime($src)];
          }, $sizes)
        ];

        return $response;
      }
    ]
  ]
];
