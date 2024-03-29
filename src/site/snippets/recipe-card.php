<?php

if (isset($recipe)) {
  $image = $image ?? $recipe->image();
  $title = $title ?? $recipe->title()->html();
  $url = $url ?? $recipe->url();
} else {
  $recipe = null;
  $image = isset($image) ? $image : null;
} ?>

<div class="relative z-0 shadow rounded-card aspect-ratio-card transform transition-transform duration-150 ease-in active:scale-95 focus-visible-within:outline-blue select-none">
  <div class="absolute flex items-end w-full h-full overflow-hidden rounded-card">
    <?php if ($image): ?>
      <?php $thumb = $image->thumb(['width' => 400]); ?>
      <img
        src="<?= $thumb->url() ?>"
        width="<?= $thumb->width() ?>"
        height="<?= $thumb->height() ?>"
        x-data="{ loaded: !!($el.complete && $el.naturalWidth && $el.naturalHeight) }"
        class="absolute top-0 object-cover w-full h-full rounded-t-card transition-opacity ease-in -z-1"
        :class="loaded ? 'duration-500' : 'opacity-0'"
        decoding="async"
        loading="lazy"
        @load="loaded = true"
        style="border-bottom-right-radius: 25px; border-bottom-left-radius: 25px;"
      >
    <?php else: ?>
      <div class="absolute top-0 w-full h-full bg-center bg-no-repeat bg-striped -z-1"></div>
    <?php endif; ?>

    <div class="flex items-center w-full h-12 px-3 <?= e($image, 'bg-white') ?>">
      <?php if ($image): ?>
        <a class="italic font-bold stretched-link outline-none" href="<?= $url ?>">
          <?= $title ?>
        </a>
      <?php else: ?>
        <a class="absolute inset-0 flex italic font-bold text-center stretched-link outline-none" href="<?= $url ?>">
          <span class="self-center m-auto"><?= $title ?></span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>