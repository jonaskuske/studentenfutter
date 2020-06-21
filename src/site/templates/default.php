<?php $show_title = $page->show_title()->toBool(); ?>

<?= snippet('head', ['body_class' => r(!$show_title, 'bg-fixed bg-angled-rose')]) ?>


  <?= snippet('menu') ?>
  <?= snippet('install-banner') ?>


  <main class="flex-grow px-5 py-6 bg-fixed">
    <h1 class="text-xl italic font-bold leading-wide <?= e(!$show_title, 'sr-only') ?>">
      <span class="highlight highlight-yellow"><?= $page->title()->inline() ?></span>
    </h1>


    <?php foreach ($page->editor()->blocks() as $block) : ?>
      <?php if (($type = $block->type()) === 'h2') : ?>
        <h2 class="text-xl italic font-bold leading-wide">
          <span class="highlight <?= e($show_title, 'highlight-rose', 'highlight-yellow') ?>">
            <?= $block->content()->kt()->inline() ?>
          </span>
        </h2>
      <?php else : ?>
        <?php if ($type === 'paragraph' && html($block->content()->kt()->inline()) === '') : ?>
          <p>&nbsp;</p>
        <?php else : ?>
          <?= $block->html() ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </main>
