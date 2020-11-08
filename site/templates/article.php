<?php snippet("header") ?>

<main class="default">
  <div class="full-essay">

    <?php snippet("page-title-byline") ?>

    <section class="pt-4 pb-5">
      <div class="container-fluid text-width pb-5">
        <div class="row">
          <div class="col kt">
            <?= $page->text()->kt() ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
