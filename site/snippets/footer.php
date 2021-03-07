		<?php if (!isset($hideFooter) || !$hideFooter): ?>

			<div class="footer">
				<div class="top">
					<div class="d-flex align-items-center">
				    <a class="d-inline-flex" href="<?= $site->url() ?>"><img class="home-link logo" src="<?= kirby()->url("assets") ?>/images/logo.svg" /></a>
				    <a class="color-white upper ml-0" href="<?= $site->url() ?>">Open&nbsp;Lab</a>
					</div>
					<!-- <a class="color-white" href="https://tcij.org">The Centre for Invesitgative Journalism</a> -->
				</div>
				<div class="bottom">
					<div class="left">
						<span>All content under CC License</span>
					</div>
					<div class="right">
						<span><a href="https://tcij.org">tcij.org</a></span>
						<span><a href="https://tcij.org/about/legal/">Privacy</a></span>
						<span>Site by <a href="https://alexpiacentini.com" target="_blank">Alex Piacentini</a></span>
					</div>
				</div>
			</div>
		
		<?php endif ?>

    <script type="text/javascript"></script>
  </body>
</html>