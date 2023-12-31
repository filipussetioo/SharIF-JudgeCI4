<!-- {#
 # SharIF Judge
 # file: top_bar.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->renderSection('top_bar') ?>
<div id="top_bar" class="color-<?= $selected ?>">
	<div class="top_object shj_menu" id="user_top">
		<a href="<?= site_url('profile') ?>" id="profile_link" aria-label="Profile"><i class="fa fa-user"></i></a>
		<div class="top_menu user-menu">
			<div class="gravatar"><img src="https://www.gravatar.com/avatar/<?= md5($user->email) ?>?s=70&d=identicon" /></div>
			<div class="name"><i class="fa fa-user"></i> <?= $user->username ?></div>
			<div class="menu-controls">
				<a href="<?= site_url('/logout') ?>" class="logout-btn"><i class="fa fa-sign-out"></i> Sign Out</a>
				<a href="<?= site_url('/profile') ?>" class="profile-btn"><i class="fa fa-wrench"></i> Profile</a>
			</div>
		</div>
	</div>
	<div class="top_object countdown" id="countdown">
		<div class="time_block">
			<span id="time_days" class="countdown_num"></span><br>
			<span class="time_label" id="days_label"></span>
		</div>
		<div class="time_block">
			<span id="time_hours" class="countdown_num"></span><br>
			<span class="time_label" id="hours_label"></span>
		</div>
		<div class="time_block">
			<span id="time_minutes" class="countdown_num"></span><br>
			<span class="time_label" id="minutes_label"></span>
		</div>
		<div class="time_block">
			<span id="time_seconds" class="countdown_num"></span><br>
			<span class="time_label" id="seconds_label"></span>
		</div>
	</div>
	<div class="top_object countdown" id="extra_time">
		<i class="fa fa-plus-square fa-2x"></i>
		<div class="time_block">
			<span>Extra</span><br><span>Time</span>
		</div>
	</div>
	<div id="shj_logo" class="top_left">
		<a href="<?= site_url('/') ?>">
			<img src="<?= base_url('assets/images/logo_small.png') ?>" aria-label="Logo SharIF Judge"/>
			<h1 class="shjlogo-text">SharIF <span>Judge</span></h1>
		</a>
	</div>
	<?php  if ($user->level >= 2): ?>
	<div class="top_object shj_menu top_left" tabindex="0" id="admin_tools_top">
		Tools
		<ul class="top_menu">
			<li><a href="<?= site_url('rejudge') ?>">Rejudge</a></li>
			<li><a href="<?= site_url('queue') ?>">Submission Queue</a></li>
			<li><a href="<?= site_url('moss/'.$user->selected_assignment['id']) ?>">Cheat Detection</a></li>
		</ul>
	</div>
	<?php endif ?>
	<div class="top_object shj_menu top_left" id="select_assignment_top">
		<a href="<?= site_url('assignments') ?>"><span dir="auto" class="assignment_name"><?= strlen($user->selected_assignment['name']) > 30 ? array_slice($user->selected_assignment['name'],0,30) . '...' : $user->selected_assignment['name'] ?></span></a>
		<ul class="top_menu" id="select_assignment_menu">
			<?php $reversed_assignment = array_slice(array_reverse($all_assignments), 0, 5); ?>
			<?php foreach ($reversed_assignment as $assignment_item): ?>
				<li class="assignment_block select_assignment" tabindex="0">
					<i class="fa <?= $assignment_item['id'] == $user->selected_assignment['id'] ? 'fa-check-square-o color6' : 'fa-square-o' ?>" data-id="<?= $assignment_item['id'] ?>"></i>
					<span class="assignment_item" dir="auto"><?= $assignment_item['name'] ?></span>
				</li>
			<?php endforeach; ?>
			<li>
			<a href="<?= site_url('assignments') ?>">All Assignments</a>
			</li>
		</ul>
	</div>
	<div class="top_object top_left shj-spinner" style="display: none;">
		<i class="fa fa-refresh fa-spin fa-lg"></i>
	</div>
</div>
