<ul class="flex flex-col items-center grid-cols-2 col-gap-8 sm:grid sm:mb-8 lg:grid-cols-3">
  <?php foreach ($recipes as $recipe) : ?>
    <li class="w-full mb-8">
      <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
    </li>
  <?php endforeach; ?>
</ul>