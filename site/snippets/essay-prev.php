<?php

/**
 * @param $essay - Kirby page
 *
 */

?>

<div class="col-md-6 position-relative"> <!--  align-items-stretch -->
	<div class="page-item-prev essay click-open-data-url" data-url="<?= $essay->url() ?>">
	  <div class="title"><?= $essay->title() ?></div>
	  <div class="bottom">
	    <div class="font-xs upper"><?= bylineWithPic($essay) ?></div>
	    <div class="arrow font-xl">&rarr;</div>
	  </div>
	</div>
</div>
