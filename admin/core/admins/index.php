<?php
if ($this->admin['access'] != 1) {
	Helper::redirect('/panel/content/c/pages/a/index');
}

$objForm = new Form($this->objUrl);
$objForm->post2Url('srch');
$search = $this->objUrl->get('srch');
$search = urldecode(stripslashes($search));

if (!empty($search)) {
	$admins = $this->objAdmin->getAll(array(
		'first_name' => $search,
		'last_name' => $search
	));
} else {
	$admins = $this->objAdmin->getAll();
}

$objPaging = new Paging($this->objUrl, $this->objLanguage, $admins, 10);
$admins = $objPaging->getRecords();
$paging = $objPaging->getPaging();

require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[85]; ?></h1>

<form method="post" id="search">
	<table class="tbl_repeat">
		<tr>
			<th>
				<input type="text" name="srch" id="srch"
					class="table-field fll mrr4"
					value="<?php echo $search; ?>" />
				<input type="submit" class="button button-orange"
					value="<?php echo $this->objLanguage->labels[59]; ?>" />
			</th>
		</tr>
	</table>
</form>

<table class="tbl_repeat">
	<thead>
		<tr class="sub-heading">
			<th class="colone">
				<?php echo $this->objLanguage->labels[17]; ?>
			</th>
			<th><?php echo $this->objLanguage->labels[19]; ?></th>
			<th class="ta_r colone">
				<?php echo $this->objLanguage->labels[89]; ?>
			</th>
			<th class="ta_r colone">
				<?php echo $this->objLanguage->labels[18]; ?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($admins)) { ?>
		
			<?php foreach($admins as $row) { ?>
				
				<tr>
					<td>
						<a href="<?php echo $this->objUrl->getCurrent(array('a')).'/a/edit/id/'.$row['id']; ?>">
							<?php echo $this->objLanguage->labels[17]; ?>
						</a>
					</td>
					<td>
						<?php echo $row['full_name']; ?>
					</td>
					<td class="ta_r nw"><?php echo $row['label']; ?></td>
					<td>
						<a href="<?php echo $this->objUrl->getCurrent(array('a')).'/a/remove/id/'.$row['id']; ?>">
							<?php echo $this->objLanguage->labels[18]; ?>
						</a>
					</td>
				</tr>
				
			<?php } ?>
		
		<?php } else { ?>
			
			<?php if (!empty($search)) { ?>
				
				<tr>
					<td colspan="4">
						<?php echo $this->objLanguage->labels[63]; ?>
					</td>
				</tr>
				
			<?php } else { ?>
				
				<tr>
					<td colspan="4">
						<?php echo $this->objLanguage->labels[64]; ?>
					</td>
				</tr>
				
			<?php } ?>
			
		<?php } ?>
	</tbody>
</table>

<?php echo $paging; ?>

<?php require_once('footer.php'); ?>






