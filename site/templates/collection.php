<?php snippet("header") ?>

<main class="default">

  <?php snippet("page-title-byline") ?>

  <div class="text-width kt">
    <div class="text font-l"><?= $page->text()->kt() ?></div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="full-collection">          
          <div class="row">
            <div class="col-12 entries">
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
