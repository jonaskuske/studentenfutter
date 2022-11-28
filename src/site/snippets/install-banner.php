<script>
  function installBanner() {
    return {
      showBanner: false,
      canPrompt: Boolean(window.INSTALL_EVENT) || (isIOS() && !isIOSChrome()),
      run: function() {
        var ONE_WEEK = 1000 * 60 * 60 * 24 * 7
        if (
          isStandalone() ||
          !this.canPrompt ||
          localStorage.getItem('allow_install_banner') === 'false' ||
          Date.now() - +localStorage.getItem('last_install_banner') < ONE_WEEK
        ) return

        localStorage.setItem('last_install_banner', Date.now())
        var _this = this;
        setTimeout(function() { _this.showBanner = true }, 800)
      }
    }
  }
</script>
<div
  x-cloak
  x-data="installBanner()"
  x-init="
    $watch('showBanner', function(show) { document.body.classList[show ? 'add' : 'remove']('overflow-hidden') });
    $watch('canPrompt', function() { run() });
    run();
  "
  @beforeinstallprompt.window="canPrompt = true"
>
  <!-- backdrop -->
  <div
    x-show="showBanner"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed top-0 left-0 z-30 flex w-full h-full"
    style="background: rgba(0, 0, 0, 0.5);"
  >
  </div>

  <!-- banner -->
  <div
    x-show="showBanner"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-full"
    x-transition:enter-end="opacity-100 transform "
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform "
    x-transition:leave-end="opacity-0 transform translate-y-full"
    class="fixed bottom-0 left-0 z-30 flex w-full p-5"
  >
    <div @click.away="showBanner = false" class="relative p-5 py-10 mx-auto mt-auto bg-white shadow rounded-card">
      <button
        type="button"
        class="absolute top-0 right-0 px-4 py-3 opacity-50 text-xs"
        @click="localStorage.setItem('allow_install_banner', (showBanner = false))"
      >
      <span class="mr-px align-text-top">Nicht mehr zeigen</span>
        <svg width="12" height="12" viewBox="0 0 21 21" class="stroke-current inline" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg">
          <line x1="2.66116" y1="18.7175" x2="18.2175" y2="3.16116" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          <line x1="2.12132" y1="3" x2="17.6777" y2="18.5563" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <div class="flex pr-3" style="max-width: 295px">
        <div style="width: 95px" class="flex-shrink-0 mr-5 text-yellow">
          <?= svg('assets/icons/install.svg') ?>
        </div>

        <div class="pt-px mt-1 mr-1">
          <p class="mb-3 text-xs leading-tight">
            Für die volle App-Experience, installiere dir diese Seite als Web App.
          </p>
          <a
            href="<?= url('install') ?>"
            @click="localStorage.setItem('allow_install_banner', false)"
            class="block min-w-0 text-black button border-yellow bg-yellow"
          >
            Installieren
          </a>
        </div>
      </div>
    </div>
  </div>
</div>