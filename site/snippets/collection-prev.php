<?php

/**
 * @param $collection - Kirby page
 *
 */

?>

<div class="col-md-6 position-relative">
	<div class="page-item-prev collection click-open-data-url" data-url="<?= $collection->url() ?>">
	  <div class="stats font-xs upper mb-1"><?= $collection->entries()->toPages()->count() ?> entries</div>
	  <div class="title"><?= $collection->title() ?></div>
	  <div class="entries-img">
	    <?php foreach ($collection->entries()->toPages() as $entry): ?>
      	<div class="entry-img-wrapper">
	      	<div class="entry-img <?= $entry->template() ?>" 
	      		   style="background-image: url(<?= $entry->img()->toFile()->url() ?>);" 
	      		   onclick="a.openDetail(event, '<?= $entry->id() ?>')"></div>
      	</div>
	    <?php endforeach ?>
    	
    	<div class="flex-grow-1"></div>
    	<div class="flex-grow-1 d-none d-sm-block"></div>
    	<div class="flex-grow-1 d-none d-sm-block"></div>
    	<div class="flex-grow-1 d-none d-sm-block"></div>
    	<div class="flex-grow-1 d-none d-sm-block"></div>
    	<div class="flex-grow-1 d-none d-sm-block"></div>
    	<div class="flex-grow-1 d-none d-lg-block"></div>
    	<div class="flex-grow-1 d-none d-lg-block"></div>
    	<div class="flex-grow-1 d-none d-lg-block"></div>

	  </div>
	  <div class="bottom">
	    <div class="font-xs upper"><?= bylineWithPic($collection) ?></div>
	    <div class="arrow font-xl">&rarr;</div>
	  </div>
	</div>
</div>
