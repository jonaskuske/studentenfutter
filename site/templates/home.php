<h1><?= $site->title() ?></h1>

<main>
  <ul>
    <?php foreach ($page->children()->listed() as $recipe): ?>
<li>
  <a href="<?= $recipe->url() ?>">
<?= $recipe->title() ?>
<br>
<?= $recipe->category() ?>
<?= $recipe->image() ?>
</a>
</li>
      <?php endforeach ?>
  </ul>
</main>