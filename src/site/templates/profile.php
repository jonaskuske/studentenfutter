<?= snippet('head') ?>

<body class="bg-fixed bg-angled-yellow">
  <?= snippet('menu') ?>

  <main class="flex-grow pt-6">
    <h1 class="mb-10 text-xl italic font-bold text-center leading-wide">
      <span class="highlight highlight-rose">Profil</span>
    </h1>

    <div class="flex flex-col items-center">
      <div class="flex items-center w-full mx-auto mb-5 max-w-form">
        <span class="mr-2 text-yellow"><?= svg('/assets/icons/user.svg') ?></span>
        <p><?= html($user->name()) ?></p>
      </div>
      <div class="flex items-center w-full mx-auto mb-5 max-w-form">
        <span class="mr-2 text-yellow"><?= svg('/assets/icons/email.svg') ?></span>
        <p><?= html($user->email()) ?></p>
      </div>
      <div class="flex items-center w-full mx-auto mb-12 max-w-form">
        <span class="mr-2 text-yellow"><?= svg('/assets/icons/password.svg') ?></span>
        <p>**********</p>
      </div>

      <a href="<?= url('profile/edit') ?>" class="mb-5 button bg-rose border-rose">
        Profil bearbeiten
      </a>
      <a href="<?= url('profile/edit-pw') ?>" class="mb-5 button border-rose">
        Passwort ändern
      </a>

      <a href="<?= url('logout') ?>" class="text-xs leading-tight underline text-blue">
        Abmelden
      </a>
    </div>
  </main>
</body>