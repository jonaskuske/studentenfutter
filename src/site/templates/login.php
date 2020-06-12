<?= snippet('head') ?>

<body class="bg-fixed bg-angled-rose">
  <?= snippet('menu') ?>

  <main class="flex-grow px-5 pt-6">
    <div class="pt-4 bg-white shadow rounded-card">
      <h1 class="mb-6 text-xl italic font-bold text-center leading-wide md:mb-10">
        <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
      </h1>

      <div class="textfield w-full mx-auto mb-8 text-xs leading-tight max-w-form md:text-base md:leading-normal md:max-w-md md:mb-16">
        <?= $page->info()->kt() ?>
      </div>


      <form method="post" action="<?= $page->url() ?>" class="flex flex-col items-center text-rose">
        <input value="<?= esc(get('r',''), 'attr') ?>" name="r" id="r" hidden>
        <input value="<?= csrf() ?>" name="csrf_token" id="csrf_token" hidden>

        <div class="flex items-center w-full mx-auto mb-8 border-dotted border-b-8 border-circles-rose max-w-form border-rose">
          <span class="w-8 transform -translate-y-1">
            <?= svg('/assets/icons/input_email.svg') ?>
          </span>
          <input value="<?= esc(get('email')) ?>" class="mb-1 placeholder-rose" type="email" id="email" name="email" placeholder="Mail-Adresse">
        </div>
        <div class="flex items-center w-full mx-auto mb-12 border-dotted border-b-8 border-circles-rose max-w-form border-rose">
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