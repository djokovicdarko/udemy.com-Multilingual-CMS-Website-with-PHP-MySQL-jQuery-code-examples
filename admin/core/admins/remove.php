<?php
if ($this->admin['access'] != 1) {
	Helper::redirect('/panel/content/c/pages/a/index');
}

$did = $this->objUrl->get('did');

if (!empty($did)) {

	$this->objAdmin->remove($did);
	Helper::redirect($this->objUrl->getCurrent(array('a', 'id', 'did')).'/a/index');

} else {

	$id = $this->objUrl->get('id');
	if (!empty($id)) {
	
		$admin = $this->objAdmin->getOne($id);
		
		if (!empty($admin)) {
		
			require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[88]; ?> : <?php echo $admin['full_name']; ?></h1>

<p>
	
	<?php echo $this->objLanguage->labels[40]; ?><br />
	<a href="<?php echo $this->objUrl->getCurrent('id').'/did/'.$id; ?>">
		<?php echo $this->objLanguage->labels[41]; ?>
	</a> | 
	<a href="<?php echo $this->objUrl->getCurrent(array('a', 'id')).'/a/index'; ?>">
		<?php echo $this->objLanguage->labels[42]; ?>
	</a>
</p>

<?php require_once('footer.php'); } } } ?>









