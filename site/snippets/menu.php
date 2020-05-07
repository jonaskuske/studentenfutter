<div class="pt-20">
  <div x-data="{ open: false }" class="fixed top-0 left-0 z-10 w-full p-5 bg-white shadow rounded-b-large">
    <header class="flex items-center justify-between">
      <button class="w-6 outline-none leading-zero focus:outline-none" @click="open = !open">
        <svg x-show="!open" width="25" height="19" viewBox="0 0 25 19" class="stroke-current" fill="none" xmlns="http://www.w3.org/2000/svg">
          <line x1="1.5" y1="9.5" x2="23.5" y2="9.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          <line x1="1.5" y1="1.5" x2="23.5" y2="1.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          <line x1="1.5" y1="17.5" x2="23.5" y2="17.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <svg x-show="open" width="21" height="21" viewBox="0 0 21 21" class="stroke-current" fill="none" xmlns="http://www.w3.org/2000/svg">
          <line x1="2.66116" y1="18.7175" x2="18.2175" y2="3.16116" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
          <line x1="2.12132" y1="3" x2="17.6777" y2="18.5563" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <h1 class="text-xl italic font-bold leading-loose lowercase">
        <span class="highlight highlight-rose highlight-lg"><?= $site->title() ?></span>
      </h1>

      <a href="#" class="w-6 leading-zero focus:outline-none">
        <svg width="24" height="24" viewBox="0 0 24 24" class="fill-current" xmlns="http://www.w3.org/2000/svg">
          <path d="M23.4978 21.1985L17.546 15.2464C18.6669 13.668 19.333 11.7451 19.333 9.66625C19.333 4.3362 14.9966 0 9.66666 0C4.33638 0 0 4.3362 0 9.66625C0 14.9963 4.33638 19.3325 9.66666 19.3325C11.7452 19.3325 13.6675 18.6665 15.2457 17.5466L21.1981 23.4978C21.8541 24.1532 22.8996 24.1688 23.5337 23.5347C24.1695 22.899 24.1528 21.8536 23.4978 21.1985ZM2.41575 9.66625C2.41575 5.66788 5.66812 2.41565 9.66666 2.41565C13.6639 2.41565 16.9166 5.66788 16.9166 9.66625C16.9166 13.6636 13.6642 16.9159 9.66666 16.9159C5.66812 16.9159 2.41575 13.6636 2.41575 9.66625Z" />
        </svg>
      </a>
    </header>

    <nav :class="open ? 'max-h-300' : 'max-h-0'" class="overflow-hidden transition-all duration-500 ease-in-out">
      <ul class="mt-12 ml-5">
        <li class="mb-5 italic font-bold leading-relaxed text-md">
          <a href="<?= $site->homePage()->url() ?>" class="highlight highlight-rose highlight-sm">Home</a>
        </li>
        <li class="mb-5 italic font-bold leading-relaxed text-md">
          <a href="#" class="highlight highlight-rose highlight-sm">Favoriten</a>
        </li>
        <li class="mb-5 italic font-bold leading-relaxed text-md">
          <a href="#" class="highlight highlight-rose highlight-sm">Alle Rezepte</a>
        </li>
        <li class="mb-5 italic font-bold leading-relaxed text-md">
          <a href="#" class="highlight highlight-rose highlight-sm">About</a>
        </li>
        <li class="mb-3 italic font-bold leading-relaxed text-md">
          <a href="#" class="highlight highlight-rose highlight-sm">Profil</a>
        </li>
        <li class="text-xs leading-tight text-right"><a href="#">Rechtliches</a></li>
      </ul>
    </nav>
  </div>
</div>