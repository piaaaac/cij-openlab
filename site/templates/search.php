<?php snippet("header") ?>

<?php
$count = $entries->count();
$counterText = $count == 1 ? "1 ENTRY" : "$count ENTRIES";
$hideHeaderCells = $count == 0 ? "hide " : "";

function tableRow ($entry) { 
  $author = $entry->author()->toPage();
  $authorText = $author ? $author->title() : "—";
  $year = $entry->year()->value();
  $yearText = $year ? $year : "—";
  ?>

  <div class="search-table-row" 
       data-type="<?= $entry->entryType()->value() ?>" 
       onclick="a.openDetail(event, '<?= $entry->id() ?>');"
   >
    <div class="cell image <?= $entry->template() ?>" 
         style="background-image: url(<?= $entry->img()->toFile()->thumb()->url() ?>);"></div>
    <div class="cell title"><?= $entry->title()->value() ?></div>
    <div class="cell type"><?= ucfirst($entry->entryType()->value()) ?></div>
    <div class="cell author"><?= $authorText ?></div>
    <div class="cell flex-grow-1"></div>
    <div class="cell year"><?= $yearText ?></div>
  </div>

<?php }
?>

<main class="green">
  <section class="bg-white">
    <div class="container-fluid">
      <div class="row">
        <div class="col entry-types">
          <?php foreach ($types as $type => $stat): ?>
            <a class="mx-2" 
               onclick="filterTable(this, '<?= $type ?>');"
            ><?= ucfirst($type) ?><sup class="font-xs apex ml-1"><?= $stat ?></sup></a>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </section>
  
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        
        <div class="search-table">

          <header class="search-table-row">
            <div class="cell color-black40 title counter"><?= $counterText ?></div>
            <div class="cell opacity-0 <?= $hideHeaderCells ?>image"></div>
            <div class="cell color-black40 <?= $hideHeaderCells ?>type">TYPE</div>
            <div class="cell color-black40 <?= $hideHeaderCells ?>author">AUTHOR</div>
            <div class="cell color-black40 <?= $hideHeaderCells ?>flex-grow-1"></div>
            <div class="cell color-black40 <?= $hideHeaderCells ?>year">YEAR</div>
          </header>

          <?php foreach ($entries as $entry): ?>
            <?php tableRow($entry) ?>
          <?php endforeach ?>
        </div>

      </div>
    </div>
  </div>

  <div class="spacer py-5"></div>

</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
