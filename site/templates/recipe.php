<?= snippet('header') ?>
<?= snippet('menu') ?>

<h1 class="italic font-bold text-md">
  <span class="highlight highlight-blue highlight-sm"><?= $page->title() ?></span>
</h1>
<br>

<h2 class="font-bold">Kategorie</h2>
<p>
  <?= $page->blueprint()->field('category')['options'][$page->category()->value()] ?>
</p>

<br>
<br>

<?php foreach ($page->images() as $image) : ?>
  <?= $image ?>
<?php endforeach ?>

<br>
<br>

<h2 class="font-bold">Zubereitung</h2>
<?php foreach ($page->description()->toStructure() as $step) : ?>
  <p><?= $step->text() ?></p>
<?php endforeach ?>

<br>
<br>

<table>
  <caption class="font-bold text-left">Zutaten</caption>
  <thead>
    <tr class="border-b">
      <th class="pr-4 font-normal text-right">Menge</th>
      <th class="font-normal text-left">Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($page->ingredients()->toStructure() as $ingredient) : ?>
      <tr>
        <td class="pr-4 text-right"><?= $ingredient->amount() . $ingredient->unit() ?></td>
        <td class="text-left"><?= $ingredient->name()->kt() ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>

<br>
<br>

<h2 class="font-bold">Info</h2>
<?= $page->info() ?>

<br>
<br>

<h2 class="font-bold">Fragen und Antworten</h2>
<?php if (!($faqs = $page->faqs()->toStructure())->isEmpty()) : ?>
  <ul>
    <?php foreach ($faqs as $faq) : ?>
      <li>
        <p><?= $faq->question()->kt() ?></p>
        <p><?= $faq->answer()->kt() ?></p>
      </li>
    <?php endforeach ?>
  </ul>
<?php else : ?>
  <p>Keine Fragen und Antworten</p>
<?php endif ?>

<br>
<br>

<h2 class="font-bold">Tipps</h2>
<?php if (!($tips = $page->tips()->toStructure())->isEmpty()) : ?>
  <ul>
    <?php foreach ($tips as $tip) : ?>
      <li>
        <p><?= $tip->textarea()->kt() ?></p>
      </li>
    <?php endforeach ?>
  </ul>
<?php else : ?>
  <p>Keine Tipps</p>
<?php endif ?>

<br>
<br>