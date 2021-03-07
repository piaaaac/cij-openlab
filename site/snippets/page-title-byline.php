<?php 
$bylineWithPic = bylineWithPic($page);
?>

<section class="bg-white my-space-2">
  <div class="text-width kt">
    <h1 class="font-xxl huge-title upper color-red"><?= $page->title() ?></h1>
    <?php if ($bylineWithPic !== ""): ?>
    	<div class="font-m width-1 mt-space-2"><?= $bylineWithPic ?></div>
    <?php endif ?>
  </div>
</section>
