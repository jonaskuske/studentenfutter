<?= snippet('header') ?>
<?= snippet('menu') ?>

<main class="pt-6">
  <h2 class="mb-4 text-xl italic font-bold text-center">
    <span class="highlight highlight-yellow"><?= $page->title() ?></span>
  </h2>

  <form action="" class="mb-6 text-center text-blue">
    <select name="category" id="category" onchange="this.form.submit()" value="<?= $category ?>">
      <option value="">Alle Rezepte</option>
      <?php foreach ($category_options as $value => $name) : ?>
        <option value="<?= $value ?>" <?= $value === $category ? 'selected' : '' ?>><?= $name ?></option>
      <?php endforeach ?>
    </select>
  </form>

  <hr class="w-20 m-auto mb-6 border-t-0 border-b-4 border-dotted border-rose">

  <?php foreach ($category_options as $value => $name) : ?>
    <?php if (!$category || $category === $value) : ?>
      <h2 class="mb-6 text-xl italic font-bold text-center">
        <span class="highlight highlight-rose"><?= $name ?></span>
      </h2>

      <?php if ($recipes->filterBy('category', $value)->isEmpty()) : ?>
        <p class="mb-6 text-center">Keine Rezepte in der Kategorie <?= $name ?>.</p>
      <?php else : ?>
        <ul class="flex flex-col items-center mb-6 space-y-8">
          <?php foreach ($recipes->filterBy('category', $value) as $recipe) : ?>
            <li>
              <?= snippet(('recipe-card'), ['recipe' => $recipe]) ?>
            </li>
          <?php endforeach ?>
        </ul>
      <?php endif ?>
    <?php endif ?>
  <?php endforeach ?>
</main>