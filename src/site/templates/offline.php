<?= snippet('head') ?>

<body>
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
      <p class="text-center" x-show="path === '/'">
        Stelle eine Internetverbindung her, um alle Rezepte sehen zu können.
      </p>
      <p class="text-center" x-show="path === '/recipes'">
        Rezepte, die du zu deinen Favoriten hinzugefügt hast,
        kannst du auch ohne Internetverbindung ansehen.
      </p>
    </section>

    <div class="mt-auto text-center">
      <a
        x-show="path === '/recipes'"
        class="inline-block m-5 mb-12 button border-yellow"
        href="<?= url('favorites') ?>"
      >
        Favoriten anzeigen
      </a>
    </div>
  </main>
</body>
