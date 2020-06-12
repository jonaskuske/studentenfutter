<?= snippet('head') ?>

<body class="bg-fixed bg-angled-rose">
  <?= snippet('menu') ?>

  <script>
    window.global = window // "react-ios-pwa-prompt" requires "global" to exist
  </script>
  <?= js([
    '//unpkg.com/react/umd/react.production.min.js',
    '//unpkg.com/react-dom/umd/react-dom.production.min.js',
    '//unpkg.com/react-ios-pwa-prompt',
  ]) ?>

  <script>
    var iOSPromptOptions = {
      delay: 0,
      timesToShow: 9999999,
      // hier kann noch "copyTitle" etc. festgelegt werden
    }

    var Prompt = React.createElement(window['react-ios-pwa-prompt'].default, iOSPromptOptions)

    function showInstallPrompt() {
      if (window.INSTALL_EVENT) window.INSTALL_EVENT.prompt()
      else ReactDOM.render(Prompt, document.getElementById('ios-prompt'))
    }
  </script>

  <main
    class="flex-grow px-5 pt-6"
    x-data="{
      canPrompt: Boolean(window.INSTALL_EVENT),
      isIOS: isIOS(),
      isIOSChrome: isIOSChrome(),
      isStandalone: isStandalone(),
    }"
    @appinstalled.window="isStandalone = true"
    @beforeinstallprompt.window="canPrompt = true"
  >
    <div class="pt-4 pb-12 bg-white shadow rounded-card">
      <h1 class="mb-6 text-xl italic font-bold text-center leading-wide md:mb-10">
        <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
      </h1>

      <div class="mx-auto max-w-form md:max-w-md">
        <div class="max-w-xs mx-auto mb-8">
          <?= svg('assets/images/app_install.svg') ?>
        </div>

        <div class="text-xs leading-tight max-w-form md:text-base md:leading-normal md:max-w-md">
          <p x-show="isStandalone"><?= $site->title()->html() ?> ist bereits installiert.</p>

          <div x-show="!isStandalone && (canPrompt || (isIOS && !isIOSChrome))" class="textfield flex flex-col">
            <?= $page->info()->kt() ?>

            <button @click="showInstallPrompt();" class="mx-auto mt-6 text-black button border-yellow bg-yellow">
              Installieren
            </button>
          </div>


          <p x-show="!isStandalone && ((!canPrompt && !isIOS) || isIOSChrome)">
            Öffne <a class="text-rose" href="<?= $site->homePage()->url() ?>"><?= $site->homePage()->url() ?></a> in
            <span x-show="isIOS">Safari</span><span x-show="!isIOS">Chrome</span>,
            um <?= $site->title() ?> installieren zu können.
          </p>
        </div>
      </div>
    </div>

    <div id="ios-prompt"></div>
  </main>
</body>