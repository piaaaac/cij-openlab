<?php snippet("header") ?>

<?php
$articles = $page->children()->listed();
?>

<main class="default">

  <?php snippet("page-title") ?>

  <div class="container-fluid">
    <div class="row">
      <?php foreach ($articles as $article) {
        snippet("article-prev", ["article" => $article]);
      } ?>
    </div>
  </div>

  <div class="my-5 py-5">

</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
