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
    <a class="active ml-0" href="<?= $site->url() ?>">OPEN LAB</a>
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
  <div class="left">

    <?php if ($page->is("database/explore")): ?>
      <a class="px-4" role="button" id="zoom-out" onclick="a.zoomOut();">–</a>
      <span class="color-white">Zoom</span>
      <a class="px-4" role="button" id="zoom-in" onclick="a.zoomIn();">+</a>
    <?php endif ?>
  
  </div>
  <div class="right d-flex align-items-center">
    <?php if ($currentMenuItem): ?>
      <?php foreach ($currentMenuItem->subpages()->toPages() as $sp): ?>
        <?php 
        $subActive = ($page->is($sp)) ? "active" : "";
        ?>
        <a class="<?= $subActive ?>" href="<?= $sp->url() ?>"><?= $sp->title() ?></a>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</nav>



