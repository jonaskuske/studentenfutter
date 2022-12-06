<?= snippet('head', ['body_class' => 'h-full']) ?>

<?= snippet('menu') ?>

<main class="flex flex-col flex-grow px-5 py-6">
  <h1 class="text-xl italic font-bold text-center leading-wide select-none">
    <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
  </h1>

  <div class="m-auto">
    <p class="mb-6 font-bold text-center select-none">
      Da ist etwas schiefgelaufen.
      Die Seite <?= r(
        $kirby->response()->code() === 404,
        'wurde nicht gefunden',
        'konnte nicht geladen werden'
      ) ?>.
      (<?= $kirby->response()->code() ?>)
    </p>
    <p class="text-center">
      <a href="<?= $site->homePage()->url() ?>" class="button border-rose">Zurück zur Startseite</a>
    </p>
  </div>
</main>
