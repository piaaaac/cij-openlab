<?php

/**
 * @param $entry - Kirby page
 *
 */

$template = $entry->template() == "item" ? "item" : "entity";

?>

<div class="container-fluid">
	<div class="row row-detail">
		<div class="col-sm-6 py-3 d-flex flex-column justify-content-between">
			<div class="title">
				<p><?= $entry->title() ?></p>
				<p class="color-grey"><?= $entry->smartByline() ?></p>
				<?php if ($entry->year()->isNotEmpty()): ?>
					<p class="color-grey"><?= $entry->year()->value() ?></p>
				<?php endif ?>
			</div>
			<div class="buttons">
				<?php if ($entry->links()->isNotEmpty()): ?>
					<?php $firstLink = $entry->links()->toStructure()->first() ?>
					<a class="button external upper" href="<?= $firstLink->linkUrl()->value() ?>" target="_blank">
						<?= $firstLink->linkText()->value() ?>
					</a>
				<?php endif ?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="image <?= $template ?>" style="background-image: url(<?= $entry->img()->toFile()->url() ?>);"></div>
		</div>
	</div>

	<?php if ($entry->description()->isNotEmpty()): ?>

		<div class="row row-detail">
			<div class="col-sm-6 py-4">
				<div class="description"><?= $entry->description()->kt() ?></div>
			</div>
		</div>

	<?php endif ?>

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
			<div class="col-sm-3 py-4">
				<div class="related-author">
					<header class="font-xs upper">Author</header>
					<div class="list">
						<?php foreach ($entry->author()->toPages() as $e): ?>
							<a onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<?php endif ?>
			<?php if ($entry->commission()->isNotEmpty()): ?>
			<div class="col-sm-3 py-4">
				<div class="related-commission">
					<header class="font-xs upper">Commissioned by</header>
					<div class="list">
						<?php foreach ($entry->commission()->toPages() as $e): ?>
							<a onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<?php endif ?>
			<?php if ($entry->funder()->isNotEmpty()): ?>
			<div class="col-sm-3 py-4">
				<div class="related-funder">
					<header class="font-xs upper">Funded by</header>
					<div class="list">
						<?php foreach ($entry->funder()->toPages() as $e): ?>
							<a onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<?php endif ?>
			<?php if ($entry->platform()->isNotEmpty()): ?>
			<div class="col-sm-3 py-4">
				<div class="related-platform">
					<header class="font-xs upper">Platform</header>
					<div class="list">
						<?php foreach ($entry->platform()->toPages() as $e): ?>
							<a onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
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
			<div class="row row-detail">
	
				<?php if ($relatedItems->count() > 0): ?>
					<?php 
					$byType = [];
					foreach ($relatedItems as $e){
						$type = $e->entryType()->value();
						if (!array_key_exists($type, $byType)) {
							$byType[$type] = [];
						}
						$byType[$type][] = $e;
					}
					?>
					<?php foreach ($byType as $type => $entries): ?>
						<div class="col-sm-3 py-4">
							<div class="">
								<header class="font-xs upper"><?= $type ?>s</header>
								<div class="list">
									<?php foreach ($entries as $e): ?>
										<a onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
									<?php endforeach ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				<?php endif ?>
			
				<?php if ($relatedEntities->count() > 0): ?>
					<div class="col-sm-3 py-4">
						<div class="">
							<header class="font-xs upper">Entities</header>
							<div class="list">
								<?php foreach ($relatedEntities as $e): ?>
									<a onclick="a.openDetail('<?= $e->id() ?>');"><?= $e->title() ?></a>
								<?php endforeach ?>
							</div>
						</div>
					</div>
				<?php endif ?>

			</div>

		<?php } ?>
	<?php endif ?>

</div>