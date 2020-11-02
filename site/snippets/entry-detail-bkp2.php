<?php

/**
 * @param $entry - Kirby page
 *
 */

$template = $entry->template() == "item" ? "item" : "entity";

$relatedEntries = [];

function newRelatedEntries ($colTitle, $pages, $entriesTemplate, $relationType = "direct", $relationVia = null) {
	return [
		"colTitle"			=> $colTitle,
		"pages"					=> $pages,
		"template"			=> $entriesTemplate,
		"relationType"	=> $relationType,
		"relationVia"		=> $relationVia
	];
}

// -------------------
// DIRECT RELATIONSHIP
// -------------------

if ($template == "item") {

	if ($entry->author()->isNotEmpty()) { 
		$relatedEntries[] = newRelatedEntries("author", $entry->author()->toPages(), "entity"); }
	if ($entry->commission()->isNotEmpty()) { 
		$relatedEntries[] = newRelatedEntries("commissioned by", $entry->commission()->toPages(), "entity"); }
	if ($entry->funder()->isNotEmpty()) { 
		$relatedEntries[] = newRelatedEntries("funder", $entry->funder()->toPages(), "entity"); }
	if ($entry->platform()->isNotEmpty()) { 
		$relatedEntries[] = newRelatedEntries("platform", $entry->platform()->toPages(), "entity"); }
}

elseif ($template == "entity") {

	// related entities

	if ($entry->relatedEntities()->isNotEmpty()) { 
		$relPeople 	= $entry->relatedEntities()->toPages()->filterBy("entityType", "people");
		$relOrgs 		= $entry->relatedEntities()->toPages()->filterBy("entityType", "organization");
		if ($relPeople->count() > 0) {
			$relatedEntries[] = newRelatedEntries("related people", $relPeople, "entity"); }
		if ($relOrgs->count() > 0) {
			$relatedEntries[] = newRelatedEntries("related organizations", $relOrgs, "entity"); }
	}

	// related items

	$relItems = page("items")->children()->filter(function ($item) use ($entry) {
		return 
			$item->author()->toPages()->has($entry)
			|| $item->commission()->toPages()->has($entry)
			|| $item->funder()->toPages()->has($entry)
			|| $item->platform()->toPages()->has($entry);
	});
	$relItemsByType = [];
	foreach ($relItems as $e){
		$type = $e->itemType()->value();
		if (!array_key_exists($type, $relItemsByType)) {
			$relItemsByType[$type] = [];
		}
		$relItemsByType[$type][] = $e;
	}
	foreach ($relItemsByType as $type => $entries){
		$relatedEntries[] = newRelatedEntries(pluralName($type), new Pages($entries), "item");
	}
}

// template item or entity

foreach ($entry->topics()->split() as $topic) {
	$allEntries = page("items")->children()->add(page("entities")->children());
	$relEntitiesViaTopic = $allEntries->filter(function ($entry) use ($topic) {
		return in_array($topic, $entry->topics()->split());
	});
	$relatedEntries[] = newRelatedEntries("more in #$topic", $relEntitiesViaTopic, "any", "topic", $topic);
}

foreach ($entry->geo()->split() as $place) {
	$allEntries = page("items")->children()->add(page("entities")->children());
	$relEntitiesViaTopic = $allEntries->filter(function ($entry) use ($place) {
		return in_array($place, $entry->geo()->split());
	});
	$relatedEntries[] = newRelatedEntries("more in #$place", $relEntitiesViaTopic, "any", "geo", $place);
}


// kill($relatedEntries);

// ---------------------
// INDIRECT RELATIONSHIP
// ---------------------


/* 

DIRECT RELATIONSHIP

if item 
	(entities)
	p->author
	p->commission
	p->funder
	p->platform

if entity
	(entities)
	p->relatedEntities
	(items)
	all items filtered by author, commission, funder, platform

INDIRECT RELATIONSHIP

for each tag
	all items and entities filtered by tag

for each place
	all items and entities filtered by place

*/
?>

