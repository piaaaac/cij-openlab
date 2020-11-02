<?php snippet("header") ?>

<?php
$entries = page("database/items")->children()->listed()->add(page("database/entities")->children()->listed())->shuffle();
$allTopics = [];
$allEntities = [];
$allPlaces = [];
?>

<main class="database">
  <div class="entries">

    <?php for ($multiply = 0; $multiply < 1; $multiply++): ?>
      <?php foreach ($entries as $entry): ?>

        <?php
        $template = $entry->template() == "item" ? "item" : "entity";

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
        ?>

        <div class="entry" 
             data-template="<?= $template ?>" 
             data-uid="<?= $entry->uid() ?>" 
             data-entities="<?= count($entities) == 0 ? "" : "<". implode(">,<", $entities) .">" ?>" 
             data-topics="<?=   count($topics)   == 0 ? "" : "<". implode(">,<", $topics)   .">" ?>" 
             data-places="<?=   count($places)   == 0 ? "" : "<". implode(">,<", $places)   .">" ?>">

          <span class="zoom-1-2">
            <div class="image <?= $template ?>" style="background-image: url(<?= $imgUrl ?>);"></div>
            <span class="title font-zoom"><strong><?= $entry->title() ?></strong></span>
            <span class="byline font-xs"><?= $byline ?></span></span><div 

          class="zoom-3">
            <div class="image <?= $template ?>" style="background-image: url(<?= $imgUrl ?>);">
              <img src="<?= $kirby->url("assets") ?>/images/square.png" />
            </div>
            <div class="texts">
              <p class="byline"><?= $byline ?></p>
              <p class="title"><?= $entry->title()->short(100) ?></p>
            </div>
        </div></div>

      <?php endforeach ?>
    <?php endfor ?>

    <?php 
      ksort($allEntities);
      ksort($allTopics);
      ksort($allPlaces);
      // kill([
      //   "allEntities" => $allEntities, 
      //   "allTopics" => $allTopics, 
      //   "allPlaces" => $allPlaces
      // ]);
    ?>

  </div>

  <div class="meta-left">
    <?php foreach ($allEntities as $eSlug => $entity): ?>
      <a class="meta-link" data-filter-by="entities" data-entities="<?= "<$eSlug>" ?>"><?= $entity ?></a>
    <?php endforeach ?>
  </div>
  <div class="meta-right">
    <?php foreach ($allTopics as $tSlug => $topic): ?>
      <a class="meta-link" data-filter-by="topics" data-topics="<?= "<$tSlug>" ?>"><?= $topic ?></a>
    <?php endforeach ?>
  </div>
  
  <!--  
  -->
  <div id="filter-alert" onclick="a.clearFilter();">
    <div id="message">Filter: journalism (15 entries)</div>
    <a class="clear">clear filter &times;</a>
  </div>

</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>
<script>
a.zoomTo(2);
</script>

<?php snippet("footer") ?>
