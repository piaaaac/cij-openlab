<?php snippet("header") ?>

<?php
$collections = $page->children()->listed();
?>

<main class="default">

  <?php snippet("page-title") ?>

  <div class="my-5 py-5">

  <div class="container-fluid">
    <div class="row">
      <?php foreach ($collections as $collection) {
        snippet("collection-prev", ["collection" => $collection]);
      } ?>
    </div>
  </div>

  <div class="my-5 py-5">

</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
