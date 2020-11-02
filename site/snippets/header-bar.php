<?php /*

<nav class="header main">
  <div class="left d-flex align-items-center">
    <a class="d-inline-flex" href="<?= $site->url() ?>"><img class="home-link logo" src="<?= kirby()->url("assets") ?>/images/logo.svg" /></a>
    <a class="active ml-0" href="<?= $site->url() ?>">OPEN LAB</a>
  </div>
  <div class="right d-flex align-items-center">
    <?php foreach ($site->pages()->listed() as $p): ?>
      <?php 
      $active = "";
      if ($page->is($p) || $page->parents()->has($p)) {
        $active = "active";
        $currentMenuItem = $p;
      }
      ?>
      <a class="<?= $active ?>" href="<?= $p->url() ?>"><?= $p->title() ?></a>
    <?php endforeach ?>
  </div>
</nav>

<nav class="header sub">
  <div class="left">

    <a class="px-4" role="button" id="zoom-out" onclick="a.zoomOut();">–</a>
    <span class="color-white">Zoom</span>
    <a class="px-4" role="button" id="zoom-in" onclick="a.zoomIn();">+</a>
  
  </div>
  <div class="right d-flex align-items-center">
    <?php if ($currentMenuItem): ?>
      <?php foreach ($currentMenuItem->children()->listed() as $sp): ?>
        <a class="<?= "WIP" ?>" href="<?= $sp->url() ?>"><?= $sp->title() ?></a>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</nav>

*/ ?>







<?php 
$currentMenuItem = null;
?>

<nav class="header main">
  <div class="left d-flex align-items-center">
    <a class="d-inline-flex" href="<?= $site->url() ?>"><img class="home-link logo" src="<?= kirby()->url("assets") ?>/images/logo.svg" /></a>
    <a class="active ml-0" href="<?= $site->url() ?>">OPEN&nbsp;LAB</a>
  </div>
  <div class="right d-flex align-items-center">
    <?php foreach ($site->menu()->toStructure() as $item): ?>
      <?php 
      if (!$item->visible()->toBool()) { continue; }
      $p = $item->menuPage()->toPage();
      $active = "";
      if ($page->is($p) || $page->parents()->has($p)) {
        $active = "active";
        $currentMenuItem = $item;
      }
      ?>
      <a class="<?= $active ?>" href="<?= $p->url() ?>"><?= $p->title() ?></a>
    <?php endforeach ?>
  </div>
</nav>

<nav class="header sub">
  <div class="left d-flex align-items-center justify-content-start">

    <!-- OPTIONAL UI FOR SPECIFIC PAGES -->

    <!-- Explore --- Zoom UI -->

    <?php if ($page->is("database/explore")): ?>
      <span class="margin"></span>
      <span class="color-white font-menu mr-3">ZOOM</span>
      <a class="zoom-btn" role="button" id="zoom-out" onclick="a.zoomOut();">–</a><a class="zoom-btn" role="button" id="zoom-in" onclick="a.zoomIn();">+</a>
    <?php endif ?>
  
    <!-- Search --- Input UI -->
    
    <?php if ($page->is("database/search")): ?>
      <div id="enter"><img src="<?= $kirby->url("assets") ?>/images/enter.svg" /></div>
      <?php if (get("q")): ?>
        <div class="icon">
          <a href="<?= $page->url() ?>" class="d-flex"><img class="search" src="<?= $kirby->url("assets") ?>/images/x.svg" /></a>
        </div>
      <?php else: ?>
        <div class="icon"><img class="search" src="<?= $kirby->url("assets") ?>/images/search.svg" /></div>
      <?php endif ?>

      <form id="search-form" action="<?= $page->url() ?>" method="get">
        <input id="search-query" name="q" type="text" value="<?= $query ?>" placeholder="search" /></form>
    <?php endif ?>
  
  </div>
  <div class="right d-flex align-items-center">
    <?php if ($currentMenuItem): ?>
      <?php foreach ($currentMenuItem->subpages()->toPages() as $sp): ?>
        <?php 
        $subActive = "";
        if ($page->is($sp) || $page->parents()->has($sp)) {
          $subActive = "active";
        }
        ?>
        <a class="<?= $subActive ?>" href="<?= $sp->url() ?>"><?= $sp->title() ?></a>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</nav>



