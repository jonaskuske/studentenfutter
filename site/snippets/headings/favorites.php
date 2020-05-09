<?php $tag = isset($tag) ? $tag : 'h1'; ?>

<<?= $tag ?> class="flex items-center justify-center text-xl italic font-bold leading-wide">
  <span class="mr-3 transform translate-y-1 text-yellow">
    <?= svg('/assets/icons/favorites.svg') ?>
  </span>
  <span class="highlight highlight-yellow">Favoriten</span>
</<?= $tag ?>>