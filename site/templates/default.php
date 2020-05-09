<?= snippet('head') ?>
<?= snippet('menu') ?>

<h1><?= $page->title()->html() ?></h1>

<main>
  <?= $page->editor()->blocks() ?>
</main>