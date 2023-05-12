<?= snippet('head', ['body_class' => 'bg-fixed bg-angled-yellow']) ?>


<?= snippet('menu') ?>

<main class="flex-grow px-5 pt-6">
  <div class="pt-4 bg-white shadow rounded-card">
    <h1 class="mb-12 text-xl italic font-bold text-center leading-wide select-none">
      <span class="highlight highlight-rose"><?= $page->title()->html() ?></span>
    </h1>

    <form method="post" action="<?= $page->url() ?>" class="flex flex-col items-center text-rose">
      <p class="mb-8">Möchtest du dein Konto wirklich löschen?<br>Dies kann nicht rückgängig gemacht werden.</p>

      <?php if ($error): ?>
        <p class="mb-8 text-xs leading-tight max-w-form"><?= esc($error) ?></p>
      <?php endif; ?>

      <button class="mb-5 text-black button border-rose bg-rose" type="submit">
        Jetzt löschen
      </button>
    </form>
    <div class="flex flex-col items-center">
      <a href="<?= url('/profile') ?>" class="mb-12 text-black border-rose button">Abbrechen</a>
    </div>
  </div>
</main>
