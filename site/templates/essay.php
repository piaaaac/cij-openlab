<?php snippet("header") ?>

<main class="default">
  <div class="container-fluid">
    <div class="row">
      <div class="col my-4">
        <a class="font-m my-2"
           href="<?= $page->parent()->url() ?>">&larr; <?= $page->parent()->title() ?></a>
      </div>
    </div>
  </div>

  <div class="full-essay">

    <section class="opening">
      <div class="container-fluid text-width">
        <div class="row">
          <div class="col content">
            <h1 class="font-xxl"><?= $page->title() ?></h1>
            <div class="font-xs upper my-4"><?= bylineWithPic($page) ?></div>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-5">
      <div class="container-fluid text-width">
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
