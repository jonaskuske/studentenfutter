<?= snippet('head') ?>
<?= snippet('menu') ?>

<?php $return_to = get('return_to') ?? $site->find('recipes')->url(); ?>

<main class="pt-6">

  <div class="flex items-center pl-5 pr-2 mb-6">
    <a href="<?= $return_to ?>" class="flex items-center">
      <span class="mr-2 text-blue"><?= svg('/assets/icons/arrow_back.svg') ?></span>
      Zurück
    </a>
    <?php if ($user = $kirby->user()) : ?>
      <?php $is_favorite = $user->favorites()->toPages()->has($page); ?>

      <form action="<?= $page->url() ?>" method="POST" class="ml-auto">
        <input hidden type="text" value="<?= esc(get('return_to')) ?>" name="return_to" id="return_to">
        <input hidden type="checkbox" name="favorite" id="favorite" value="true" <?= e(!$is_favorite, 'checked') ?>>
        <button type="submit" class="p-3">
          <span class="text-rose">
            <?= svg('/assets/icons/heart_' . ($is_favorite ? 'filled' : 'empty') . '.svg') ?>
          </span>
        </button>
      </form>
    <?php endif ?>
  </div>

  <h1 class="px-5 mb-6 text-xl italic font-bold leading-wide">
    <span class="highlight highlight-yellow"><?= $page->title() ?></span>
  </h1>

  <?php if ($page->hasImages()) : ?>
    <?php $gallery = $page->image()->hasNext() ?>
    <ul class="flex mb-10 overflow-auto scrolling-touch">
      <?php foreach ($page->images() as $image) : ?>
        <li class="flex-shrink-0 py-2 pr-5 <?= e($gallery, 'w-56 first:ml-5', 'w-full pl-5') ?>">
          <picture class="relative block overflow-hidden shadow rounded-card <?= e($gallery, 'aspect-ratio-tall', 'aspect-ratio-wide') ?>">
            <img class="absolute object-cover w-full h-full" src="<?= $image->thumb(['width' => 900])->url() ?>">
          </picture>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <div class="px-5">
    <h2 class="flex items-center mb-4 text-lg italic leading-loose" id="ingredients">
      <span class="mr-2 transform translate-y-1 text-rose">
        <?= svg('/assets/icons/ingredients.svg') ?>
      </span>
      <span class="highlight highlight-rose">Zutaten</span>
    </h2>

    <ul class="mb-10">
      <?php foreach ($page->ingredients()->toStructure() as $ingredient) : ?>
        <li class="flex mb-4 list-dot">
          <p><?= $ingredient->textarea()->kt()->inline() ?></p>
        </li>
      <?php endforeach ?>
    </ul>

    <h2 class="flex items-center mb-4 text-lg italic leading-loose" id="preparation">
      <span class="mr-2 transform translate-y-1 text-yellow">
        <?= svg('/assets/icons/preparation.svg') ?>
      </span>
      <span class="highlight highlight-yellow">Zubereitung</span>
    </h2>

    <ul class="mb-10">
      <?php foreach ($page->preparation()->toStructure() as $step) : ?>
        <li class="flex mb-4 list-dot">
          <p><?= $step->textarea()->kt()->inline() ?></p>
        </li>
      <?php endforeach ?>
    </ul>

    <?php
    $info = $page->info();
    $tips = $page->tips()->toStructure();
    $faqs = $page->faqs()->toStructure();
    $hasInfoSection = $info || !$tips->isEmpty() || !$faqs->isEmpty();
    ?>

    <?php if ($hasInfoSection) : ?>
      <h2 class="flex items-center mb-4 text-lg italic leading-loose" id="info">
        <span class="mr-2 transform translate-y-1 text-blue">
          <?= svg('/assets/icons/info.svg') ?>
        </span>
        <span class="highlight highlight-blue">Infos, Tipps & Tricks</span>
      </h2>

      <div class="mb-20">
        <?php if ($info) : ?>
          <p class="mb-4 italic"><?= $info->kt()->inline() ?></p>
        <?php endif; ?>

        <?php if (!$tips->isEmpty()) : ?>
          <ul>
            <?php foreach ($tips as $tip) : ?>
              <li class="mb-4 italic">
                <?= $tip->textarea()->kt()->inline() ?>
              </li>
            <?php endforeach ?>
          </ul>
        <?php endif; ?>

        <?php if (!$faqs->isEmpty()) : ?>
          <dl>
            <?php foreach ($faqs as $faq) : ?>
              <dt class="flex mb-1 italic">
                <span class="mr-1 transform translate-y-px text-rose">
                  <?= svg('/assets/icons/question.svg') ?>
                </span>
                <p><?= $faq->question()->kt()->inline() ?></p>
              </dt>
              <dd class="flex mb-4 italic">
                <span class="mr-1 transform translate-y-px text-yellow">
                  <?= svg('/assets/icons/answer.svg') ?>
                </span>
                <p><?= $faq->answer()->kt()->inline() ?></p>
              </dd>
            <?php endforeach; ?>
          </dl>
        <?php endif; ?>
      </div>
    <?php endif ?>

    <footer class="fixed bottom-0 left-0 w-full px-5 mb-4">
      <div class="flex justify-between px-8 py-2 bg-white shadow rounded-card">
        <a href="#ingredients" class="text-rose">
          <?= svg('/assets/icons/ingredients.svg') ?>
        </a>
        <a href="#preparation" class="text-yellow">
          <?= svg('/assets/icons/preparation.svg') ?>
        </a>
        <a href="#info" class="text-blue">
          <?= svg('/assets/icons/info.svg') ?>
        </a>
      </div>
    </footer>
  </div>
</main>