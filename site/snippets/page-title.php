<section class="page-title">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1 class="page-title-text"><?= $forceTitle ?? $page->title()->upper() ?></h1>

        <?php /* if ($page->is("database/explore")): ?>
          <div class="controls">
            <a class="" role="button" data-zoom="pm" onclick="a.zoomOut();">&ndash;</a>
            <a class="" role="button" data-zoom="pm" onclick="a.zoomIn();">+</a>
          </div>
        <?php endif */ ?>

      </div>
      <?php if ($page->intro()->isNotEmpty()): ?>
  	    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
  	      <div class="page-subtitle font-l text-center"><?= $page->intro()->kti() ?></div>
  	    </div>
      <?php endif ?>
    </div>
  </div>
</section>