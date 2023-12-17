<!-- {#
 # SharIF Judge
 # file: login.twig
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->include('templates/simple_header') ?>

<?= form_open() ?>
	<div class="box login">

		<div class="judge_logo">
			<a href="<?= site_url() ?>"><img src="<?= base_url('assets/images/banner.png') ?>"/></a>
		</div>

		<div class="login_form">
			<div class="login1">
				<p>
					<label for="form_username">Username</label><br/>
					<input id="form_username" type="text" name="username" required="required" pattern="[0-9a-z]{3,20}" title="The Username field must be between 3 and 20 characters in length, and contain only digits and lowercase letters" class="sharif_input" value="<?= set_value('username') ?>" autofocus="autofocus"/>
					<div class="shj_error"><?= $validationError->hasError('username') ? $validationError->getError('username'): '' ?></div>
				</p>
				<p>
					<label for="form_password">Password</label><br/>
					<input id="form_password" type="password" name="password" required="required" pattern=".{6,200}" title="The Password field must be at least 6 characters in length" class="sharif_input"/>
					<div class="shj_error"><?= $validationError->hasError('password') ? $validationError->getError('password'): ''?></div>
				</p>
				<?php if ($error): ?>
					<div class="shj_error">Incorrect username or password.</div>
				<?php endif ?>
			</div>
			<div class="login2">
				<p style="margin:0;">
					<?php if ($registration_enabled): ?>
					<a href="<?= site_url('register') ?>">Register</a> |
					<?php endif ?>
					<a href="<?= site_url('login/lost') ?>">Reset Password</a>
					<input type="submit" value="Login" id="sharif_submit"/>
				</p>
			</div>
		</div>

	</div>
<?= form_close() ?>
</body>
</html>