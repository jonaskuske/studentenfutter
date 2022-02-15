<?php

require __DIR__ . '/kirby/bootstrap.php';

$kirby = new Kirby([
  'roots' => [
    'license' => __DIR__ . '/site/license/.license'
  ]
]);

echo $kirby->render();
