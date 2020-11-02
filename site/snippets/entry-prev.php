<?php

/**
 * @param $entry - Kirby page
 *
 */

?>

<?php 
$template = $entry->template() == "item" ? "item" : "entity";
/*

if ($template == "item") {
  
  // ITEMS
  // -----

  $byline       = $entry->smartByline();    
  $authors      = $entry->author()->toPages();
  $commissions  = $entry->commission()->toPages();
  $funders      = $entry->funder()->toPages();
  $platforms    = $entry->platform()->toPages();
  $entitiesPages = $authors->add($commissions)->add($funders)->add($platforms);
  $entities = [];
  foreach ($entitiesPages as $entity) {
    $entities[] = $entity->uid();
    if (!array_key_exists($entity->uid(), $allEntities)) { 
      $allEntities[$entity->uid()] = $entity->title()->value();
    }
  }

} else {
  
  // ENTITIES
  // --------

  $byline = $entry->byline()->value();
  $entities = [$entry->uid()];
  if (!array_key_exists($entry->uid(), $allEntities)) {
    $allEntities[$entry->uid()] = $entry->title()->value();
  }
}

// ALL
// ---

$topics = [];
foreach ($entry->topics()->split() as $topic) {
  $t = Str::slug($topic);
  $topics[] = $t;
  if (!array_key_exists($t, $allTopics)) {
    $allTopics[$t] = $topic;
  }
}
$places = [];
foreach ($entry->geo()->split() as $place) {
  $p = Str::slug($place);
  $places[] = $p;
  if (!array_key_exists($p, $allPlaces)) {
    $allPlaces[$p] = $place;
  }
}

$imgUrl = $entry->img()->toFile()->url();
*/ ?>

<div class="entry-prev zoom-3" 
     data-template="<?= $template ?>" 
     data-uid="<?= $entry->uid() ?>">

	<div class="zoom-3">
    <div class="image <?= $template ?>" style="background-image: url(<?= $entry->img()->toFile()->url() ?>);">
      <img src="<?= $kirby->url("assets") ?>/images/square.png" />
    </div>
    <div class="texts">
      <p class="byline"><?= $entry->smartByline() ?></p>
      <p class="title"><?= $entry->title()->short(100) ?></p>
    </div>
	</div>
</div>
