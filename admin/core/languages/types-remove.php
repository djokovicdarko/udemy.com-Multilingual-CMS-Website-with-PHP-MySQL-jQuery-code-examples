<?php
if ($this->admin['access'] != 1) {
	Helper::redirect('/panel/content/c/pages/a/index');
}

$did = $this->objUrl->get('did');

if (!empty($did)) {

	$type = $this->objLanguage->getType($did);
	if (!empty($type) && $type['is_assigned'] != 1) {
		$this->objLanguage->removeType($did);
	}
	Helper::redirect($this->objUrl->getCurrent(array('a', 'id', 'did')).'/a/types');

} else {

	$id = $this->objUrl->get('id');
	
	if (!empty($id)) {
		
		$type = $this->objLanguage->getType($id);
		
		if (!empty($type) && $type['is_assigned'] != 1) {
		
			require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[21]; ?> : 
<?php echo $type['content']; ?></h1>

<p>
	<?php echo $this->objLanguage->labels[40]; ?><br />
	<a href="<?php echo $this->objUrl->getCurrent('id').'/did/'.$id; ?>">
		<?php echo $this->objLanguage->labels[41]; ?>
	</a> | 
	<a href="<?php echo $this->objUrl->getCurrent(array('a', 'id')).'/a/types'; ?>">
		<?php echo $this->objLanguage->labels[42]; ?>
	</a>
</p>


<?php require_once('footer.php'); } } } ?>




