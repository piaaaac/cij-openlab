<?php snippet("header") ?>

<main class="default">
  <div class="full-essay">

    <?php snippet("page-title-byline") ?>

    <section class="pb-5">
      <!--  
      <div class="container-fluid text-width pb-5">
        <div class="row">
          <div class="col kt">
            <?= $page->text()->kt() ?>
          </div>
        </div>
      </div>
      -->
      <div class="text-width kt pb-5">
        <?= $page->text()->kt() ?>
      </div>
    </section>
  </div>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
