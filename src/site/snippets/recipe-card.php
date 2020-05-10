<?php

use Kirby\Cms\Url;

if (isset($recipe)) {
  $image = $image ?? $recipe->image();
  $title = $title ?? $recipe->title()->html();
  $url = $url ?? $recipe->url() . '?return_to=' . Url::current();
} else {
  $recipe = null;
  $image = isset($image) ? $image : null;
} ?>

<div class="relative shadow rounded-card aspect-ratio-card" x-data="{ isFavorite: false }">
  <div class="absolute flex items-end w-full h-full overflow-hidden rounded-card">
    <?php if ($image) : ?>
      <img src="<?= $image->thumb(['width' => 400])->url() ?>" class="absolute object-cover w-full h-full -z-1" style="border-bottom-right-radius: 25px; border-bottom-left-radius: 25px">
    <?php else : ?>
      <div class="absolute w-full h-full bg-center bg-no-repeat bg-striped -z-1"></div>
    <?php endif; ?>

    <div class="flex items-center w-full h-12 px-3 <?= e($image, 'bg-white') ?>">
      <?php if ($image) : ?>
        <a class="italic font-bold stretched-link" href="<?= $url ?>">
          <?= $title ?>
        </a>
      <?php else : ?>
        <a class="absolute inset-0 flex italic font-bold text-center stretched-link" href="<?= $url ?>">
          <span class="m-auto"><?= $title ?></span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>