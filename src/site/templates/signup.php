<?= snippet('head') ?>
<?= snippet('menu') ?>

<main class="flex-grow px-5 pt-6 bg-angled-rose">
  <div class="pt-4 bg-white shadow rounded-card">
    <h1 class="mb-6 text-xl italic font-bold text-center leading-wide">
      <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
    </h1>

    <p class="w-full mx-auto mb-8 text-xs leading-tight max-w-form"><?= $page->info()->html() ?></p>

    <form method="post" action="<?= $page->url() ?>" class="flex flex-col items-center text-rose">
      <div class="flex items-center w-full mx-auto mb-8 border-b-2 border-dotted max-w-form border-rose">
        <span class="w-8 transform -translate-y-1">
          <?= svg('/assets/icons/input_user.svg') ?>
        </span>
        <input class="mb-1 placeholder-rose" type="name" id="name" name="name" placeholder="Name" value="<?= esc(get('name')) ?>" required>
      </div>
      <div class="flex items-center w-full mx-auto mb-8 border-b-2 border-dotted max-w-form border-rose">
        <span class="w-8 transform -translate-y-1">
          <?= svg('/assets/icons/input_email.svg') ?>
        </span>
        <input class="mb-1 placeholder-rose" type="email" id="email" name="email" placeholder="Mail-Adresse" value="<?= esc(get('email')) ?>" required>
      </div>
      <div class="flex items-center w-full mx-auto mb-12 border-b-2 border-dotted max-w-form border-rose">
        <span class="w-8 ">
          <?= svg('/assets/icons/input_password.svg') ?>
        </span>
        <input class="mb-1 placeholder-rose" placeholder="Passwort" type="password" id="password" name="password" required">
      </div>

      <?php if ($error) : ?>
        <p class="mb-8 text-xs leading-tight max-w-form"><?= esc($error) ?></p>
      <?php endif; ?>

      <button class="mb-12 text-black button border-yellow bg-yellow" type="submit">
        Registrieren
      </button>
    </form>
  </div>
</main>