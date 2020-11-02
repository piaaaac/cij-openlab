<?php snippet("header") ?>

<?php
function tableRow ($entry) { 
  $author = $entry->author()->toPage();
  $authorText = $author ? $author->title() : "-";
  ?>

  <div class="search-table-row" onclick="a.openDetail('<?= $entry->id() ?>');">
    <div class="cell image <?= $entry->template() ?>" 
         style="background-image: url(<?= $entry->img()->toFile()->thumb()->url() ?>);"></div>
    <div class="cell title"><?= $entry->title()->value() ?></div>
    <div class="cell type"><?= ucfirst($entry->type()->value()) ?></div>
    <div class="cell author"><?= $authorText ?></div>
    <div class="cell flex-grow-1"></div>
    <div class="cell year"><?= $entry->year()->value() ?></div>
  </div>

<?php }
?>

<main class="default">
  <div class="container-fluid">
    <div class="row">
      <div class="col entry-types">
        <?php foreach ($types as $type => $stat): ?>

          <a class="mx-2"><?= $type ." (". $stat .")" ?></a>

        <?php endforeach ?>
      </div>
    </div>
    <div class="row">
      <div class="col">
        
        <div class="search-table">

          <header class="search-table-row">
            <div class="cell color-bg2 title"><?= $entries->count() ?> ENTRIES</div>
            <div class="cell opacity-0 image"></div>
            <div class="cell color-bg2 type">TYPE</div>
            <div class="cell color-bg2 author">AUTHOR</div>
            <div class="cell color-bg2 flex-grow-1"></div>
            <div class="cell color-bg2 year">YEAR</div>
          </header>

          <?php foreach ($entries as $entry): ?>
            <?php tableRow($entry) ?>
          <?php endforeach ?>
        </div>

      </div>
    </div>
  </div>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
