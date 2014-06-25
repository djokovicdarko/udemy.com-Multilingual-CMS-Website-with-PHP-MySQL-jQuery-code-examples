<?php
if ($this->admin['access'] != 1) {
	Helper::redirect('/panel/content/c/pages/a/index');
}
	
$objForm = new Form($this->objUrl);
$objValidation = new Validation($this->objLanguage);

$expected = array(
	'access', 'first_name', 'last_name', 'email', 'password'
);
$required = array(
	'access', 'first_name', 'last_name', 'email', 'password'
);

if (isset($_POST['access'])) {
	
	$array = $objForm->post2Array($expected);
	
	if (
		array_key_exists('email', $array) &&
		!empty($array['email']) &&
		$this->objAdmin->duplicate($array['email'])
	) {
		$objValidation->add2Errors('email', 'email_taken');
	}
	
	if ($objValidation->isValid($array, $required)) {
		
		$array['salt'] = mt_rand();
		$array['password'] = $this->objAdmin->makePassword(
			$array['password'], $array['salt']
		);
		
		if ($this->objAdmin->add($array)) {
			Helper::redirect($this->objUrl->getCurrent(array('a', 'id')).'/a/index');
		}
	}
	
}

$access = $this->objAdmin->getAccess();

require_once('header.php');		
?>

<h1><?php echo $this->objLanguage->labels[86]; ?></h1>

<form method="post">
	<table class="tbl_insert">
		<tr>
			<th>
				<label for="access">
					<?php echo $this->objLanguage->labels[89]; ?>: *
				</label>
				<?php echo $objValidation->getMessage('access'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<select name="access" id="access" class="field">
					<?php if (!empty($access)) { ?>
						<option value="">
							<?php echo $this->objLanguage->labels[98]; ?>
						</option>
						<?php foreach($access as $row) { ?>
							<option value="<?php echo $row['id']; ?>"
							<?php echo $objForm->stickySelect('access', $row['id']); ?>>
								<?php echo $row['label']; ?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label for="first_name">
					<?php echo $this->objLanguage->labels[91]; ?>: *
				</label>
				<?php echo $objValidation->getMessage('first_name'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="first_name" id="first_name"
					class="field"
					value="<?php echo $objForm->stickyText('first_name'); ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="last_name">
					<?php echo $this->objLanguage->labels[93]; ?>: *
				</label>
				<?php echo $objValidation->getMessage('last_name'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="last_name" id="last_name"
					class="field"
					value="<?php echo $objForm->stickyText('last_name'); ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="email">
					<?php echo $this->objLanguage->labels[2]; ?>: *
				</label>
				<?php echo $objValidation->getMessage('email'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="email" id="email"
					class="field"
					value="<?php echo $objForm->stickyText('email'); ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="password">
					<?php echo $this->objLanguage->labels[14]; ?>: *
				</label>
				<?php echo $objValidation->getMessage('password'); ?>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="password" id="password"
					class="field"
					value="<?php echo $objForm->stickyText('password'); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="button button-orange"
					value="<?php echo $this->objLanguage->labels[45]; ?>" />
			</td>
		</tr>
	</table>
</form>

<?php require_once('footer.php'); ?>






