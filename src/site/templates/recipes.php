<?= snippet('head', ['page_title' => $selected_category_name]) ?>

<script type="application/ld+json">
<?= json_encode($structuredData) ?>
</script>

<?= snippet('menu') ?>
<?= snippet('install-banner') ?>
<?= snippet('online-banner', ['for' => 'offline']) ?>

<main class="pt-6">
  <h1 class="mb-4 text-xl italic font-bold text-center leading-wide select-none">
    <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
  </h1>

  <form action="" class="mb-6 text-center text-blue">
    <label class="select-none">Filter:
      <select class="outline-none border-b-3 border-dashed border-transparent focus-visible:border-blue focus:text-black" name="category" id="category" onchange="this.form.submit()">
        <?php foreach ($category_options as $category => $category_name): ?>
          <option value="<?= $category ?>" <?= e($category === $selected_category, 'selected') ?>>
            <?= $category_name ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
  </form>

  <hr class="w-24 m-auto mb-6 border-t-0 border-b-8 border-dotted border-circles-rose text-rose">

  <section class="px-5 select-none">
    <?php foreach ($category_options as $category => $category_name): ?>
      <?php if ($category && (!$selected_category || $selected_category === $category)): ?>
        <?php $category_recipes = $recipes->filterBy('category', $category); ?>

        <div class="mb-6">
          <?= snippet(['headings/' . $category, 'headings/default'], ['text' => $category_name]) ?>
        </div>

        <?php if ($category_recipes->isEmpty()): ?>
          <p class="mb-6 text-center">Keine Rezepte in der Kategorie <?= $category_name ?>.</p>
        <?php else: ?>
          <?= snippet('recipe-list', ['recipes' => $category_recipes]) ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </section>
</main>
