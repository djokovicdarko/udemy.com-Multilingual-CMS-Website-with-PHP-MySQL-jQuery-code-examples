<?php
$this->addScript('/admin/js/ckeditor/ckeditor.js');
$this->addScript('/admin/js/ckeditor/adapters/jquery.js');

$objPage = new Page($this->objLanguage);
$objForm = new Form($this->objUrl);
$objValidation = new Validation($this->objLanguage);

$expected = array(
	'name', 'content', 'meta_title', 'meta_description',
	'meta_keywords', 'identity'
);
$required = array(
	'name', 'content', 'meta_title', 'meta_description',
	'meta_keywords', 'identity'
);

if (isset($_POST['name'])) {

	$array = $objForm->post2Array($expected, 'content', array('identity' => 'sanitise'));
	
	if (
		array_key_exists('identity', $array) &&
		!empty($array['identity']) &&
		$objPage->duplicate($array['identity'])
	) {
		$objValidation->add2Errors('identity', 'identity_taken');
	}
	
	if ($objValidation->isValid($array, $required)) {
		
		if ($objPage->add($array)) {
			Helper::redirect($this->objUrl->getCurrent(array('a', 'id')).'/a/index');					
		}
		
	}

}

require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[9]; ?></h1>

<form method="post">
	<table class="tbl_insert">
		<tr>
			<th>
				<label for="name"><?php echo $this->objLanguage->labels[19]; ?>: *</label>
				<?php echo $objValidation->getMessage('name'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="name" id="name" class="field field_long"
					value="<?php echo $objForm->stickyText('name'); ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="content"><?php echo $this->objLanguage->labels[22]; ?>: *</label>
				<?php echo $objValidation->getMessage('content'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<textarea name="content" id="content" cols="" rows=""
					class="ckEditor"><?php echo $objForm->stickyText('content'); ?></textarea>
			</td>
		</tr>
		<tr>
			<th>
				<label for="meta_title"><?php echo $this->objLanguage->labels[23]; ?>: *</label>
				<?php echo $objValidation->getMessage('meta_title'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="meta_title" id="meta_title" class="field field_long"
					value="<?php echo $objForm->stickyText('meta_title'); ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="meta_description">
					<?php echo $this->objLanguage->labels[24]; ?>: *
				</label>
				<?php echo $objValidation->getMessage('meta_description'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<textarea name="meta_description" id="meta_description" 
					cols="" rows=""	class="field area"><?php echo $objForm->stickyText('meta_description'); ?></textarea>
			</td>
		</tr>
		<tr>
			<th>
				<label for="meta_keywords">
					<?php echo $this->objLanguage->labels[25]; ?>: *				</label>
				<?php echo $objValidation->getMessage('meta_keywords'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<textarea name="meta_keywords" id="meta_keywords" 
					cols="" rows=""	class="field area"><?php echo $objForm->stickyText('meta_keywords'); ?></textarea>
			</td>
		</tr>
		<tr>
			<th>
				<label for="identity"><?php echo $this->objLanguage->labels[26]; ?>: *</label>
				<?php echo $objValidation->getMessage('identity'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="identity" id="identity" class="field field_long"
					value="<?php echo $objForm->stickyText('identity'); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="button button-orange"
					value="<?php echo $this->objLanguage->labels[9]; ?>" />
			</td>
		</tr>
	</table>
</form>

<?php require_once('footer.php'); ?>