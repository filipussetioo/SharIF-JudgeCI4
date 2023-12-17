<!-- {#
 # SharIF Judge
 # file: side_bar.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->renderSection('side_bar') ?>
<div id="side_bar" class="sidebar_open">
	<ul>
		<li class="color-dashboard <?= ($selected == 'dashboard') ? ' selected' : '' ?>">
			<a href="<?= site_url('dashboard') ?>" aria-labelledby="dashboard-label">
				<i class="fa fa-dashboard fa-lg"></i>
				<span class="sidebar_text" id="dashboard-label">Dashboard</span>
			</a>
		</li>
		<?php if ($user->level == 3): ?>
		<li class="color-settings <?= ($selected=='settings') ? ' selected' : '' ?>">
			<a href="<?= site_url('settings') ?>" aria-labelledby="settings-label">
				<i class="fa fa-gear fa-lg"></i>
				<span class="sidebar_text" id="settings-label">Settings</span>
			</a>
		</li>
		<li class="color-users<?= ($selected=='users') ? ' selected' :'' ?>">
			<a href="<?= site_url('users') ?>" aria-labelledby="users-label">
				<i class="fa fa-users fa-lg"></i>
				<span class="sidebar_text" id="users-label">Users</span>
			</a>
		</li>
		<?php endif ?>
		<li class="color-notifications<?= ($selected=='notifications') ? ' selected' :'' ?>">
			<a href="<?= site_url('notifications') ?>" aria-labelledby="notifications-label">
				<i class="fa fa-bell fa-lg"></i>
				<span class="sidebar_text" id="notifications-label">Notifications</span>
			</a>
		</li>
		<li class="color-assignments<?= ($selected=='assignments') ? ' selected' : '' ?>">
			<a href="<?= site_url('assignments') ?>" aria-labelledby="assignments-label">
				<i class="fa fa-folder-open fa-lg"></i>
				<span class="sidebar_text" id="assignments-label">Assignments</span>
			</a>
		</li>
		<li class="color-problems<?= ($selected=='problems') ? ' selected' : '' ?>">
			<a href="<?= site_url('problems') ?>" aria-labelledby="problems-label">
				<i class="fa fa-puzzle-piece fa-lg"></i>
				<span class="sidebar_text" id="problems-label">Problems</span>
			</a>
		</li>
		<li class="color-submit<?= ($selected=='submit') ? ' selected' : '' ?>">
			<a href="<?= site_url('submit') ?>" aria-labelledby="submit-label">
				<i class="fa fa-location-arrow fa-lg"></i>
				<span class="sidebar_text" id="submit-label">Submit</span>
			</a>
		</li>
		<li class="color-final_submissions<?= ($selected=='final_submissions') ? ' selected' : ''?>">
			<a href="<?= site_url('submissions/final') ?>" aria-labelledby="final-submission-label">
				<i class="fa fa-map-marker fa-lg"></i>
				<span class="sidebar_text" id="final-submission-label">Final Submissions</span>
			</a>
		</li>
		<li class="color-all_submissions<?= ($selected=='all_submissions') ? ' selected' : '' ?>">
			<a href="<?= site_url('submissions/all') ?>" aria-labelledby="all-submission-label">
				<i class="fa fa-bars fa-lg"></i>
				<span class="sidebar_text" id="all-submission-label">All Submissions</span>
			</a>
		</li>
		<li class="color-scoreboard<?= ($selected=='scoreboard') ? ' selected' : '' ?>">
			<a href="<?= site_url('scoreboard') ?>" aria-labelledby="scoreboard-label">
				<i class="fa fa-star fa-lg"></i>
				<span class="sidebar_text" id="scoreboard-label">Scoreboard</span>
			</a>
		</li>
    <li class="color-halloffame<?= ($selected=='halloffame') ? ' selected' : '' ?>">
			<a href="<?= site_url('halloffame') ?>" aria-labelledby="hall-of-fame-label">
				<i class="fa fa-list-alt fa-lg"></i>
				<span class="sidebar_text" id="hall-of-fame-label">Hall of Fame</span>
			</a>
		</li>
    <?php if ($user->level == 3): ?>
    <li class="color-logs<?= ($selected=='logs') ? ' selected' : '' ?>">
			<a href="<?= site_url('logs') ?>" aria-labelledby="24-hour-log-label">
				<i class="fa fa-book fa-lg"></i>
				<span class="sidebar_text" id="24-hour-log-label">24-hour Log</span>
			</a>
		</li>
    <?php endif ?>
	</ul>
	<div id="sidebar_bottom">
		<p>
			<a href="https://github.com/ifunpar/Sharif-Judge" target="_blank">&copy; SharIF Judge <?= SHJ_VERSION ?></a>
			<a href="https://github.com/ifunpar/Sharif-Judge/tree/docs" target="_blank">Docs</a>
		</p>
		<p class="timer"></p>
		<div id="shj_collapse" class="pointer">
			<i id="collapse" class="fa fa-caret-square-o-left fa-lg"></i><span class="sidebar_text">Collapse Menu</span>
		</div>
	</div>
</div>
