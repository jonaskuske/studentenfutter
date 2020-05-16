<?php

use Kirby\Cms\Url;

$last = Url::last();
$back_url = r($last != Url::current(), $last);

?>

<?= snippet('head') ?>

<body>
  <?= snippet('menu') ?>

  <main class="pt-6 transition-opacity duration-100 ease-in">

    <div class="flex items-center pl-5 pr-2 mb-6">
      <a
        href="<?= $back_url ? $back_url : $site->find('recipes')->url() ?>"
        class="flex items-center"
        <?= r($back_url, attr([
          'x-data' => '{ active: false }',
          'x-init' => 'history.state !== "start" && history.replaceState("start", document.title);',
          '@click.prevent' => 'active = true; document.querySelector("main").style.opacity = 0; history.back();',
          '@popstate.window' => 'if (active) { active = history.state !== "start"; history.back(); }'
        ])) ?>
      >
        <span class="mr-2 text-blue"><?= svg('/assets/icons/arrow_back.svg') ?></span>
        Zurück
      </a>
      <?php if ($user = $kirby->user()) : ?>
        <?php $is_favorite = $user->favorites()->toPages()->has($page); ?>

        <form action="<?= $page->url() ?>" method="POST" class="ml-auto">
          <input <?= e(!$is_favorite, 'checked') ?> hidden type="checkbox" name="favorite" id="favorite" value="true">
          <button type="submit" class="p-3">
            <span class="text-rose">
              <?= svg('/assets/icons/heart_' . ($is_favorite ? 'filled' : 'empty') . '.svg') ?>
            </span>
          </button>
        </form>
      <?php endif; ?>
    </div>

    <h1 class="px-5 mb-6 text-xl italic font-bold leading-wide">
      <span class="highlight highlight-yellow"><?= $page->title() ?></span>
    </h1>

    <?php if ($page->hasImages()) : ?>
      <?php $gallery = $page->image()->hasNext(); ?>
      <ul class="flex mb-10 overflow-auto scrolling-touch">
        <?php foreach ($page->images() as $image) : ?>
          <li class="flex-shrink-0 py-2 pr-5 <?= e($gallery, 'w-56 first:ml-5', 'w-full pl-5') ?>">
            <picture class="<?= e($gallery, 'aspect-ratio-tall', 'aspect-ratio-wide') ?> relative block overflow-hidden shadow rounded-card">
              <img
                src="<?= $image->thumb(['width' => 900])->url() ?>"
                x-data="{ loaded: true }"
                x-init="loaded = !!($el.complete && $el.naturalWidth && $el.naturalHeight)"
                class="absolute object-cover w-full h-full transition-opacity ease-in"
                :class="loaded ? 'duration-500' : 'opacity-0'"
                @load="loaded = true"
              >
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
        <?php endforeach; ?>
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
        <?php endforeach; ?>
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
                <li class="flex mb-4">
                  <span class="mr-1.5 transform translate-y-px text-blue">
                    <?= svg('/assets/icons/tip.svg') ?>
                  </span>
                  <p><?= $tip->textarea()->kt()->inline() ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php if (!$faqs->isEmpty()) : ?>
            <dl>
              <?php foreach ($faqs as $faq) : ?>
                <dt class="flex mb-1">
                  <span class="mr-1.5 transform translate-y-px text-rose">
                    <?= svg('/assets/icons/question.svg') ?>
                  </span>
                  <p><?= $faq->question()->kt()->inline() ?></p>
                </dt>
                <dd class="flex mb-4">
                  <span class="mr-1.5 transform translate-y-px text-yellow">
                    <?= svg('/assets/icons/answer.svg') ?>
                  </span>
                  <p><?= $faq->answer()->kt()->inline() ?></p>
                </dd>
              <?php endforeach; ?>
            </dl>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <footer class="fixed bottom-0 right-0 w-full px-5 mb-4" style="margin-left:calc(100vw - 100%)">
        <?php
        // On hover: scale icon down and move it to top to make room for text below.
        $classes_icon = 'inline-block transform origin-top transition-transform duration-200 ease-in-out delay-75 md:group-hover:scale-60 group-hover:delay-0';
        // Text centered and absolutely positioned at the bottom, min-width + padding-top
        // so there's always a large enough click/hover target.
        $text_base = 'absolute min-w-32 pt-6 bottom-0 right-1/2 transform translate-x-1/2 translate-y-px text-black text-center text-xs leading-tight whitespace-no-wrap';
        // On hover: make text visible, delay so icon has time to move out of the way.
        $text_transition = 'transition-opacity duration-200 ease-in-out opacity-0 md:group-hover:opacity-100 group-hover:delay-150';
        $classes_text = $text_base . ' ' . $text_transition;
        ?>
        <div class="container flex justify-between px-8 py-2 bg-white shadow rounded-card md:justify-around">
          <a href="#ingredients" class="relative text-rose group">
            <span class="<?= $classes_icon ?>"><?= svg('/assets/icons/ingredients.svg') ?></span>
            <span class="<?= $classes_text ?>">
              Zutaten
            </span>
          </a>
          <a href="#preparation" class="relative text-yellow group">
            <span class="<?= $classes_icon ?>"><?= svg('/assets/icons/preparation.svg') ?></span>
            <span class="<?= $classes_text ?>">
              Zubereitung
            </span>
          </a>
          <a href="#info" class="relative text-blue group">
            <span class="<?= $classes_icon ?>"><?= svg('/assets/icons/info.svg') ?></span>
            <span class="<?= $classes_text ?>">
              Info, Tipps & Tricks
            </span>
          </a>
        </div>
      </footer>
    </div>
  </main>
</body>