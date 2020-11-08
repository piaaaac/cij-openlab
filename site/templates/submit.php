<?php snippet("header") ?>

<main class="green" id="submit-page">

  <?php snippet("page-title") ?>

	<section class="bg-bg1">
	  <div class="container-fluid text-width">
	    <div class="row">
		    <div class="col-12 py-5">

		      <?php if($success): ?>
		        <div class="alert success">
		          <p class="font-l"><?= $success ?></p>
		        </div>
		      <?php else: ?>
		        <?php if (isset($alert['error'])): ?>
		          <div><?= $alert['error'] ?></div>
		        <?php endif ?>
		        <form method="post" action="<?= $page->url() ?>">
		          <div class="h0neypot">
		            <label for="website">Website <abbr title="Required">*</abbr></label>
		            <input type="website" id="website" name="website" tabindex="-1">
		          </div>
		          <div class="field txt">
			          <div class="the-field">
			            <label for="name">
			              Your name<abbr title="Required">*</abbr>
			            </label>
			            <input type="text" id="name" name="name" value="<?= $data['name'] ?? '' ?>" required>
			          </div>
		            <?= isset($alert['name']) ? '<p class="field-error my-2">' . html($alert['name']) . '</p>' : '' ?>
		          </div>
		          <div class="field txt">
			          <div class="the-field">
			            <label for="email">
			              Your email<abbr title="Required">*</abbr>
			            </label>
			            <input type="email" id="email" name="email" value="<?= $data['email'] ?? '' ?>" required>
			          </div>
		            <?= isset($alert['email']) ? '<p class="field-error my-2">' . html($alert['email']) . '</p>' : '' ?>
		          </div>
		          <div class="field txt">
			          <div class="the-field">
			            <label for="title">
			              Entry<abbr title="Required">*</abbr>
			            </label>
			            <input type="text" id="title" name="title" value="<?= $data['title'] ?? '' ?>" required>
			          </div>
              	<p class="font-xs upper my-2">Project title / name of person or organization</p>
		            <?= isset($alert['title']) ? '<p class="field-error my-2">' . html($alert['title']) . '</p>' : '' ?>
		          </div>
		          <div class="field txt">
			          <div class="the-field">
			            <label for="url">
			              Url<abbr title="Required">*</abbr>
			            </label>
			            <input type="text" id="url" name="url" value="<?= $data['url'] ?? '' ?>" required>
			          </div>
              	<p class="font-xs upper my-2">Link to the project, person or organization</p>
		            <?= isset($alert['url']) ? '<p class="field-error my-2">' . html($alert['url']) . '</p>' : '' ?>
		          </div>
		          <div class="field area">
		            <label for="text">
		              Describe the proposed entry<abbr title="Required">*</abbr>
		            </label>
		            <textarea id="text" name="text" required><?= $data['text']?? '' ?></textarea>
		            <?= isset($alert['text']) ? '<p class="field-error my-2">' . html($alert['text']) . '</p>' : '' ?>
		          </div>
		          <input type="submit" id="submit" name="submit" value="Submit">
		        </form>
		      <?php endif ?>

		    </div>
	    </div>
	  </div>
  </section>

  <div class="my-5 py-5">

</main>

<?php snippet("overlay") ?>

<?php snippet('footer-js') ?>

<?php snippet("footer") ?>

