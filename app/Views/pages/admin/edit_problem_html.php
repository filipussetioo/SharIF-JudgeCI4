<!-- {#
 # SharIF Judge
 # file: edit_problem_html.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->extend('templates/base') ?>
<?= $this->section('icon') ?>fa-edit<?= $this->endSection()?>
<?= $this->section('title') ?>Edit Problem Description<?= $this->endSection() ?>
<?= $this->section('head_title') ?>Edit Problem Description<?= $this->endSection() ?>



<?= $this->section('other_assets') ?>
<script type='text/javascript' src="<?=  base_url('assets/tinymce/tinymce.min.js') ?>"></script>
<script>
$(document).ready(function(){
	tinymce.init({
		selector: 'textarea',
		toolbar_items_size: 'small',
		relative_urls: false,
		width: 700,
		height: 300,
		resize: false,
		plugins: 'directionality emoticons textcolor link code',
		toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl',
		toolbar2: 'forecolor backcolor | emoticons | link unlink anchor image media code | removeformat'
	});
});
</script>
<?= $this->endSection() ?>



<?= $this->section('main_content') ?>
<p>
	Assignment <?= $description_assignment['id'] ?> (<span dir="auto"><?= $description_assignment['name'] ?></span>)<br>
	Problem <?= $problem['id'] ?>
</p>
<p>
	<i class="fa fa-warning color3"></i>
	When you edit as html, the markdown code will be removed.
</p>
<?= form_open("problems/edit/html/".$description_assignment['id'].'/'.$problem['id']) ?>
<p class="input_p">
	<textarea name="text"><?= $problem['description'] ?></textarea>
</p>
<p class="input_p">
	<input type="submit" value="Save" class="sharif_input"/>
</p>
</form>
<?= $this->endSection() ?>