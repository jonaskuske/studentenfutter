<?= snippet('header') ?>

<?= snippet('menu') ?>

<?php $recipes = $page->children()->listed(); ?>

<h2>Suche</h2>

<h2>Favoriten</h2>

<h2>Salate & Suppen</h2>

<h2>Hauptgerichte</h2>

<h2>Süßes</h2>

<h2>Quickies</h2>



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