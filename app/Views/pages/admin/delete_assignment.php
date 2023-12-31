<!-- {#
 # SharIF Judge
 # file: delete_assignment.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->extend('templates/base') ?>
<?= $this->section('icon') ?>fa-times<?= $this->endSection()?>
<?= $this->section('title') ?>Delete Assignment<?= $this->endSection() ?>
<?= $this->section('head_title') ?>Delete Assignment<?= $this->endSection() ?>

<?= $this->section('main_content') ?>
<p>Are you sure you want to delete this assignment?</p>
<p>
	Assignment id: <?= $id ?><br>
	Assignment name: <span dir="auto"><?= $name ?></span>
</p>
<p>All test cases, submission results and submitted files will be deleted.</p>
<p>You may want to keep a backup of this assignment before deleting.</p>
<?= form_open("assignments/delete/$id") ?>
<input type="hidden" name="delete" value="delete"/>
<p class="input_p">
	<input type="submit" class="btn shj-red" value="Delete this assignment"/>
	<a href="<?= site_url('assignments') ?>" class="btn shj-blue">Do not delete</a>
</p>
</form>
<?= $this->endSection() ?>