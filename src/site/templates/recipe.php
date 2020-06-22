<?php

use Kirby\Cms\Url;

$last = Url::last();
$back_url = r($last != Url::current(), $last);
?>

<?= snippet('head', ['page_description' => $page->info()->excerpt(160)]) ?>
<?= snippet('install-banner') ?>

  <?= snippet('menu') ?>

<main class="pt-2 transition-opacity duration-100 ease-in">

  <div class="flex items-center pl-5 pr-2 mb-2">
    <a
      href="<?= $back_url ? $back_url : $site->find('recipes')->url() ?>"
      class="flex items-center"
      <?= r(
        $back_url,
        attr([
          'x-data' => '{ active: false }',
          'x-init' => 'history.state !== "start" && history.replaceState("start", document.title);',
          '@click.prevent' =>
            'active = true; document.querySelector("main").style.opacity = 0; history.back();',
          '@popstate.window' =>
            'if (active) { active = history.state !== "start"; history.back(); }',
        ]),
      ) ?>
    >
      <span class="mr-2 text-blue"><?= svg('/assets/icons/arrow_back.svg') ?></span>
      Zurück
    </a>

    <div
      class="flex items-center h-12 ml-auto"
      x-data="favorite(<?= e($isFavorite, 'true', 'false') ?>)"
      @online.window="online = true"
      @offline.window="online = false"
    >
    <?php if ($user): ?>
        <form
          x-cloak
          x-show="online"
          @submit="submit($event)"
          action="<?= $page->url() ?>"
          method="POST"
        >
          <input
            <?= e(!$isFavorite, 'checked') ?>
            :checked="!isFavorite"
            hidden
            type="checkbox"
            name="favorite"
            id="favorite"
            value="true"
          >
          <button type="submit" class="p-3">
            <span class="text-rose" x-show="isFavorite" <?= e(!$isFavorite, 'x-cloak') ?>>
              <?= svg('/assets/icons/heart_filled.svg') ?>
            </span>
            <span class="text-rose" x-show="!isFavorite" <?= e($isFavorite, 'x-cloak') ?>>
              <?= svg('/assets/icons/heart_empty.svg') ?>
            </span>
          </button>
        </form>
        <?php endif; ?>
        <div x-cloak x-show="!online" class="flex items-center mr-3 group">
          <span class="duration-500 opacity-0 select-none group-hover:opacity-100 text-lightgray">
            Offline-Ansicht
          </span>
          <div class="flex-shrink-0 w-6 ml-2 text-rose">
            <?= svg('assets/icons/offline.svg') ?>
          </div>
        </div>
      </div>
  </div>

  <h1 class="px-5 mb-6 text-xl italic font-bold leading-wide">
    <span class="highlight highlight-yellow"><?= $page->title() ?></span>
  </h1>

  <?php if ($images->isNotEmpty()): ?>
    <?php $gallery = $images->count() > 1; ?>
    <ul class="flex mb-10 overflow-auto scrolling-touch">
      <?php foreach ($images as $image): ?>
        <li class="flex-shrink-0 py-2 pr-5 <?= e($gallery, 'w-56 first:ml-5', 'w-full pl-5') ?>">
          <picture
            class="<?= e(
              $gallery,
              'aspect-ratio-tall',
              'aspect-ratio-wide',
            ) ?> relative block overflow-hidden shadow rounded-card"
          >
            <img
              src="<?= $image->url() ?>"
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

  <div class="px-5 pb-20">
    <section class="js-observed" id="ingredients">
      <h2 class="flex items-center mb-4 text-lg italic leading-loose">
        <span class="mr-2 transform translate-y-1 text-rose">
          <?= svg('/assets/icons/ingredients.svg') ?>
        </span>
        <span class="highlight highlight-rose">Zutaten</span>
      </h2>

      <ul class="mb-10">
        <?php foreach ($page->ingredients()->toStructure() as $ingredient): ?>
          <li class="flex mb-4 list-dot">
            <p>
              <?= $ingredient
                ->textarea()
                ->kt()
                ->inline() ?>
            </p>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>

    <section class="js-observed" id="preparation">
      <h2 class="flex items-center mb-4 text-lg italic leading-loose">
       <span class="mr-2 transform translate-y-1 text-yellow">
         <?= svg('/assets/icons/preparation.svg') ?>
        </span>
       <span class="highlight highlight-yellow">Zubereitung</span>
      </h2>

      <ul class="mb-10">
        <?php foreach ($page->preparation()->toStructure() as $step): ?>
          <li class="flex mb-4 list-dot">
            <p>
              <?= $step
                ->textarea()
                ->kt()
                ->inline() ?>
            </p>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>

    <?php
    $info = $page->info();
    $tips = $page->tips()->toStructure();
    $faqs = $page->faqs()->toStructure();
    $hasInfoSection = $info || !$tips->isEmpty() || !$faqs->isEmpty();
    ?>

    <?php if ($hasInfoSection): ?>
      <section class="js-observed" id="info">
        <h2 class="flex items-center mb-4 text-lg italic leading-loose">
          <span class="mr-2 transform translate-y-1 text-blue">
            <?= svg('/assets/icons/info.svg') ?>
          </span>
          <span class="highlight highlight-blue">Infos, Tipps & Tricks</span>
        </h2>

        <div class="mb-10">
          <?php if ($info): ?>
            <p class="mb-4 italic"><?= $info->kt()->inline() ?></p>
          <?php endif; ?>

          <?php if (!$tips->isEmpty()): ?>
            <ul>
              <?php foreach ($tips as $tip): ?>
                <li class="flex mb-4">
                  <span class="mr-1.5 transform translate-y-px text-blue">
                    <?= svg('/assets/icons/tip.svg') ?>
                  </span>
                  <p>
                    <?= $tip
                      ->textarea()
                      ->kt()
                      ->inline() ?>
                  </p>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php if (!$faqs->isEmpty()): ?>
            <dl>
              <?php foreach ($faqs as $faq): ?>
                <dt class="flex mb-1">
                  <span class="mr-1.5 transform translate-y-px text-rose">
                    <?= svg('/assets/icons/question.svg') ?>
                  </span>
                  <p>
                    <?= $faq
                      ->question()
                      ->kt()
                      ->inline() ?>
                  </p>
                </dt>
                <dd class="flex mb-4">
                  <span class="mr-1.5 transform translate-y-px text-yellow">
                    <?= svg('/assets/icons/answer.svg') ?>
                  </span>
                  <p>
                    <?= $faq
                      ->answer()
                      ->kt()
                      ->inline() ?>
                  </p>
                </dd>
              <?php endforeach; ?>
            </dl>
          <?php endif; ?>
        </div>
      </section>
    <?php endif; ?>

    <div
      class="flex justify-center mb-10"
      x-data="{
        canShare: 'share' in navigator,
        shareData: {
          title: '<?= esc($page->title(), 'js') ?>',
          url: '<?= esc($page->url(), 'js') ?>'
        }
      }"
      x-show="canShare"
    >
      <button class="text-black button border-rose" @click="navigator.share(shareData)">Teilen</button>
    </div>

    <footer class="fixed bottom-0 right-0 w-full px-5 mb-4" style="margin-left:calc(100vw - 100%)">
      <?php
      $classes_icon =
        'inline-block transform origin-top transition-transform duration-200 ease-in-out delay-75 can-hover:group-hover:scale-60 group-hover:delay-0'; // Text centered and absolutely positioned at the bottom, min-width + padding-top // so there's always a large enough click/hover target.
      $text_base =
        'absolute min-w-32 pt-6 bottom-0 right-1/2 transform translate-x-1/2 translate-y-px text-black text-center text-xs leading-tight whitespace-no-wrap'; // On hover: make text visible, delay so icon has time to move out of the way.
      $text_transition =
        'transition-opacity duration-200 ease-in-out opacity-0 can-hover:group-hover:opacity-100 group-hover:delay-150';
      $classes_text = $text_base . ' ' . $text_transition;
      ?>
      <div class="container flex justify-between px-8 py-2 bg-white shadow rounded-card md:justify-around">
        <a href="#ingredients" class="relative text-rose text-lightgray group">
          <span class="<?= $classes_icon ?>"><?= svg('/assets/icons/ingredients.svg') ?></span>
          <span class="<?= $classes_text ?>">
            Zutaten
          </span>
        </a>
        <a href="#preparation" class="relative text-yellow text-lightgray group">
          <span class="<?= $classes_icon ?>"><?= svg('/assets/icons/preparation.svg') ?></span>
          <span class="<?= $classes_text ?>">
            Zubereitung
          </span>
        </a>
        <a href="#info" class="relative text-blue text-lightgray group">
          <span class="<?= $classes_icon ?>"><?= svg('/assets/icons/info.svg') ?></span>
          <span class="<?= $classes_text ?>">
            Info, Tipps & Tricks
          </span>
        </a>
      </div>
    </footer>
  </div>
</main>
