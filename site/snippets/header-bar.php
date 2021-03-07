
<?php 
$currentMenuItem = null;
?>

<nav class="header main">
  <div class="left d-flex align-items-center">
    <a class="d-inline-flex" href="<?= $site->url() ?>"><img class="home-link logo" src="<?= kirby()->url("assets") ?>/images/logo.svg" /></a>
    <a class="active ml-0" href="<?= $site->url() ?>">Open&nbsp;Lab</a>
  </div>
  <div class="right d-flex align-items-center">
  
    <div class="mobile">
      <button class="hamburger hamburger--slider d-md-none" type="button" onclick="a.toggleXsMenu();">
        <span class="hamburger-box"><span class="hamburger-inner"></span></span>
      </button>
    </div>
    <div class="d-flex align-items-center desktop">
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
  
  </div>
</nav>

<nav class="header sub">
  <div class="left d-flex align-items-center justify-content-start">

    <!-- OPTIONAL UI FOR SPECIFIC PAGES -->

    <!-- Explore --- Zoom UI -->

    <?php if ($page->is("database/explore")): ?>
      <span class="margin"></span>
      <span class="font-menu mr-3">ZOOM LEVEL</span>
      <!--  
      <a class="zoom-btn" role="button" onclick="a.zoomOut();">–</a><a class="zoom-btn" role="button" onclick="a.zoomIn();">+</a>
      -->
      <a class="zoom-btn" role="button" data-zoom="1" onclick="a.zoomTo(1);">1</a>
      <a class="zoom-btn" role="button" data-zoom="2" onclick="a.zoomTo(2);">2</a>
      <a class="zoom-btn" role="button" data-zoom="3" onclick="a.zoomTo(3);">3</a>
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

    <!-- Subpages --- Back -->

    <?php 
    $pgz = new Pages();
    if (page("database/collections")) { $pgz->add("database/collections"); }

    // articles template
    if (page("essays")) { $pgz->add("essays"); }
    if (page("interchange")) { $pgz->add("interchange"); }
    if (page("commissions")) { $pgz->add("commissions"); }
    ?>
    <?php if ($pgz->has($page->parent())): ?>
      <a class="d-inline-flex align-items-center justify-content-start" 
         href="<?= $page->parent()->url() ?>"
       >
        <span class="margin">&larr;</span>
        <span><?= $page->parent()->title() ?></span>
      </a>
    <?php endif ?>

  
  </div>
  <div class="right d-flex align-items-center desktop">
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

<!-- Menu Mobile -->

<nav id="menu-xs">

  <?php foreach ($site->menu()->toStructure() as $item):

    if (!$item->visible()->toBool()) { continue; }
    $p = $item->menuPage()->toPage();
    $active = "";
    $currentlyOpen = false;
    $hasSubItems = $item->subpages()->toPages()->count() > 0;
    if ($page->is($p) || $page->parents()->has($p)) {
      $active = " active";
      $currentlyOpen = true;
    }
    ?>

    <?php if ($hasSubItems): ?>
      
      <div class="group<?= $currentlyOpen ? " open" : "" ?>" 
           data-uid="<?= $p->uid() ?>"
           style="--group-sub-height: <?= $item->subpages()->toPages()->count() * 40 + 40 ?>px;"
      >

        <div class="main-row bordered">
          <a class="main<?= $active ?>" href="<?= $p->url() ?>"><?= $p->title() ?></a>
          <a class="arrow" onclick="a.xsMenuToggle('<?= $p->uid() ?>');"></a>
        </div>

        <?php foreach ($item->subpages()->toPages() as $sp):
          $subActive = "";
          if ($page->is($sp) || $page->parents()->has($sp)) {
            $subActive = "active";
          }
          ?>
          <a class="sub <?= $subActive ?>" href="<?= $sp->url() ?>"><?= $sp->title() ?></a>
        <?php endforeach ?>
      </div>

    <?php else: ?>
      <a class="main bordered <?= $active ?>" href="<?= $p->url() ?>"><?= $p->title() ?></a>

    <?php endif ?>






  <?php endforeach ?>



</nav>


