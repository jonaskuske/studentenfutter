  <div class="flex flex-col items-center px-8 pt-4 pb-10 bg-white shadow rounded-card">
    <h2 class="mb-8 text-xl italic font-bold leading-wide highlight highlight-blue select-none">Suche</h2>

    <form spellcheck="false" autocomplete="off" x-data="{ query: '' }" class="w-full" action="<?= $site
      ->find('search')
      ->url() ?>">
      <div class="flex max-w-sm mx-auto border-dotted border-b-8 border-circles-blue text-blue">
        <div class="flex flex-grow group">
          <svg class="mr-2 fill-current group-focus-within:text-black" width="23" height="23" viewBox="0 0 23 23" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.4527 18.1327L15.3359 14.0155C16.1113 12.9237 16.572 11.5936 16.572 10.1556C16.572 6.46874 13.5725 3.46931 9.88585 3.46931C6.19895 3.46931 3.19952 6.46874 3.19952 10.1556C3.19952 13.8425 6.19895 16.842 9.88585 16.842C11.3236 16.842 12.6532 16.3813 13.7448 15.6066L17.862 19.7232C18.3158 20.1765 19.0389 20.1873 19.4775 19.7487C19.9173 19.309 19.9058 18.5858 19.4527 18.1327ZM4.87047 10.1556C4.87047 7.38989 7.1201 5.14026 9.88585 5.14026C12.6507 5.14026 14.9005 7.38989 14.9005 10.1556C14.9005 12.9207 12.6509 15.1703 9.88585 15.1703C7.1201 15.1703 4.87047 12.9207 4.87047 10.1556Z" />
          </svg>

          <input
            type="search"
            name="q"
            aria-label="Suche"
            placeholder="z.B. Reispfanne"
            value="<?= html(get('q', '')) ?>"
            @input="query = $event.target.value"
            class="w-full placeholder-blue focus:outline-none focus:placeholder-black focus:text-black"
          />
        </div>
        <button type="submit" class="h-4 rounded-full transition-opacity duration-200 opacity-0 sm:active:opacity-50 focus:opacity-100 focus-visible:text-black" :class="{ 'sm:opacity-100': query.length > 0 }">
          <span class="sr-only">Suche starten</span>
          <svg width="22" height="15" viewBox="0 0 22 15" class="fill-current" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4992 7.35739C21.4997 7.36883 21.5 7.38028 21.5 7.39173C21.5002 7.58342 21.4273 7.77518 21.2813 7.9217C21.2747 7.92829 21.2681 7.93474 21.2613 7.94103L14.61 14.5024C14.3152 14.7933 13.8403 14.7901 13.5494 14.4952C13.2585 14.2003 13.2617 13.7255 13.5566 13.4346L18.9882 8.07642H0.749838C0.335625 8.07642 -0.000162125 7.74064 -0.000162125 7.32642C-0.000162125 6.91221 0.335625 6.57642 0.749838 6.57642H18.8685L13.554 1.2813C13.2605 0.988941 13.2597 0.514068 13.552 0.22064C13.8444 -0.0727881 14.3193 -0.0736559 14.6127 0.218702L21.0616 6.6441C21.3202 6.76245 21.4998 7.02346 21.4998 7.32642C21.4998 7.3368 21.4996 7.34712 21.4992 7.35739Z" />
          </svg>
        </button>
      </div>
    </form>
  </div>