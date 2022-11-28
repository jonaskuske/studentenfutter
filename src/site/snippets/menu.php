<?php

use Kirby\Cms\Url;

$home_url = $site->homePage()->url();
$can_go_back = rtrim(Url::last(), '/') == $home_url;
?>

<div
  class="pt-20"
  x-data="{ open: false }"
  x-init="$watch('open', function(o) { document.body.classList.toggle('overflow-hidden', o) })"
  @click.away="open = false"
>
  <div class="fixed top-0 left-0 right-0 z-20 bg-white shadow rounded-b-card" style="margin-left: calc(100vw - 100%);">
    <div class="p-5 mx-scroll">
      <header class="container flex items-center justify-between">
        <button class="w-6 leading-zero" @click="open = !open">
          <span class="sr-only">Menü</span>
          <svg x-show="!open" width="25" height="19" viewBox="0 0 25 19" class="stroke-current" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line x1="1.5" y1="9.5" x2="23.5" y2="9.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            <line x1="1.5" y1="1.5" x2="23.5" y2="1.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            <line x1="1.5" y1="17.5" x2="23.5" y2="17.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <svg x-cloak x-show="open" width="21" height="21" viewBox="0 0 21 21" class="stroke-current" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line x1="2.66116" y1="18.7175" x2="18.2175" y2="3.16116" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            <line x1="2.12132" y1="3" x2="17.6777" y2="18.5563" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <?php $tag = isset($h1) || $page->isHomePage() ? 'h1' : 'p'; ?>
        <<?= $tag ?> class="text-xl italic font-bold lowercase leading-wide">
          <a
            href="<?= $home_url ?>"
            class="highlight highlight-rose highlight-lg"
            <?= r(
              $can_go_back,
              attr([
                'x-data' => '{ active: false }',
                'x-init' => 'history.replaceState("start", document.title);',
                '@click' => "if (!window.REFRESH_ON_NAV) {
                  \$event.preventDefault(); active = true; history.back();
                }",
                '@popstate.window' => "if (active) {
                  active = history.state !== 'start'; history.back();
                }"
              ])
            ) ?>
          >
            <?= $site->title() ?>
          </a>
        </<?= $tag ?>>

        <a href="<?= $site->find('search')->url() ?>" class="w-6 leading-zero">
          <span class="sr-only">Suche</span>
          <svg width="24" height="24" viewBox="0 0 24 24" class="fill-current" xmlns="http://www.w3.org/2000/svg">
            <path d="M23.4978 21.1985L17.546 15.2464C18.6669 13.668 19.333 11.7451 19.333 9.66625C19.333 4.3362 14.9966 0 9.66666 0C4.33638 0 0 4.3362 0 9.66625C0 14.9963 4.33638 19.3325 9.66666 19.3325C11.7452 19.3325 13.6675 18.6665 15.2457 17.5466L21.1981 23.4978C21.8541 24.1532 22.8996 24.1688 23.5337 23.5347C24.1695 22.899 24.1528 21.8536 23.4978 21.1985ZM2.41575 9.66625C2.41575 5.66788 5.66812 2.41565 9.66666 2.41565C13.6639 2.41565 16.9166 5.66788 16.9166 9.66625C16.9166 13.6636 13.6642 16.9159 9.66666 16.9159C5.66812 16.9159 2.41575 13.6636 2.41575 9.66625Z" />
          </svg>
        </a>
      </header>
      <div class="container transition-all" :class="{ 'invisible delay-500': !open }">
        <nav x-cloak :class="open ? 'max-h-300' : 'max-h-0'" class="overflow-hidden transition-all duration-500 ease-in-out">
          <ul class="pt-12 pl-5">
            <?php foreach ($pages->listed() as $entry): ?>
              <li class="mb-5 italic font-bold leading-relaxed text-md">
                <a href="<?= $entry->url() ?>" class="highlight highlight-rose highlight-sm">
                  <?= $entry->title()->html() ?>
                </a>
              </li>
            <?php endforeach; ?>

            <li
              x-data="{
                isStandalone: isStandalone(),
                supportsInstall: 'onbeforeinstallprompt' in window || (isIOS() && !isIOSChrome())
              }"
              x-show="!isStandalone && supportsInstall"
              @appinstalled.window="isStandalone = true"
              class="mb-5 italic font-bold leading-relaxed text-md"
            >
              <a href="<?= url('install') ?>" class="highlight highlight-rose highlight-sm">
                App installieren
              </a>
            </li>

            <li class="mt-3 mb-2 text-xs leading-tight text-right">
              <?php if ($kirby->user()): ?>
                <a href="<?= $site->find('profile')->url() ?>">
                  <?= $site
                    ->find('profile')
                    ->title()
                    ->inline() ?>
                </a>
              <?php else: ?>
                <a href="<?= url('login') ?>">
                  Einloggen/Registrieren
                </a>
              <?php endif; ?>
            </li>
            <li class="text-xs leading-tight text-right">
              <a href="<?= url('/legal') ?>">Rechtliches</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>