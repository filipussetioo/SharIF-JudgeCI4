<!-- {#
 # SharIF Judge
 # file: lost.twig
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->

<?= $this->include('templates/simple_header') ?>

<?= form_open('login/lost') ?>
	<div class="box login">

		<div class="judge_logo">
			<a href="<?= site_url() ?>"><img src="<?= base_url('assets/images/banner.png') ?>"/></a>
		</div>

		<div class="login_form">
			<div class="login1">
				<p>
					<label for="form_email">Email</label><br/>
					<input id="form_email" type="email" name="email" class="sharif_input" value="<?= set_value('email') ?>"/>
					<div class="shj_error"><?= isset($errors['email']) ?> </div>
				</p>
				<?php if($sent): ?>
					<div class="shj_ok">We sent you an email containing a link to reset your password.</div>
				<?php endif ?>
			</div>
			<div class="login2">
				<p style="margin:0;">
					<a href="<?= site_url('login') ?>">Login</a>
					<input type="submit" value="Reset Password" id="sharif_submit"/>
				</p>
			</div>
		</div>

	</div>
</form>
</body>
</html>