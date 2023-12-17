<!-- {#
 # SharIF Judge
 # file: users.twig
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->extend('templates/base') ?>
<?= $this->section('icon') ?>fa-user<?= $this->endSection()?>
<?= $this->section('title') ?>Users<?= $this->endSection() ?>
<?= $this->section('head_title') ?>Users<?= $this->endSection() ?>

<?= $this->section('title_menu') ?>
	<span class="title_menu_item"><a href="https://github.com/ifunpar/Sharif-Judge/blob/docs/v1.4/users.md" target="_blank"><i class="fa fa-question-circle color6"></i> Help</a></span>
	<span class="title_menu_item"><a href="<?= site_url('users/add') ?>"><i class="fa fa-plus color11"></i> Add Users</a></span>
	<span class="title_menu_item"><a href="<?= site_url('users/list_excel') ?>"><i class="fa fa-download color9"></i> Excel</a></span>
<?=$this->endSection()?>

<?= $this->section('main_content') ?>
<!-- <php if ($deleted_user): ?>
	<p class="shj_ok">User deleted successfully.</p>
<php endif ?>
<php if ($deleted_submissions): ?>
	<p class="shj_ok">Submissions of selected user deleted successfully.</p>
<php endif ?> -->
<div style="height:15px"></div>
<table class="sharif_table">
	<thead>
		<tr>
			<th>#</th>
			<th>User ID</th>
			<th>Username</th>
			<th>Display Name</th>
			<th>Email</th>
			<th>Role</th>
			<th>First Login</th>
			<th>Last Login</th>
			<th>Actions</th>
		</tr>
	</thead>
	<?php foreach ($users as $index => $user): ?>
		<tr data-id="<?= $user['id'] ?>">
			<td><?= $index + 1 ?></td>
			<td><?= $user['id'] ?></td>
			<td id="un"><?= $user['username'] ?></td>
			<td dir="auto"><?= $user['display_name'] ?></td>
			<td><?= $user['email'] ?></td>
			<td><?= $user['role'] ?></td>
			<td><?= $user['first_login_time'] ? $user['first_login_time'] : 'Never' ?></td>
			<td><?= $user['last_login_time'] ? $user['last_login_time'] : 'Never' ?></td>
			<td>
				<a title="Edit User <?= $user['username'] ?>" href="<?= site_url('profile/'.$user['id']) ?>"><i class="fa fa-pencil fa-lg color9"></i></a>
				<a title="Submissions User <?= $user['username'] ?>" href="<?= site_url('submissions/all/user/'.$user['username']) ?>"><i class="fa fa-bars fa-lg color12"></i></a>
				<button class="delete_user"><span title="Delete User <?= $user['username'] ?>" class="pointer"><i title="Delete User" class="fa fa-times fa-lg color2"></i></span></button>
				<button class="delete_submissions" ><span title="Delete Submissions <?= $user['username'] ?>" class="pointer"><i class="fa fa-times-circle fa-lg color1"></i></span></button>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?=$this->endSection()?>