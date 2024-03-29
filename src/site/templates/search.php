<?= snippet('head') ?>

<?= snippet('menu') ?>
<?= snippet('online-banner', ['for' => 'offline']) ?>

<main class="pt-6">
  <section class="mx-5 mb-6">
    <?= snippet('search-form') ?>
  </section>

  <?php if (array_key_exists('q', get())): ?>
    <section class="px-5 select-none">
      <h1 class="mb-6 text-xl italic font-bold text-center leading-wide select-none">
        <span class="highlight highlight-blue"><?= $page->title()->html() ?></span>
      </h1>

      <?php if ($results->isEmpty()): ?>
        <p class="text-center">Keine Ergebnisse.</p>
      <?php else: ?>
        <?= snippet('recipe-list', ['recipes' => $results]) ?>
      <?php endif; ?>
    </section>
  <?php endif; ?>
</main>
