<?php if (!$kirby->user()) {
  go('/login?r=' . $page->url());
} ?>

<?= snippet('head') ?>
<?= snippet('install-banner') ?>

  <?= snippet('menu') ?>

  <?php $favorites = $kirby->user()->favorites()->toPages(); ?>

  <main class="pt-6">
    <div class="mb-6">
      <?= snippet('headings/favorites') ?>
    </div>

    <section class="px-5">
      <?php if ($favorites->isEmpty()) : ?>
        <p class="mb-4 text-center">
          Noch keine Favoriten gespeichert.
        </p>
        <p class="text-center">
            Tippe bei einem Rezept auf das Herz, um es zu deinen Favoriten hinzuzufügen.
            <span x-data x-show="'serviceWorker' in navigator">
              <br class="hidden sm:inline">Es ist dann auch offline verfügbar.
            </span>
        </p>
      <?php else : ?>
        <?= snippet('recipe-list', ['recipes' => $favorites]) ?>
      <?php endif; ?>
    </section>
  </main>
