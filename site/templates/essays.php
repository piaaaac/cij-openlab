<?php snippet("header") ?>

<?php
$essays = $page->children()->listed();
?>

<main class="default">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <h1 class="page-title">ESSAYS</h1>
      </div>
    </div>
    <div class="row">
      <?php foreach ($essays as $essay) {
        snippet("essay-prev", ["essay" => $essay]);
      } ?>
    </div>
  </div>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
