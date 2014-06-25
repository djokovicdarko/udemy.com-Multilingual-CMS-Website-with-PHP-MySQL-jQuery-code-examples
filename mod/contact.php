<?php
$objPage = new Page($this->objLanguage);
$page = $objPage->getOne(3);
$this->parsePage($page);

require_once('header.php');
echo $this->content;
?>

<p class="orange dn" id="unsuccessful"><?php echo $this->objLanguage->labels[38]; ?></p>

<p class="yellow dn" id="successful"><?php echo $this->objLanguage->labels[39]; ?></p>

<form method="post" id="contact-form">
	<table class="tbl_insert">
		<tr>
			<th class="full_name">
				<label for="full_name">
					<?php echo $this->objLanguage->labels[1]; ?>: *
				</label>
			</th>
		</tr>
		<tr>
			<td>
				<input type="text" name="full_name" id="full_name"
					value="" class="field" />
			</td>
		</tr>
		<tr>
			<th class="email">
				<label for="email">
					<?php echo $this->objLanguage->labels[2]; ?>: *
				</label>
			</th>
		</tr>
		<tr>
			<td>
				<input type="email" name="email" id="email"
					value="" class="field" />
			</td>
		</tr>
		<tr>
			<th class="enquiry">
				<label for="enquiry">
					<?php echo $this->objLanguage->labels[4]; ?>: *
				</label>
			</th>
		</tr>
		<tr>
			<td>
				<textarea name="enquiry" id="enquiry" cols="" rows="" class="field area"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<a href="#" class="button button-orange submit">
					<?php echo $this->objLanguage->labels[5]; ?>
				</a>
			</td>
		</tr>
	</table>
</form>















<?php require_once('footer.php'); ?>