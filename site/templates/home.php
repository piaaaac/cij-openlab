<?php snippet("header") ?>

<?php
$entries = page("items")->children()->listed()->add(page("entities")->children()->listed())->shuffle();
$allTopics = [];
$allEntities = [];
$allPlaces = [];
?>

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
          <div class="image" style="background-image: url(<?= $imgUrl ?>);"></div>
          <span class="title font-zoom"><strong><?= $entry->title() ?></strong></span>
          <span class="byline font-xs"><?= $byline ?></span></span><div 


            class="zoom-3-4">
          <div class="image" style="background-image: url(<?= $imgUrl ?>);"></div>
          <div class="texts">
            <p class="byline color-grey"><?= $byline ?></p>
            <p class="title"><?= $entry->title() ?></p>
          </div></div></div>

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
    <a class="meta-link" data-filter-by="topics" data-topics="<?=   "<$tSlug>" ?>"><?= $topic ?></a>
  <?php endforeach ?>
</div>

<div id="overlay" class="">
  <div id="detail-content"></div>
</div>


<script>

  // -------------------------------------------
  // EXECUTION
  // -------------------------------------------

  // var state = {
  //   zoom: 1;
  // };
  var a = new App();
  a.zoomTo(2);

  // -------------------------------------------
  // CLASSES
  // -------------------------------------------

  function App () {
    this.zoom;
    this.filterBy;
    this.filterValue;

    this.zoomTo = function (z) { 
      this.clearFilter();
      this.zoom = z;
      $(document.body).removeClass("zoom-1")
        .removeClass("zoom-2")
        .removeClass("zoom-3")
        .removeClass("zoom-4");
      $(document.body).addClass("zoom-"+ z);

      if (this.zoom < 3) {
        this.resizeTextsToFit();
      }
    }

    this.zoomIn = function () { 
      if (this.zoom < 4) {
        this.zoomTo(this.zoom + 1);
      }
    }

    this.zoomOut = function () { 
      if (this.zoom > 1) {
        this.zoomTo(this.zoom - 1);
      }
    }

    this.filter = function (by, value) {
      if (this.filterBy == by && this.filterValue == value) {
        this.clearFilter();
      } else {
        this.filterBy = by;
        this.filterValue = value;
        $(".entry").addClass("hide");
        $(".entry[data-"+ by +"*='"+ value +"']").removeClass("hide");
        $(".meta-link").removeClass("selected");
        $(".meta-link[data-filter-by='"+ by +"'][data-"+ by +"='"+ value +"']").addClass("selected");
      }
    }

    this.clearFilter = function () {
      this.filterBy = undefined;
      this.filterValue = undefined;
      $(".entry").removeClass("hide");
      $(".meta-link").removeClass("selected");
    }

    /* Size on .font-zoom */
    // this.resizeTextsToFit = function () {
    //   var size = 11; // min
    //   var max = Math.round($(window).width() / 25); // max
    //   $(".font-zoom").css("font-size", size);
    //   while ($(".entries").height()+50 < $(window).height()) {
        
    //     size++;
    //     $(".font-zoom").css("font-size", size);

    //     console.log("w: "+ $(window).height(), size, $(".entries").height());
    //   }
    //   if (a.zoom == 1) { size--; }
    //   if (a.zoom == 2) { size = size * 2; if (size > max) { size = max; } }
    //   $(".font-zoom").css("font-size", size);
    //   console.log(size);
    // }
    /* Size on .entry */
    this.resizeTextsToFit = function () {
      var size = 11; // min
      var max = Math.round($(window).width() / 25); // max
      $(".entry").css("font-size", size);
      while ($(".entries").height()+50 < $(window).height()) {
        
        size++;
        $(".entry").css("font-size", size);

        console.log("w: "+ $(window).height(), size, $(".entries").height());
      }
      if (a.zoom == 1) { size--; }
      if (a.zoom == 2) { size = size * 2; if (size > max) { size = max; } }
      $(".entry").css("font-size", size);
      console.log(size);
    }
  }

  // -------------------------------------------
  // FUNCTIONS
  // -------------------------------------------

  // -------------------------------------------
  // EVENTS
  // -------------------------------------------

  $(".entry").mouseover(function () {
    var entities = $(this).data("entities").split(",");
    var topics = $(this).data("topics").split(",");
    var places = $(this).data("places").split(",");


    if (a.zoom < 4) {
      
      $(this).addClass("active");
      
      // V1
      // ---------------------------------------
      // entities.forEach(function (e) {
      //   $(".entry[data-entities*='"+ e +"']").addClass("active");
      // });
      // topics.forEach(function (e) {
      //   $(".entry[data-topics*='"+ e +"']").addClass("active");
      // });
      // places.forEach(function (e) {
      //   $(".entry[data-places*='"+ e +"']").addClass("active");
      // });
      // ---------------------------------------

      // V2
      // ---------------------------------------
      $(".entry").addClass("redacted");
      entities.forEach(function (e) {
        $(".entry[data-entities*='"+ e +"']").removeClass("redacted").addClass("active");
      });
      topics.forEach(function (e) {
        $(".entry[data-topics*='"+ e +"']").removeClass("redacted");
      });
      places.forEach(function (e) {
        $(".entry[data-places*='"+ e +"']").removeClass("redacted");
      });
      // ---------------------------------------
    }
    if (a.zoom == 4) {
      entities.forEach(function (e) {
        $(".meta-link[data-entities*='"+ e +"']").addClass("active");
      });
      topics.forEach(function (e) {
        $(".meta-link[data-topics*='"+ e +"']").addClass("active");
      });      
    }
  });

  $(".entry").mouseout(function () {
    $(".entry, .meta-link").removeClass("active");
    $(".entry").removeClass("redacted");
  });

  $(".entry").click(function () {
    // console.log("entities", $(this).data("entities").split(","));
    // console.log("topics", $(this).data("topics").split(","));
    // console.log("places", $(this).data("places").split(","));
    
    var callUrl = "<?= $site->url() ?>/items/"+ $(this).data("uid");
    console.log(callUrl);

    $("#detail-content").empty();
    
    


    $("#detail-content").load(callUrl, null, function () {
      $("#overlay").addClass("show");
    });
    
    // $.get(callUrl, function( data ) {
    //   $( "#detail-content" ).html( data );
    //   console.log( "Load was performed.", data );
    // });


    // $("#overlay").addClass("show");
  });

  $(".meta-link").click(function () {
    var filterBy = $(this).data("filter-by");
    var filterValue = $(this).data(filterBy);
    a.filter(filterBy, filterValue);
  });

  $("#overlay").click(function () {
    $(this).removeClass("show");
  });

  $(window).resize(function (e) {
    if (a.zoom < 3) {
      a.resizeTextsToFit();
    }
  });


</script>

<?php snippet("footer") ?>
