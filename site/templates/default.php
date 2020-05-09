<?= snippet('head') ?>
<?= snippet('menu') ?>

<h1><?= $page->title() ?></h1>

<main>
  <?= $page->editor()->blocks() ?>
</main>