<?php

/**
 * @param $article - Kirby page
 *
 */

?>

<div class="col-lg-6 position-relative"> <!--  align-items-stretch -->
	<div class="page-item-prev article click-open-data-url" data-url="<?= $article->url() ?>">
	  <div class="top">
	  	<h2 class="title upper"><?= $article->title() ?></h2>
	    <div class="arrow font-xl d-none d-sm-block">&rarr;</div>
	  </div>
	  <?php if ($article->img()->isNotEmpty()): ?>
	  	<div class="cover" style="background-image: url('<?= $article->img()->toFile()->url() ?>');"></div>
	  <?php endif ?>
	  <div class="bottom">
	    <div class="font-m"><?= bylineWithPic($article) ?></div>
	  </div>
	</div>
</div>
