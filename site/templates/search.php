<?= snippet('header') ?>
<?= snippet('menu') ?>

<main class="pt-6">
  <section class="mx-5 mb-6">
    <?= snippet('search-form') ?>
  </section>

  <section>
    <h2 class="mb-6 text-xl italic font-bold leading-loose text-center">
      <span class="highlight highlight-blue"><?= $page->title() ?></span>
    </h2>

    <?php if (!$results->isEmpty()) : ?>
      <ul class="flex flex-col items-center space-y-8">
        <?php foreach ($results as $result) : ?>
          <li>
            <?= snippet('recipe-card', ["recipe" => $result]) ?>
          </li>
        <?php endforeach ?>
      </ul>
    <?php else : ?>
      <p class="text-center">Keine Ergebnisse.</p>
    <?php endif ?>
  </section>
</main>