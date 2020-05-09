<?= snippet('head') ?>
<?= snippet('menu') ?>

<main class="pt-6">
  <h1 class="mb-4 text-xl italic font-bold text-center leading-wide">
    <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
  </h1>

  <form action="" class="mb-6 text-center text-blue">
    <label>Filter:
      <select name="category" id="category" onchange="this.form.submit()">
        <option value="">Alle Rezepte</option>
        <?php foreach ($category_options as $category => $category_name) : ?>
          <option value="<?= $category ?>" <?= e($category === $selected_category, 'selected') ?>>
            <?= $category_name ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
  </form>

  <hr class="w-20 m-auto mb-6 border-t-0 border-b-4 border-dotted text-rose">

  <section class="px-5">
    <?php foreach ($category_options as $category => $category_name) : ?>
      <?php if ($selected_category === $category || !$selected_category) : ?>
        <?php $category_recipes = $recipes->filterBy('category', $category); ?>

        <div class="mb-6">
          <?= snippet(['headings/' . $category, 'headings/default'], ['text' => $category_name]) ?>
        </div>

        <?php if ($category_recipes->isEmpty()) : ?>
          <p class="mb-6 text-center">Keine Rezepte in der Kategorie <?= $category_name ?>.</p>
        <?php else : ?>
          <ul class="flex flex-col items-center mb-6 space-y-8">
            <?php foreach ($category_recipes as $recipe) : ?>
              <li class="w-full">
                <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </section>
</main>