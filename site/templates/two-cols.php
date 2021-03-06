<?php snippet("header") ?>

<main class="green">

  <?php snippet("page-title") ?>

  <div class="my-5 py-5">

	<section class="bg-bg1">
	  <div class="container-fluid text-width-two-cols">
	    <div class="row">
	    	<div class="col-lg-6 mb-5">
	    		<div class="kt two-cols px-lg-3"><?= $page->col1()->kt() ?></div>
	    	</div>
	    	<div class="col-lg-6 mb-5">
	    		<div class="kt two-cols px-lg-3"><?= $page->col2()->kt() ?></div>
	    	</div>
	    </div>
	  </div>
	</section>
</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>
