{#
 # SharIF Judge
 # file: dashboard.twig
 # author: Mohammad Javad Naderi <mjnaderi@gmail.com>
 #}
<!DOCTYPE html>
<html lang="en">
<?= $this->include('templates/base') ?>
{% block icon %}fa-dashboard{% endblock %}

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
		firstDay: <?= $data['week_start'] ?>,
		events: [
			<?php foreach ($data['all_assignments'] as $assignments){ ?>
        <?php if($assignment->archived_assignment == '0'): ?>
  				{id:<?= $assignment.id ?>,title:'<?= $assignment.name|e('js') ?>', start:'<?= $assignment.start_time ?>', end:' <?= $assignment.finish_time ?>',
  				allDay:false,color:'<?= $colors[(loop.index0)%$colors|length] ?>'}
        <?php endif ?>
        <?php if ($assignment->archived_assignment == '1'): ?>
  				{}
        <?php endif ?>
			<?php } ?>
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
					"<?= site_url('dashboard/widget_positions') ?>",
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

<?= $this->section('main_content')?>
<?php foreach($data['errors'] as $error){ ?>
	<p class="shj_error"><?= $error ?></p>
<?php } ?>
<div style="height: 15px;"></div>
<div class="gridster">
	<?php $i = 0; ?>
	<ul>
		<li data-row="<?= $data['wp'][0] ? $data['wp'][0]['r'] : '1' ?>" data-col="<?= $data['wp'][0] ? $data['wp'][0]['c'] : '1' ?>" data-sizex="<?= $data['wp'][0] ? $data['wp'][0]['x'] : '1' ?>" data-sizey="<?= $data['wp'][0] ? $data['wp'][0]['y'] : '1' ?>">
			<div class="shj_widget">
				<div class="widget_title"><i class="fa fa-calendar-o fa-lg color10"></i> Calendar</div>
				<div class="widget_scrollable scroll-wrapper">
					<div class="scroll-content">
						<div class="widget_contents_container" id='calendar'></div>
					</div>
				</div>
			</div>
		</li>

		<li data-row="<?= wp[1] ? wp[1]['r'] : '1' ?>" data-col="<?= wp[1] ? wp[1]['c'] : '2' ?>"
		    data-sizex="<?= wp[1] ? wp[1]['x'] : '1' ?>" data-sizey="<?= wp[1] ? wp[1]['y'] : '1' ?>">
			<div class="shj_widget">
				<div class="widget_title"><i class="fa fa-bell-o fa-lg color2"></i>
					Latest Notifications
					{% if user.level >= 2 %}
						<a title="New Notification" href="<?= site_url('notifications/add') ?>" class="pull-right">
							<i class="fa fa-plus color11"></i>
						</a>
					{% endif %}
				</div>
				<div class="widget_scrollable scroll-wrapper">
					<div class="scroll-content">
						<div class="widget_contents_container">
							{% if notifications|length == 0 %}
								<p style="text-align: center;">Nothing yet...</p>
							{% endif %}
							{% for notification in notifications %}
								<div class="notif" id="number<?= notification.id ?>" data-id="<?= notification.id ?>">
									<div class="notif_title" dir="auto">
										<span class="anchor ttl_n"><?= notification.title ?></span>
										<span class="notif_meta" dir="ltr">
										<?= notification.time ?>
											{% if user.level >= 2 %}
												<span class="anchor edt_n">Edit</span>
												<span class="anchor del_n">Delete</span>
											{% endif %}
										</span>
									</div>
									<div class="notif_text latest" dir="auto"><?= notification.text ?></div>
								</div>
							{% endfor %}
						</div>
					</div>
				</div>
			</div>
		</li>

		<li data-row="<?= wp[2] ? wp[2]['r'] : '2' ?>" data-col="<?= wp[2] ? wp[2]['c'] : '1' ?>" data-sizex="<?= wp[2] ? wp[2]['x'] : '1' ?>" data-sizey="<?= wp[2] ? wp[2]['y'] : '1' ?>">
		</li>
	</ul>
</div>
<?= $this->endSection() ?>
