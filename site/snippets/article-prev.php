<?php

/**
 * @param $article - Kirby page
 *
 */

?>

<div class="col-md-6 position-relative"> <!--  align-items-stretch -->
	<div class="page-item-prev article click-open-data-url" data-url="<?= $article->url() ?>">
	  <div class="title"><?= $article->title() ?></div>
	  <div class="bottom">
	    <div class="font-xs upper"><?= bylineWithPic($article) ?></div>
	    <div class="arrow font-xl">&rarr;</div>
	  </div>
	</div>
</div>
