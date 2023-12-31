<!-- {#
 # SharIF Judge
 # file: dashboard.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->extend('templates/base') ?>
<?= $this->section('icon') ?>fa-dashboard<?= $this->endSection()?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('head_title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('other_assets')?>
<link rel='stylesheet' type='text/css' href='<?= base_url('assets/fullcalendar/fullcalendar.css') ?>'/>
<script type='text/javascript' src="<?= base_url('assets/fullcalendar/fullcalendar.min.js') ?>"></script>
<link rel='stylesheet' type='text/css' href='<?= base_url('assets/gridster/jquery.gridster.css') ?>'/>
<script type='text/javascript' src="<?= base_url('assets/gridster/jquery.gridster.min.js') ?>"></script>
<script type='text/javascript' src="<?= base_url('assets/js/jquery.autoellipsis-1.0.10.min.js') ?>"></script>
<script>
$(document).ready(function () {
	$('#calendar').fullCalendar({
		timeFormat: 'HH:mm { - HH:mm}',
		editable: false,
		height: 280,
		firstDay: <?= $week_start ?>,
		events: [
			<?php $colors = ['#812C8C','#FF750D','#2C578C','#013440','#A6222C','#42758C','#02A300','#BA6900']; ?>
                <?php foreach ($all_assignments as $idx => $assignment): ?>
                    <?php if ($assignment['archived_assignment'] == '0'): ?>
                        {id: <?= $assignment['id'] ?>, title: '<?= $assignment['name'] ?>', start: '<?= $assignment['start_time'] ?>', end: '<?= $assignment['finish_time'] ?>', allDay: false, color: '<?= $colors[(($idx) % count($colors))] ?>'},
                    <?php endif; ?>
            	<?php endforeach; ?>
			]
	});
	var gridster = $(".gridster ul").gridster({
		widget_margins: [10, 10],
		widget_base_dimensions: [350, 350],
		serialize_params: function ($w, wgd) {
			return {
				r: wgd.row,
				c: wgd.col,
				x: wgd.size_x,
				y: wgd.size_y
			}
		},
		draggable: {
			handle: '.widget_title',
			stop: function (event, ui) { // send widget positions to server for saving in database
				var positions = JSON.stringify(gridster.serialize());
				$.post(
					"<?= site_url('/dashboard/widget_positions') ?>",
					{
						positions: positions,
						shj_csrf_token: shj.csrf_token
					}
				);
			}
		}
	}).data('gridster');
	$('.notif_text').ellipsis();
});
</script>
<?=$this->endSection()?>

<?= $this->section('main_content')?>
<?php foreach($errors as $error){ ?>
	<p class="shj_error"><?= $error ?></p>
<?php } ?>
<div style="height: 15px;"></div>
<div class="gridster">
	<?php $i = 0; ?>
	<ul>
		<li data-row="<?= isset($wp[0]) ? $wp[0]['r'] : '1' ?>" data-col="<?= isset($wp[0]) ? $wp[0]['c'] : '1' ?>" data-sizex="<?= isset($wp[0]) ? $wp[0]['x'] : '1' ?>" data-sizey="<?= isset($wp[0]) ? $wp[0]['y'] : '1' ?>">
			<div class="shj_widget">
				<div class="widget_title"><i class="fa fa-calendar-o fa-lg color10"></i> Calendar</div>
				<div class="widget_scrollable scroll-wrapper">
					<div class="scroll-content">
						<div class="widget_contents_container" id='calendar'></div>
					</div>
				</div>
			</div>
		</li>

		<li data-row="<?= isset($wp[1]) ? $wp[1]['r'] : '1' ?>" data-col="<?= isset($wp[1]) ? $wp[1]['c'] : '2' ?>"
		    data-sizex="<?= isset($wp[1]) ? $wp[1]['x'] : '1' ?>" data-sizey="<?= isset($wp[1]) ? $wp[1]['y'] : '1' ?>">
			<div class="shj_widget">
				<div class="widget_title"><i class="fa fa-bell-o fa-lg color2"></i>
					Latest Notifications
					<?php if ($user->level >= 2): ?>
						<a title="New Notification" href="<?= site_url('notifications/add') ?>" class="pull-right">
							<i class="fa fa-plus color11"></i>
						</a>
					<?php endif ?>
				</div>
				<div class="widget_scrollable scroll-wrapper">
					<div class="scroll-content">
						<div class="widget_contents_container">
							<?php if (count($notifications) == 0): ?>
								<p style="text-align: center;">Nothing yet...</p>
							<?php endif ?>
							<?php foreach ($notifications as $notification): ?>
								<div class="notif" id="number<?= $notification['id'] ?>" data-id="<?= $notification['id'] ?>">
									<div class="notif_title" dir="auto">
										<span class="anchor ttl_n"><?= $notification['title'] ?></span>
										<span class="notif_meta" dir="ltr">
										<?= $notification['time'] ?>
											<?php if ($user->level >= 2): ?>
												<span class="anchor edt_n">Edit</span>
												<span class="anchor del_n">Delete</span>
											<?php endif ?>
										</span>
									</div>
									<div class="notif_text latest" dir="auto"><?= $notification['text'] ?></div>
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li data-row="<?= isset($wp[2]) ? $wp[2]['r'] : '2' ?>" data-col="<?= isset($wp[2]) ? $wp[2]['c'] : '1' ?>" data-sizex="<?= isset($wp[2]) ? $wp[2]['x'] : '1' ?>" data-sizey="<?= isset($wp[2]) ? $wp[2]['y'] : '1' ?>">
		</li>
	</ul>
</div>
<?= $this->endSection() ?>
