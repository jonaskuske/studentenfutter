<?= snippet('head') ?>
<?= snippet('menu') ?>

<?php $favorites = pages([]);
/* TODO */
?>

<main class="pt-6">
  <section class="mx-5 mb-6">
    <?= snippet('search-form') ?>
  </section>

  <section class="mb-12">
    <div class="mb-6"><?= snippet('headings/favorites') ?></div>

    <div class="flex px-5 py-2 space-x-5 overflow-auto">
      <?php if ($favorites->isEmpty()): ?>
        <p class="m-auto">Noch keine Favoriten vorhanden.</p>
      <?php else: ?>
        <?php foreach ($favorites as $recipe): ?>
          <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <div class="mb-12 text-blue"><?= snippet('divider') ?></div>

  <?php foreach ($category_options as $category => $category_name): ?>
    <section class="mb-12">
      <div class="mb-6">
        <?= snippet(['headings/' . $category, 'headings/default'], ['text' => $category_name]) ?>
      </div>

      <?php $category_recipes = $recipes->filterBy('category', $category); ?>

      <?php if ($category_recipes->isEmpty()): ?>
        <p class="px-5 text-center">Keine Rezepte vorhanden.</p>
      <?php else: ?>
        <ul class="flex overflow-auto scrolling-touch">
          <?php foreach ($category_recipes->limit(3) as $recipe): ?>
            <li class="flex-shrink-0 w-56 py-2 pr-5 first:ml-5">
              <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
            </li>
          <?php endforeach; ?>

          <?php if ($category_recipes->count() > 3): ?>
            <li class="flex-shrink-0 w-56 py-2 pr-5">
              <?= snippet('recipe-card', [
                'title' => 'Mehr...',
                'url' => $site->find('recipes')->url() . '?category=' . $category,
              ]) ?>
            </li>
          <?php endif; ?>
        <?php endif; ?>
        </div>
    </section>
  <?php endforeach; ?>
</main>