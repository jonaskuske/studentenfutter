<?= snippet('head') ?>

<body class="bg-fixed bg-angled-rose">
  <?= snippet('menu') ?>

  <main class="flex-grow px-5 pt-6">
    <div class="pt-4 bg-white shadow rounded-card">
      <h1 class="mb-6 text-xl italic font-bold text-center leading-wide">
        <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
      </h1>

      <p class="w-full mx-auto mb-8 text-xs leading-tight max-w-form">
        <?= $page->info()->html() ?>
      </p>


      <form method="post" action="<?= $page->url() ?>" class="flex flex-col items-center text-rose">
        <input type="text" name="return_to" id="return_to" value="<?= get('return_to') ?>" hidden>

        <div class="flex items-center w-full mx-auto mb-8 border-b-2 border-dotted max-w-form border-rose">
          <span class="w-8 transform -translate-y-1">
            <?= svg('/assets/icons/input_email.svg') ?>
          </span>
          <input value="<?= esc(get('email')) ?>" class="mb-1 placeholder-rose" type="email" id="email" name="email" placeholder="Mail-Adresse">
        </div>
        <div class="flex items-center w-full mx-auto mb-12 border-b-2 border-dotted max-w-form border-rose">
          <span class="w-8 ">
            <?= svg('/assets/icons/input_password.svg') ?>
          </span>
          <input value="<?= esc(get('password')) ?>" class="mb-1 placeholder-rose" placeholder="Passwort" type="password" id="password" name="password">
        </div>

        <?php if ($error) : ?>
          <p class="mb-8 text-xs leading-tight max-w-form"><?= esc($error) ?></p>
        <?php endif; ?>

        <button class="mb-5 text-black button border-yellow bg-yellow" type="submit">
          Einloggen
        </button>
        <a class="mb-12 text-black button border-yellow" href="<?= url('signup') ?>">
          Registrieren
        </a>
      </form>
    </div>
  </main>
</body>