<!-- {#
 # SharIF Judge
 # file: register_success.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->section('title') ?>Register<?= $this->endSection() ?>
<?= $this->include('templates/simple_header') ?>

<div class="box success">
	<div class="judge_logo">
		<a href="<?= site_url() ?>"><img src="<?= base_url('assets/images/banner.png') ?>"/></a>
	</div>
	<div class="login_form">
		<div class="login1">
			<p style="width:100%;">
				Registered successfully!
			</p>
		</div>
		<div class="login2">
			<p style="margin:0;">
				<a href="<?= site_url('login') ?>">Login</a>
			</p>
		</div>
	</div>
</div>
</body>
</html>