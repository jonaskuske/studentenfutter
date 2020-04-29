<?= snippet('header') ?>

<h1><?= $site->title() ?></h1>

<?php $recipes = $page->children()->listed(); ?>

<main>
  <?php if ($recipes->isEmpty()) : ?>
    <p>Keine Rezepte.</p>
  <?php else : ?>
    <ul>
      <?php foreach ($recipes as $recipe) : ?>
        <li>
          <a href="<?= $recipe->url() ?>">
            <?= $recipe->title() ?>
            <br>
            <?= $recipe->category() ?>
            <?= $recipe->image() ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</main>