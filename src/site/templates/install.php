<?= snippet('head') ?>

<body class="bg-fixed bg-angled-rose">
  <?= snippet('menu') ?>

  <script>
    window.global = window // "react-ios-pwa-prompt" requires "global" to exist
  </script>
  <?= js([
    '//cdn.jsdelivr.net/npm/react/umd/react.production.min.js',
    '//cdn.jsdelivr.net/npm/react-dom/umd/react-dom.production.min.js',
    '//cdn.jsdelivr.net/npm/react-ios-pwa-prompt',
  ]) ?>

  <script>
    var iOSPromptOptions = {
      onClose: function() {
        ReactDOM.unmountComponentAtNode(document.getElementById('ios-prompt'))
      },
      delay: 0,
      timesToShow: 9999999,
      permanentlyHideOnDismiss: false,
      copyTitle: "Zum Home-Bildschirm hinzufügen",
      copyBody: "Damit du die volle App-Experience bekommst, füge diese App zu deinem Home-Bildschirm hinzu.",
      copyShareButtonLabel: "1. Drücke den Teilen-Button in der Menüleiste.",
      copyAddHomeButtonLabel: "2. Scrolle kurz, drücke auf 'Zum Home-Bildschirm' und anschließend auf 'Hinzufügen'.",
      copyClosePrompt: "Schließen"
    }

    var Prompt = React.createElement(window['react-ios-pwa-prompt'].default, iOSPromptOptions)

    function showInstallPrompt() {
      if (window.INSTALL_EVENT) window.INSTALL_EVENT.prompt()
      else ReactDOM.render(Prompt, document.getElementById('ios-prompt'))
    }
  </script>

  <main
    class="flex-grow px-5 pt-6"
    x-cloak
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
        <div style="max-width: 14rem" class="text-rose mx-auto mb-8">
          <?= svg('assets/icons/install.svg') ?>
        </div>

        <div class="text-xs leading-tight max-w-form md:text-base md:leading-normal md:max-w-md">
          <p class="text-center" x-show="isStandalone">
            <?= $site->title()->html() ?> ist installiert.<br />
            Schau bei deinen Apps nach!
          </p>

          <div x-show="!isStandalone && (canPrompt || (isIOS && !isIOSChrome))" class="textfield flex flex-col">
            <?= $page->info()->kt() ?>

            <button @click="showInstallPrompt();" class="mx-auto mt-6 text-black button border-yellow bg-yellow">
              Installieren
            </button>
          </div>


          <p class="text-center" x-show="!isStandalone && ((!canPrompt && !isIOS) || isIOSChrome)">
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