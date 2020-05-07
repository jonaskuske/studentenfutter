<?= snippet('header') ?>
<?= snippet('menu') ?>

<?php $recipes = $page->children()->listed(); ?>
<?php /* TODO */ $favorites = pages([]); ?>

<main class="pt-6">
  <section class="flex flex-col items-center px-8 pt-4 pb-10 mx-5 mb-6 bg-white shadow rounded-large">
    <h2 class="mb-8 text-xl italic font-bold leading-loose highlight highlight-blue">Suche</h2>

    <form class="w-full">
      <div class="flex border-b-2 border-dotted text-blue">
        <svg class="mr-2 fill-current" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19.4527 18.1327L15.3359 14.0155C16.1113 12.9237 16.572 11.5936 16.572 10.1556C16.572 6.46874 13.5725 3.46931 9.88585 3.46931C6.19895 3.46931 3.19952 6.46874 3.19952 10.1556C3.19952 13.8425 6.19895 16.842 9.88585 16.842C11.3236 16.842 12.6532 16.3813 13.7448 15.6066L17.862 19.7232C18.3158 20.1765 19.0389 20.1873 19.4775 19.7487C19.9173 19.309 19.9058 18.5858 19.4527 18.1327ZM4.87047 10.1556C4.87047 7.38989 7.1201 5.14026 9.88585 5.14026C12.6507 5.14026 14.9005 7.38989 14.9005 10.1556C14.9005 12.9207 12.6509 15.1703 9.88585 15.1703C7.1201 15.1703 4.87047 12.9207 4.87047 10.1556Z" />
        </svg>
        <input class="w-full placeholder-blue" type="search" placeholder="z.B. Reispfanne" aria-label="Suche" />
      </div>
    </form>
  </section>

  <section class="mb-4">
    <div class="flex items-center justify-center mb-4">
      <svg class="mr-3 transform translate-y-1 fill-current text-yellow" width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.4772 0C6.03046 0 0 6.03046 0 13.4772V26.9543H13.4772C20.9239 26.9543 26.9543 20.9239 26.9543 13.4772C27 6.03046 20.9239 0 13.4772 0ZM20.8325 14.2538C19.1878 15.9898 17.5888 17.7259 15.9442 19.4619C15.1675 20.2843 14.3909 21.1066 13.6142 21.9289C13.5228 22.0203 13.3858 21.9746 13.3401 21.9289L6.16751 14.2081C4.47716 12.3807 4.47716 9.50254 6.16751 7.67513C7.03553 6.76142 8.13198 6.35025 9.22843 6.35025C10.3249 6.35025 11.467 6.80711 12.2893 7.67513L12.8376 8.26904L13.4772 8.95432L14.1168 8.26904L14.665 7.67513C16.3553 5.8934 19.1421 5.8934 20.7868 7.67513C22.5228 9.54822 22.5228 12.4264 20.8325 14.2538Z" />
      </svg>

      <h2 class="text-xl italic font-bold leading-loose highlight highlight-yellow">Favoriten</h2>
    </div>

    <div class="flex px-5 py-2 space-x-5 overflow-auto">
      <?php if (!$favorites->isEmpty()) : ?>
        <?php foreach ($favorites as $recipe) : ?>
          <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
        <?php endforeach ?>
      <?php else : ?>
        <p class="m-auto">Keine Favoriten vorhanden.</p>
      <?php endif ?>
    </div>
  </section>

  <section class="mb-4">
    <div class="flex items-center justify-center mb-4">
      <svg class="mr-3 transform translate-y-1 fill-current text-rose" width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.8731 11.2386V5.43655C9.45689 5.71067 8.40613 6.98985 8.40613 8.45178C8.40613 8.54315 8.40613 8.68021 8.40613 8.77158L10.8731 11.2386Z" fill="#F18B85" />
        <path d="M13.4772 0C6.03046 0 0 6.03046 0 13.4772V26.9543H13.4772C20.9239 26.9543 26.9543 20.9239 26.9543 13.4772C27 6.03046 20.9239 0 13.4772 0ZM5.98477 7.21827C6.12183 7.1269 6.25888 7.03553 6.44162 7.03553C6.57868 7.03553 6.76142 7.08122 6.85279 7.21827L7.26396 7.62944C7.67513 5.66497 9.41117 4.15736 11.5127 4.15736C11.8782 4.15736 12.1523 4.43147 12.1523 4.79695V6.85279C12.4264 6.76142 12.7462 6.67005 13.066 6.62437C13.7513 5.84772 14.7563 5.39086 15.8528 5.39086C16.9036 5.39086 17.9086 5.84772 18.6396 6.62437C20.5584 6.76142 22.0203 8.36041 22.0203 10.3249C22.0203 10.736 21.9289 11.1472 21.7919 11.5584H17.6802L18.6853 10.8274C18.9594 10.6447 19.0051 10.2335 18.8223 9.95939C18.5939 9.68528 18.2284 9.63959 17.9543 9.82234L16.4467 10.9645V9.73096C16.4467 9.41117 16.1726 9.09137 15.8071 9.09137C15.4873 9.09137 15.1675 9.36548 15.1675 9.73096V10.9645L13.7056 9.86802C13.4315 9.68528 13.066 9.73096 12.8376 10.0051C12.6548 10.2792 12.7005 10.6447 12.9746 10.8731L13.9797 11.6041H12.1066H11.5127H9.45685L7.26396 9.41117L6.44162 8.58883C5.84772 9.50254 5.75635 10.6447 6.2132 11.6041H4.88833C4.47716 10.0964 4.79695 8.36041 5.98477 7.21827ZM17.0863 20.7868V22.066C17.0863 22.3858 16.8122 22.7056 16.4467 22.7056H10.2792C9.95939 22.7056 9.63959 22.4315 9.63959 22.066V20.7868C6.16751 19.4619 3.79188 16.3553 3.51777 12.7919H23.1624C22.934 16.3553 20.5584 19.4619 17.0863 20.7868Z" />
      </svg>


      <h2 class="text-xl italic font-bold leading-loose highlight highlight-rose">
        Salate & Suppen
      </h2>
    </div>

    <div class="flex px-5 py-2 space-x-5 overflow-auto">
      <?php if (!($salad_soup = $recipes->filterBy('category', 'salad_soup'))->isEmpty()) : ?>
        <?php foreach ($salad_soup as $recipe) : ?>
          <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
        <?php endforeach ?>
      <?php else : ?>
        <p class="m-auto">Keine Rezepte vorhanden.</p>
      <?php endif ?>
    </div>
  </section>

  <section class="mb-4">
    <div class="flex items-center justify-center mb-4">
      <svg class="mr-3 transform translate-y-1 fill-current text-yellow" width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.4999 0C6.04062 0 0 6.04068 0 13.5V27H13.4999C20.9591 27 26.9997 20.9593 26.9997 13.5C27.0455 6.04068 20.9591 0 13.4999 0ZM20.9134 19.5864H5.12537C4.75928 19.5864 4.4847 19.3119 4.4847 18.9458C4.4847 18.5797 4.75928 18.3051 5.12537 18.3051H20.8676C21.2337 18.3051 21.5083 18.5797 21.5083 18.9458C21.5083 19.3119 21.2795 19.5864 20.9134 19.5864ZM20.9134 17.2525H5.17114C4.80504 17.2525 4.53047 16.978 4.53047 16.6119C4.53047 16.2458 4.80504 15.9712 5.17114 15.9712H5.72028C5.9491 12.9508 8.23721 10.4797 11.2575 9.79322C11.0287 9.42712 10.8914 9.01525 10.8914 8.55763C10.8914 7.3678 11.8524 6.40678 13.0422 6.40678C14.2321 6.40678 15.1931 7.3678 15.1931 8.55763C15.1931 9.01525 15.0558 9.42712 14.827 9.79322C17.8931 10.4797 20.1812 12.9508 20.3642 15.9712H20.9591C21.3252 15.9712 21.6456 16.2458 21.6456 16.6119C21.6456 16.978 21.2795 17.2525 20.9134 17.2525Z" />
      </svg>

      <h2 class="text-xl italic font-bold leading-loose highlight highlight-yellow">
        Hauptgerichte
      </h2>
    </div>

    <div class="flex px-5 py-2 space-x-5 overflow-auto">
      <?php if (!($main_dishes = $recipes->filterBy('category', 'main_dish'))->isEmpty()) : ?>
        <?php foreach ($main_dishes as $recipe) : ?>
          <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
        <?php endforeach ?>
      <?php else : ?>
        <p class="m-auto">Keine Rezepte vorhanden.</p>
      <?php endif ?>
    </div>
  </section>

  <section class="mb-4">
    <div class="flex items-center justify-center mb-4">
      <svg class="mr-3 transform translate-y-1 fill-current text-rose" width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.4772 0C6.03046 0 0 6.03046 0 13.4772V26.9543H13.4772C20.9239 26.9543 26.9543 20.9239 26.9543 13.4772C27 6.03046 20.9239 0 13.4772 0ZM12.9289 4.38579C13.8426 4.38579 14.6193 5.11675 14.6193 6.07614C14.6193 7.03553 13.8426 7.7665 12.9289 7.7665C12.0152 7.7665 11.2386 7.03553 11.2386 6.07614C11.2386 5.11675 11.9695 4.38579 12.9289 4.38579ZM16.9949 21.4721C16.9036 21.9746 16.4467 22.2944 15.9442 22.2944H9.82234C9.3198 22.2944 8.86295 21.9746 8.77157 21.4721L7.26396 15.5787H18.5025L16.9949 21.4721ZM18.2284 14.4822H7.58376C6.80711 14.4822 6.16751 13.8426 6.16751 13.066C6.16751 12.2893 6.80711 11.6497 7.58376 11.6497C7.40102 11.4213 7.30965 11.1472 7.30965 10.8274C7.30965 10.0508 7.94924 9.41117 8.72589 9.41117H9.18274C9.09137 9.22843 9 9.09137 9 8.86294C9 8.17766 9.54822 7.72081 10.1421 7.72081H10.6904C11.1929 8.40609 12.0152 8.86294 12.9289 8.86294C13.8426 8.86294 14.665 8.40609 15.1675 7.72081H15.7157C16.3553 7.72081 16.8579 8.22335 16.8579 8.86294C16.8579 9.09137 16.8122 9.27411 16.6751 9.41117H17.132C17.9086 9.41117 18.5482 10.0508 18.5482 10.8274C18.5482 11.1472 18.4569 11.467 18.2741 11.6497C19.0508 11.6497 19.6904 12.2893 19.6904 13.066C19.6447 13.8883 19.0051 14.4822 18.2284 14.4822Z" />
      </svg>

      <h2 class="text-xl italic font-bold leading-loose highlight highlight-rose">Süßes</h2>
    </div>

    <div class="flex px-5 py-2 space-x-5 overflow-auto">
      <?php if (!($sweet = $recipes->filterBy('category', 'sweet'))->isEmpty()) : ?>
        <?php foreach ($sweet as $recipe) : ?>
          <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
        <?php endforeach ?>
      <?php else : ?>
        <p class="m-auto">Keine Rezepte vorhanden.</p>
      <?php endif ?>
    </div>
  </section>

  <section class="mb-4">
    <div class="flex items-center justify-center mb-4">
      <svg class="mr-3 transform translate-y-1 fill-current text-yellow" width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
        <path d="M14.2538 13.1117V9.59391C14.2538 9.18274 13.8883 8.81726 13.4772 8.81726C13.066 8.81726 12.7005 9.18274 12.7005 9.59391V13.4772C12.7005 13.7056 12.7919 13.934 12.9289 14.0711L15.2132 16.3553C15.533 16.6751 16.0355 16.6751 16.3553 16.3553C16.6751 16.0355 16.6751 15.533 16.3553 15.2132L14.2538 13.1117Z" />
        <path d="M13.4772 0C6.03046 0 0 6.03046 0 13.4772V26.9543H13.4772C20.9239 26.9543 26.9543 20.9239 26.9543 13.4772C27 6.03046 20.9239 0 13.4772 0ZM13.4772 22.8426C8.31472 22.8426 4.11168 18.6396 4.11168 13.4772C4.11168 8.31472 8.31472 4.11168 13.4772 4.11168C18.6396 4.11168 22.8426 8.31472 22.8426 13.4772C22.8426 18.6396 18.6396 22.8426 13.4772 22.8426Z" />
      </svg>

      <h2 class="text-xl italic font-bold leading-loose highlight highlight-yellow">
        Quickies
      </h2>
    </div>

    <div class="flex px-5 py-2 space-x-5 overflow-auto">
      <?php if (!($quicky = $recipes->filterBy('category', 'quicky'))->isEmpty()) : ?>
        <?php foreach ($quicky as $recipe) : ?>
          <?= snippet('recipe-card', ['recipe' => $recipe]) ?>
        <?php endforeach ?>
      <?php else : ?>
        <p class="m-auto">Keine Rezepte vorhanden.</p>
      <?php endif ?>
    </div>
  </section>
</main>