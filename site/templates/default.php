<?= snippet('head') ?>
<?= snippet('menu') ?>

<?php $show_title = $page->show_title()->toBool() ?>

<main class="flex-grow px-5 py-6 bg-fixed <?= e(!$show_title, 'bg-angled-rose') ?>">
  <?php if ($show_title) : ?>
    <h1 class="text-xl italic font-bold leading-wide">
      <span class="highlight highlight-yellow"><?= $page->title()->html() ?></span>
    </h1>
  <?php endif ?>


  <?php foreach ($page->editor()->blocks() as $block) : ?>
    <?php if ($block->type() === 'h2') : ?>
      <h2 class="text-xl italic font-bold leading-wide">
        <span class="highlight <?= e($show_title, 'highlight-rose', 'highlight-yellow') ?>">
          <?= $block->content()->kt()->inline() ?>
        </span>
      </h2>
    <?php else : ?>
      <?php if ($block->type() === 'paragraph' && html($block->content()->kt()->inline()) === '') : ?>
        <p>&nbsp;</p>
      <?php else : ?>
        <?= $block->html() ?>
      <?php endif ?>
    <?php endif ?>
  <?php endforeach ?>
</main>