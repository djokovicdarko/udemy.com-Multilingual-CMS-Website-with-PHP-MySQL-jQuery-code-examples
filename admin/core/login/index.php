<?php
$message = null;

if (isset($_POST['email'])) {
	
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	
	if ($this->objAdmin->isAdmin($email, $password)) {
		Login::loginAdmin($this->objAdmin->user['id']);
		Helper::redirect('/panel/content/c/pages/a/index');
	} else {
		$message = '<p class="warning">'.$this->objLanguage->labels[16].'</p>';
	}
	
}

require_once('header.php');
?>
<h1><?php echo $this->objLanguage->labels[6]; ?></h1>

<?php echo $message; ?>

<form method="post">
	<table class="tbl_insert">
		<tr>
			<th>
				<label for="email"><?php echo $this->objLanguage->labels[15]; ?></label>
			</th>
			<td>
				<input type="email" name="email" id="email" class="field" value="" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="password"><?php echo $this->objLanguage->labels[14]; ?></label>
			</th>
			<td>
				<input type="password" name="password" id="password" class="field" value="" />
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="submit" class="button button-orange" 
					value="<?php echo $this->objLanguage->labels[6]; ?>"
			</td>
		</tr>
	</table>
</form>

<?php require_once('footer.php'); ?>





