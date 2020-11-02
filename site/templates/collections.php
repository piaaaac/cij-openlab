<?php snippet("header") ?>

<?php
$collections = $page->children()->listed();
?>

<main class="default">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <h1 class="page-title">COLLECTIONS</h1>
      </div>
    </div>
    <div class="row">
      <?php foreach ($collections as $collection) {
        snippet("collection-prev", ["collection" => $collection]);
      } ?>
    </div>
  </div>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
