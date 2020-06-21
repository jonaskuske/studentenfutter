<?= snippet('head') ?>

<?= snippet('menu', ['h1' => true]) ?>
<?= snippet('online-banner', ['for' => 'online']) ?>

<main class="flex flex-col flex-grow pt-6" x-data="{ path: location.pathname }" x-cloak>
  <section x-show="path === '/'">
    <div class="mb-6"><?= snippet('headings/favorites', ['tag' => 'h2']) ?></div>

    <?php if ($favorites->isNotEmpty()): ?>
      <?= snippet('recipe-row', ['recipes' => $favorites]) ?>
    <?php else: ?>
      <p class="mb-4 text-center">Du hast noch keine Rezepte gespeichert.</p>
    <?php endif; ?>
  </section>

  <section class="px-5 py-12 my-auto">
    <div class="w-24 mx-auto mb-4 text-lightgray">
      <?= svg('assets/icons/offline.svg') ?>
    </div>

    <p class="mb-4 text-center">Dein <span x-text="getDeviceType()">Gerät</span> ist offline.</p>
    <?php if ($user): ?>
      <p class="text-center" x-show="path === '/'">
        Stelle eine Internetverbindung her, um alle Rezepte anzusehen.
      </p>
      <p class="text-center" x-show="path === '/recipes'">
        Rezepte, die du zu deinen Favoriten hinzugefügt hast,
        kannst du auch ohne Internetverbindung ansehen.
      </p>
    <?php else: ?>
      <p class="text-center" x-show="path === '/'">
        Melde dich an und füge Rezepte zu deinen Favoriten hinzu, um sie auch
        offline lesen zu können.
      </p>
      <p class="text-center" x-show="path === '/recipes'">
        Wenn du dich anmeldest und Rezepte zu deinen Favoriten hinzufügst,
        <br class="hidden sm:inline">
        kannst du sie auch ohne Internetverbindung ansehen.
      </p>
    <?php endif; ?>
  </section>

  <div class="mt-auto text-center">
    <?php if ($user): ?>
      <a
        x-show="path === '/recipes'"
        class="inline-block m-5 mb-12 button border-yellow"
        href="<?= url('favorites') ?>"
      >
        Favoriten anzeigen
      </a>
    <?php endif; ?>
  </div>
</main>