<div class="container-fluid">
	<div class="row row-detail">
		<div class="col-md-6 pad d-flex flex-column justify-content-between">
			<div class="title">
				<p><?= $entry->title() ?></p>
				<p class="color-grey"><?= $entry->smartByline() ?></p>
				<?php if ($entry->year()->isNotEmpty()): ?>
					<p class="color-grey"><?= $entry->year()->value() ?></p>
				<?php endif ?>
			</div>
			<div class="buttons">
				<?php foreach ($entry->links()->toStructure() as $link): ?>
					<a class="button external" href="<?= $link->linkUrl()->value() ?>" target="_blank">
						<?= $link->linkText()->value() ?>
					</a>
				<?php endforeach ?>
			</div>
		</div>
		<div class="col-md-6 image-cont">
			<div class="image <?= $template ?>" style="background-image: url(<?= $entry->img()->toFile()->url() ?>);"></div>
			<div class="buttons-mobile">
				<?php foreach ($entry->links()->toStructure() as $link): ?>
					<a class="button external" href="<?= $link->linkUrl()->value() ?>" target="_blank">
						<?= $link->linkText()->value() ?>
					</a>
				<?php endforeach ?>
			</div>
		</div>
	</div>

	<div class="row row-detail">
		<div class="col-md-6 pad">
			<div class="description pr-md-3">
				<?= $entry->description()->kt() ?>
				<!--  
				<p class="mt-2">&blacksquare;</p>
				<p class="mt-3">&block;</p>
				<p>&lhblk;</p>
				<p>&block;&block;&block;</p>
				-->
			</div>
		</div>
		<div class="col-md-6 pad">


			<?php if (
				$template == "item" && (
					$entry->author()->isNotEmpty()
					|| $entry->commission()->isNotEmpty()
					|| $entry->funder()->isNotEmpty()
					|| $entry->platform()->isNotEmpty()
				)
			): ?>

				<div class="row row-detail">
					<?php if ($entry->author()->isNotEmpty()): ?>
					<div class="col-md-6 mb-4">
						<div class="related-author">
							<header class="font-xs upper">Author</header>
							<div class="list">
								<?php foreach ($entry->author()->toPages() as $e): ?>
									<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
									<br />
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<?php endif ?>
					<?php if ($entry->commission()->isNotEmpty()): ?>
					<div class="col-md-6 mb-4">
						<div class="related-commission">
							<header class="font-xs upper">Commissioned by</header>
							<div class="list">
								<?php foreach ($entry->commission()->toPages() as $e): ?>
									<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
									<br />
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<?php endif ?>
					<?php if ($entry->funder()->isNotEmpty()): ?>
					<div class="col-md-6 mb-4">
						<div class="related-funder">
							<header class="font-xs upper">Funded by</header>
							<div class="list">
								<?php foreach ($entry->funder()->toPages() as $e): ?>
									<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
									<br />
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<?php endif ?>
					<?php if ($entry->platform()->isNotEmpty()): ?>
					<div class="col-md-6 mb-4">
						<div class="related-platform">
							<header class="font-xs upper">Platform</header>
							<div class="list">
								<?php foreach ($entry->platform()->toPages() as $e): ?>
									<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
									<br />
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<?php endif ?>
				</div>

			<?php elseif ($template == "entity"): ?>
				<?php 
				$relatedItems = page("items")->children()->filter(function ($item) use ($entry) {
					return 
						$item->author()->toPages()->has($entry)
						|| $item->commission()->toPages()->has($entry)
						|| $item->funder()->toPages()->has($entry)
						|| $item->platform()->toPages()->has($entry);
				});
				$relatedEntities = $entry->relatedEntities()->toPages();
				if ($relatedEntities->count() + $relatedItems->count() > 0) { ?>
			
					<?php if ($relatedItems->count() > 0): ?>

						<div class="row">

							<?php 
							$byType = [];
							foreach ($relatedItems as $e){
								$type = $e->itemType()->value();
								if (!array_key_exists($type, $byType)) {
									$byType[$type] = [];
								}
								$byType[$type][] = $e;
							}
							?>
							<?php foreach ($byType as $type => $entries): ?>
								<div class="col-md-6 mb-4">
									<div class="">
										<header class="font-xs upper"><?= pluralName($type) ?></header>
										<div class="list">
											<?php foreach ($entries as $e): ?>
												<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
												<br />
											<?php endforeach ?>
										</div>
									</div>
								</div>
							<?php endforeach ?>

						</div>

					<?php endif ?>
				
					<?php if ($relatedEntities->count() > 0): ?>
						
						<div class="row">
						
							<?php 
							$byType = [];
							foreach ($relatedEntities as $e){
								$type = $e->entityType()->value();
								if (!array_key_exists($type, $byType)) {
									$byType[$type] = [];
								}
								$byType[$type][] = $e;
							}
							?>
							<?php foreach ($byType as $type => $entries): ?>
								<div class="col-md-6 mb-4">
									<div class="">
										<header class="font-xs upper">Related <?= pluralName($type) ?></header>
										<div class="list">
											<?php foreach ($entries as $e): ?>
												<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
												<br />
											<?php endforeach ?>
										</div>
									</div>
								</div>
							<?php endforeach ?>
						
						</div>

					<?php endif ?>

				<?php } ?>
			<?php endif ?>


		</div>
	</div>
</div>