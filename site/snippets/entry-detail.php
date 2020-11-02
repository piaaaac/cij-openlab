<?php

/**
 * @param $entry - Kirby page
 *
 */

$template = $entry->template() == "item" ? "item" : "entity";

$relatedEntries = [];

function newRelatedEntries ($colTitle, $pages, $entriesTemplate, $relationType = "direct", $relationVia = null) {
	return [
		"type"					=> "relatedEntries",
		"colTitle"			=> $colTitle,
		"pages"					=> $pages,
		"template"			=> $entriesTemplate,
		"relationType"	=> $relationType,
		"relationVia"		=> $relationVia
	];
}

function separator () {
	return ["type" => "separator"];
}

// -------------------
// DIRECT RELATIONSHIP
// -------------------

if ($template == "item") {

	if ($entry->author()->isNotEmpty()) { 
		$colTitle = ($entry->author()->toPages()->count() > 1) ? pluralName("author") : "author";
		$relatedEntries[] = newRelatedEntries($colTitle, $entry->author()->toPages(), "entity");
	}
	if ($entry->commission()->isNotEmpty()) { 
		$colTitle = "commissioned by";
		$relatedEntries[] = newRelatedEntries($colTitle, $entry->commission()->toPages(), "entity");
	}
	if ($entry->funder()->isNotEmpty()) { 
		$colTitle = ($entry->commission()->toPages()->count() > 1) ? pluralName("funder") : "funder";
		$relatedEntries[] = newRelatedEntries($colTitle, $entry->funder()->toPages(), "entity");
	}
	if ($entry->platform()->isNotEmpty()) { 
		$colTitle = ($entry->platform()->toPages()->count() > 1) ? pluralName("platform") : "platform";
		$relatedEntries[] = newRelatedEntries($colTitle, $entry->platform()->toPages(), "entity");
	}
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

	$relItems = page("database/items")->children()->filter(function ($item) use ($entry) {
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

$relatedEntries[] = separator();

// RELATED VIA TOPIC OR GEO
// template item or entity

/*

foreach ($entry->topics()->split() as $topic) {
	$allEntries = page("items")->children()->add(page("entities")->children());
	$relEntitiesViaTopic = $allEntries->filter(function ($e) use ($entry, $topic) {
		if ($e->id() === $entry->id()) { return false; }
		return in_array($topic, $e->topics()->split());
	});
	if ($relEntitiesViaTopic->count() > 0) {
		$relatedEntries[] = newRelatedEntries("more in #$topic", $relEntitiesViaTopic, "any", "topic", $topic);
	}
}

foreach ($entry->geo()->split() as $place) {
	$allEntries = page("items")->children()->add(page("entities")->children());
	$relEntitiesViaPlace = $allEntries->filter(function ($e) use ($entry, $place) {
		if ($e->id() === $entry->id()) { return false; }
		return in_array($place, $e->geo()->split());
	});
	if ($relEntitiesViaPlace->count() > 0) {
		$relatedEntries[] = newRelatedEntries("more in #$place", $relEntitiesViaPlace, "any", "geo", $place);
	}
}
*/


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
				<h1 class="font-l mb-2"><?= $entry->title() ?></h1>
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
				
				<?php if ($entry->description()->isNotEmpty()): ?>
					<div class="mb-4"><?= $entry->description()->kt() ?></div>
				<?php endif ?>

				<?php 
				$tags = array_merge($entry->geo()->split(), $entry->topics()->split());
				?>
				<?php if (count($tags) > 0): ?>
					<div>
						<header class="font-xs upper">Filed under</header>
						<p><?= implode(", ", $tags) ?></p>
					</div>
				<?php endif ?>
				

				<?php /*
				<?php if ($entry->topics()->isNotEmpty()): ?>
					<div class="mt-4">
						<header class="font-xs upper">Topics</header>
						<p><?= $entry->topics()->value() ?></p>
					</div>
				<?php endif ?>

				<?php if ($entry->geo()->isNotEmpty()): ?>
					<div class="mt-4">
						<header class="font-xs upper">Related countries</header>
						<p><?= $entry->geo()->value() ?></p>
					</div>
				<?php endif ?>
				*/ ?>
				
				<!--  
				<p class="mt-2">&blacksquare;</p>
				<p class="mt-3">&block;</p>
				<p>&lhblk;</p>
				<p>&block;&block;&block;</p>
				-->
			</div>
		</div>
		<div class="col-md-6 pad">
			<div class="row">

				<!--  
				"colTitle"			=> $colTitle,
				"pages"					=> $pages,
				"template"			=> $entriesTemplate,
				"relationType"	=> $relationType,
				"relationVia"		=> $relationVia
				-->

				<?php foreach ($relatedEntries as $block): ?>
					<?php if ($block["type"] == "separator"): ?>
						<div class="col-12"></div>
					<?php else: ?>
						<?php 
						$col = ($block["template"] == "entity") ? "col-md-6" : "col-12";
						?>
						<div class="<?= $col ?> mb-4">
							<div class="related-block">
								<header class="font-xs upper"><?= $block["colTitle"] ?></header>
								<div class="list">
									<?php foreach ($block["pages"] as $e): ?>
										<a class="hover-bg-red" onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
										<br />
									<?php endforeach ?>
								</div>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach ?>

			</div>
		</div>
	</div>
</div>