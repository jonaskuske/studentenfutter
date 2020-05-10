<?= snippet('head') ?>
<?= snippet('menu') ?>

<main class="pt-6">
  <section class="mx-5 mb-6">
    <?= snippet('search-form') ?>
  </section>

  <section class="mb-12">
    <div class="mb-6"><?= snippet('headings/favorites', ['tag' => 'h2']) ?></div>

    <?php if ($user = $kirby->user()) : ?>
      <?php if ($user->favorites()->toPages()->isEmpty()) : ?>
        <p class="px-5 text-center">Hallo, <?= esc($user->name()) ?>!<br>
          Du hast noch keine Favoriten gespeichert.</p>
      <?php else : ?>
        <ul class="flex overflow-auto scrolling-touch">
          <?php foreach ($user->favorites()->toPages() as $recipe) : ?>
            <li class="flex-shrink-0 w-56 py-2 pr-5 first:ml-5">
              <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    <?php else : ?>
      <p class="px-5 text-center">
        <a href="<?= url('/login') ?>" class="underline text-blue">Anmelden</a>,
        um eigene Favoriten zu speichern.
      </p>
    <?php endif ?>
  </section>

  <?php foreach ($category_options as $category => $category_name) : ?>
    <section class="mb-12">
      <div class="mb-6">
        <?= snippet(['headings/' . $category, 'headings/default'], ['text' => $category_name]) ?>
      </div>

      <?php $category_recipes = $recipes->filterBy('category', $category); ?>

      <?php if ($category_recipes->isEmpty()) : ?>
        <p class="px-5 text-center">Keine Rezepte vorhanden.</p>
      <?php else : ?>
        <ul class="flex overflow-auto scrolling-touch">
          <?php foreach ($category_recipes->limit(3) as $recipe) : ?>
            <li class="flex-shrink-0 w-56 py-2 pr-5 first:ml-5">
              <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
            </li>
          <?php endforeach; ?>

          <?php if ($category_recipes->count() > 3) : ?>
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