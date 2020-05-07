<div class="flex-shrink-0 w-56 h-32 shadow rounded-large">
  <div class="relative flex items-end w-full h-full overflow-hidden rounded-large">
    <?php if ($image = $recipe->image()) : ?>
      <img class="absolute object-cover w-full h-full -z-1" src="<?= $image->url() ?>" />
    <?php else : ?>
      <div></div>
    <?php endif ?>

    <div class="flex items-center justify-between w-full h-12 pl-3 pr-4 bg-white">
      <a class="italic font-bold stretched-link" href="<?= $recipe->url() ?>">
        <?= $recipe->title() ?>
      </a>

      <button x-data="{ isFavorite: false }" @click="isFavorite = !isFavorite" class="z-10">
        <svg x-show="!isFavorite" width="22" height="20" viewBox="0 0 22 20" class="stroke-current text-rose" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.14001 1.11136C7.41168 1.11136 8.69751 1.60945 9.63413 2.61847L10.2615 3.30562L10.9838 4.09664L11.7234 3.32182L12.3534 2.66182L12.3534 2.66184L12.359 2.65588C14.2766 0.61373 17.4749 0.620859 19.3566 2.65111C21.2799 4.72628 21.2812 8.00085 19.3603 10.0776C17.4983 12.0408 15.6481 14.0196 13.8051 15.9907C12.9191 16.9383 12.0347 17.8842 11.1516 18.8256L11.1326 18.8445L11.1322 18.8449C11.0173 18.9342 10.8941 18.9056 10.8302 18.8381C10.83 18.8379 10.8298 18.8376 10.8296 18.8374L2.64344 10.0516C2.64318 10.0513 2.64291 10.051 2.64265 10.0507C0.72034 7.97575 0.719134 4.70236 2.63903 2.62588C3.61372 1.60375 4.8771 1.11136 6.14001 1.11136Z" stroke-width="2" />
        </svg>
        <svg x-show="isFavorite" width="22" height="20" viewBox="0 0 22 20" class="fill-current text-rose" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.14001 0.111328C4.61001 0.111328 3.08001 0.711321 1.91001 1.94132C-0.369988 4.40132 -0.369988 8.27132 1.91001 10.7313L10.1 19.5213C10.55 20.0013 11.3 20.0313 11.81 19.5813C11.84 19.5513 11.84 19.5513 11.87 19.5213C14.6 16.6113 17.33 13.6713 20.09 10.7613C22.37 8.30133 22.37 4.43131 20.09 1.97131C17.81 -0.488686 13.94 -0.488686 11.63 1.97131L11 2.63132L10.37 1.94132C9.23001 0.711321 7.67001 0.111328 6.14001 0.111328Z" />
        </svg>
      </button>
    </div>
  </div>
</div>