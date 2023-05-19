<?= snippet('head', ['body_class' => 'bg-fixed bg-angled-yellow']) ?>

<?= snippet('menu') ?>

<main
  class="flex flex-col flex-grow pt-6"
  x-data="{ online: typeof navigator.onLine === 'boolean' ? navigator.onLine : true }"
  @online.window="online = true"
  @offline.window="online = false"
>
  <h1 class="mb-10 text-xl italic font-bold text-center leading-wide select-none">
    <span class="highlight highlight-rose">Profil</span>
  </h1>

  <div class="flex-grow flex flex-col items-center">
    <div class="flex items-center w-full mx-auto mb-5 max-w-form">
      <span class="mr-2 text-yellow"><?= svg('/assets/icons/user.svg') ?></span>
      <p><?= html($user->name()->or('(kein Name angegeben)')) ?></p>
    </div>
    <div class="flex items-center w-full mx-auto mb-5 max-w-form">
      <span class="mr-2 text-yellow"><?= svg('/assets/icons/email.svg') ?></span>
      <p><?= html($user->email()) ?></p>
    </div>
    <div class="flex items-center w-full mx-auto mb-12 max-w-form">
      <span class="mr-2 text-yellow"><?= svg('/assets/icons/password.svg') ?></span>
      <p>**********</p>
    </div>

    <div x-show="online" class="flex-grow flex flex-col items-center">
      <a href="<?= url('profile/edit') ?>" class="mb-5 button bg-rose border-rose">
        Profil bearbeiten
      </a>
      <a href="<?= url('profile/edit-pw') ?>" class="button border-rose">
        Passwort ändern
      </a>

      <hr class="w-16 my-auto border-t-0 border-b-8 border-dotted border-circles-lightgray text-lightgray">

      <p class="flex text-sm mb-8 leading-tight text-rose select-none">
        <a href="<?= url('logout') ?>" class="underline">
          Abmelden
        </a>
        <span class="mx-2"></span>
        <a href="<?= url('profile/delete') ?>" class="underline">
          Konto löschen
        </a>
      </p>
    </div>
  </div>

  <div x-cloak x-show="!online" class="px-5 pb-12 m-auto text-center">
    <div class="w-24 mx-auto mb-4 text-lightgray">
      <?= svg('assets/icons/offline.svg') ?>
    </div>
    <p>Dein <span x-text="getDeviceType()">Gerät</span> ist offline.</p>
  </div>

  <div class="mt-auto"></div>
</main>
