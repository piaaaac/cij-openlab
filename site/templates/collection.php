<?php snippet("header") ?>

<main class="default">
  <div class="container-fluid">
    <div class="row">
      <div class="col my-4">
        <a class="font-m my-2"
           href="<?= $page->parent()->url() ?>">&larr; <?= $page->parent()->title() ?></a>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="full-collection">
          
          <div class="row">
            <div class="col-xl-4">
              <div class="title"><?= $page->title() ?></div>
              <div class="font-xs upper mb-4"><?= bylineWithPic($page) ?></div>
              <div class="text font-l"><?= $page->text()->kt() ?></div>
            </div>
            <div class="col-xl-8 entries">

              <?php foreach ($page->entries()->toPages() as $entry): ?>
                <?php snippet("entry-prev", ["entry" => $entry]) ?>
              <?php endforeach ?>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
