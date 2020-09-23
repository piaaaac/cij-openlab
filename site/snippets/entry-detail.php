<?php

/**
 * @param $entry - Kirby page
 *
 */

$template = $entry->template() == "item" ? "item" : "entity";

?>

<div class="container-fluid">
	<div class="row pb-5">
		<div class="col-sm-6">
			<div class="title"><?= $entry->title() ?></div>
		</div>
		<div class="col-sm-6">
			<div class="image" style="background-image: url(<?= $entry->img()->toFile()->url() ?>);"></div>
		</div>
	</div>
	<div class="row pb-5">
		<div class="col-sm-6">
			<div class="description"><?= $entry->description()->kt() ?></div>
		</div>
	</div>
	<div class="row pb-5">
		<div class="col-sm-3">
			<div class="related-author">
				<header class="font-xs upper">Funded by</header>
				<div class="list"><?= $entry->author()->toPage() ?></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="related-commission">
				<header class="font-xs upper">Commissioned by</header>
				<div class="list"><?= $entry->commission()->toPage() ?></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="related-funder">
				<header class="font-xs upper">Author</header>
				<div class="list"><?= $entry->funder()->toPage() ?></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="related-platform">
				<header class="font-xs upper">Platform</header>
				<div class="list"><?= $entry->platform()->toPage() ?></div>
			</div>
		</div>
	</div>
</div>