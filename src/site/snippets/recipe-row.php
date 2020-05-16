<?php $count = $recipes->count(); ?>

<div class="overflow-hidden">
  <ul class="flex overflow-auto scrolling-touch mx-scroll scrollbar-transparent hover:scrollbar-lightgray">
    <?php foreach ($recipes->limit(r($count <= 4, 4, 3)) as $recipe) : ?>
      <li class="flex-grow flex-shrink-0 w-56 py-2 pr-5 scroll:flex-grow-0 first:ml-5">
        <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
      </li>
    <?php endforeach; ?>

    <?php if ($count < 4) : ?>
      <!-- placeholders for flexbox spacing -->
      <?php for ($i = 0; $i < 4 - $count; $i++) : ?>
        <li class="flex-grow flex-shrink-0 w-56 pr-5 scroll:flex-grow-0 scroll:hidden" aria-hidden="true"></li>
      <?php endfor ?>
    <?php endif ?>

    <?php if (isset($more_url) && $recipes->count() > 4) : ?>
      <li class="flex-grow flex-shrink-0 w-56 py-2 pr-5 scroll:flex-grow-0">
        <?= snippet('recipe-card', ['title' => 'Mehr...', 'url' => $more_url]) ?>
      </li>
    <?php endif; ?>
  </ul>
</div>