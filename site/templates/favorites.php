<?= snippet('head') ?>
<?= snippet('menu') ?>

<?php $favorites = pages([]); ?>

<main class="pt-6">
  <div class="mb-6">
    <?= snippet('headings/favorites') ?>
  </div>

  <section class="px-5">
    <?php if ($favorites->isEmpty()): ?>
      <p class="mb-6 text-center">Noch keine Favoriten vorhanden.</p>
    <?php else: ?>
      <ul class="flex flex-col items-center mb-6 space-y-8">
        <?php foreach ($favorites as $recipe): ?>
          <li class="w-full">
            <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
</main>
