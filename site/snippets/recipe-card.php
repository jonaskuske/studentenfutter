<?php
if (isset($recipe)) {
  $image = $image ?? $recipe->image();
  $title = $title ?? $recipe->title()->html();
  $url = $url ?? $recipe->url() . '?return_to=' . Url::current();
} else {
  $recipe = null;
  $image = isset($image) ? $image : null;
} ?>

<div class="relative shadow rounded-large aspect-ratio-card" x-data="{ isFavorite: false }">
  <div class="absolute flex items-end w-full h-full overflow-hidden rounded-large">
    <?php if ($image) : ?>
      <img src="<?= $image->thumb(['width' => 400])->url() ?>" class="absolute object-cover w-full h-full -z-1" style="border-bottom-right-radius: 25px; border-bottom-left-radius: 25px">
    <?php else : ?>
      <div class="absolute w-full h-full bg-center bg-no-repeat bg-striped -z-1"></div>
    <?php endif; ?>

    <div class="flex items-center w-full h-12 pl-3 pr-1 <?= e($image, 'bg-white') ?>">
      <?php if ($image) : ?>
        <a class="italic font-bold stretched-link" href="<?= $url ?>">
          <?= $title ?>
        </a>
      <?php else : ?>
        <a class="absolute left-0 w-full italic font-bold text-center transform -translate-y-1/2 stretched-link top-1/2" href="<?= $url ?>">
          <?= $title ?>
        </a>
      <?php endif; ?>

      <?php if ($recipe) : ?>
        <button @click="isFavorite = !isFavorite" class="z-10 p-3 ml-auto">
          <span x-show="!isFavorite" class="text-rose">
            <?= svg('/assets/icons/heart_empty.svg') ?>
          </span>
          <span x-show="isFavorite" class="text-rose">
            <?= svg('/assets/icons/heart_filled.svg') ?>
          </span>
        </button>
      <?php endif; ?>
    </div>
  </div>
</div>