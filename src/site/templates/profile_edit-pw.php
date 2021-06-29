<?= snippet('head', ['body_class' => 'bg-fixed bg-angled-yellow']) ?>


<?= snippet('menu') ?>

<main class="flex-grow px-5 pt-6">
  <div class="pt-4 bg-white shadow rounded-card">
    <h1 class="mb-12 text-xl italic font-bold text-center leading-wide">
      <span class="highlight highlight-rose"><?= $page->title()->html() ?></span>
    </h1>

    <form method="post" action="<?= $page->url() ?>" class="flex flex-col items-center text-rose">
      <div class="flex items-center w-full mx-auto mb-8 border-b-8 border-dotted border-circles-rose max-w-form border-rose">
        <span class="w-8">
          <?= svg('/assets/icons/input_password.svg') ?>
        </span>
        <input
          class="mb-1 placeholder-rose focus:outline-none"
          type="password"
          id="old_password"
          name="old_password"
          placeholder="Altes Passwort"
          autocomplete="current-password"
          required
        >
      </div>
      <div class="flex items-center w-full mx-auto mb-12 border-b-8 border-dotted border-circles-rose max-w-form border-rose">
        <span class="w-8">
          <?= svg('/assets/icons/input_password.svg') ?>
        </span>
        <input
          class="mb-1 placeholder-rose focus:outline-none"
          type="password"
          id="password"
          name="password"
          placeholder="Neues Passwort"
          autocomplete="new-password"
          required
        >
      </div>

      <?php if ($error): ?>
        <p class="mb-8 text-xs leading-tight max-w-form"><?= esc($error) ?></p>
      <?php endif; ?>

      <button class="mb-5 text-black button border-rose bg-rose" type="submit">
        Speichern
      </button>
      <a href="<?= url('/profile') ?>" class="mb-12 text-black border-rose button">Abbrechen</a>
    </form>
  </div>
</main>
