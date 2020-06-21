<?= snippet('head', ['body_class' => 'h-full']) ?>

<?= snippet('menu') ?>

<main class="flex flex-col flex-grow px-5 py-6">
  <h1 class="text-xl italic font-bold text-center leading-wide">
    <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
  </h1>

  <div class="m-auto">
    <p class="mb-6 font-bold text-center">
      Da ist etwas schiefgelaufen. Die Seite konnte nicht geladen werden.
    </p>
    <p class="text-center">
      <a href="<?= $site->homePage()->url() ?>" class="button border-rose">Zurück zur Startseite</a>
    </p>
  </div>
</main>
