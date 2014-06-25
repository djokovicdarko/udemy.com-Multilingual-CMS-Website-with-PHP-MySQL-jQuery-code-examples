<?php
$did = $this->objUrl->get('did');
$objPage = new Page($this->objLanguage);

if (!empty($did)) {

	$objPage->remove($did);
	Helper::redirect($this->objUrl->getCurrent(array('a','id','did')).'/a/index');
	
} else {

	$id = $this->objUrl->get('id');
	
	if (!empty($id)) {
	
		$page = $objPage->getOne($id);
		
		if (!empty($page) && !in_array($id, $objPage->not_removable)) {

			require_once('header.php');
	
?>

<h1><?php echo $this->objLanguage->labels[21]; ?> : <?php echo $page['name']; ?></h1>

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










