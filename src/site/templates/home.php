<?= snippet('head') ?>

  <?= snippet('menu') ?>
  <?= snippet('install-banner') ?>
  <?= snippet('online-banner', ['for' => 'offline']) ?>

  <main class="pt-6">
    <section class="mx-5 mb-6">
      <?= snippet('search-form') ?>
    </section>

    <section class="mb-12">
      <div class="mb-6"><?= snippet('headings/favorites', ['tag' => 'h2']) ?></div>

      <?php if ($user = $kirby->user()): ?>
        <?php if (($favorites = $user->favorites()->toPages())->isEmpty()): ?>
          <p class="px-5 text-center">
            <?php if ($name = $user->name()->toString()): ?>
              Hallo, <?= esc($name) ?>!<br>
            <?php endif; ?>
            Du hast noch keine Favoriten gespeichert.
          </p>
        <?php else: ?>
          <?= snippet('recipe-row', [
            'recipes' => $favorites,
            'more_url' => url('/favorites')
          ]) ?>
        <?php endif; ?>
      <?php else: ?>
        <p class="px-5 text-center">
          <a href="<?= url('/login') ?>" class="underline text-blue">Anmelden</a>,
          um eigene Favoriten zu speichern.
        </p>
      <?php endif; ?>
    </section>

    <?php foreach ($category_options as $category => $category_name): ?>
      <section class="mb-12">
        <div class="mb-6">
          <?= snippet(['headings/' . $category, 'headings/default'], ['text' => $category_name]) ?>
        </div>

        <?php $category_recipes = $recipes->filterBy('category', $category); ?>

        <?php if ($category_recipes->isEmpty()): ?>
          <p class="px-5 text-center">Keine Rezepte vorhanden.</p>
        <?php else: ?>
          <?= snippet('recipe-row', [
            'recipes' => $category_recipes,
            'more_url' => $site->find('recipes')->url() . '?category=' . $category
          ]) ?>
        <?php endif; ?>
      </section>
    <?php endforeach; ?>
  </main>
