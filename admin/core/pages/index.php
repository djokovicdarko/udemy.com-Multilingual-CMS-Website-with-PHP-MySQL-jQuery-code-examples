<?php
$objForm = new Form($this->objUrl);
$objForm->post2Url('srch');
$search = $this->objUrl->get('srch');
$search = urldecode(stripslashes($search));

$objPage = new Page($this->objLanguage);

if (!empty($search)) {
	$pages = $objPage->getAll(array(
		'name' => $search,
		'content' => $search,
		'meta_title' => $search,
		'meta_description' => $search,
		'meta_keywords' => $search
	));
} else {
	$pages = $objPage->getAll();
}

$objPaging = new Paging($this->objUrl, $this->objLanguage, $pages, 10);
$pages = $objPaging->getRecords();
$paging = $objPaging->getPaging();

require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[7]; ?></h1>

<form method="post" id="search">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
		<tr>
			<th>
				<input type="text" name="srch" id="srch" class="table-field fll mrr4" value="<?php echo $search; ?>">
				<input type="submit" class="button button-orange"
					value="<?php echo $this->objLanguage->labels[59]; ?>" />
			</th>
		</tr>
	</table>
</form>

<table class="tbl_repeat">
	<thead>
		<tr class="sub-heading">
			<th class="colone"><?php echo $this->objLanguage->labels[17]; ?></th>
			<th><?php echo $this->objLanguage->labels[19]; ?></th>
			<th class="ta_r colone"><?php echo $this->objLanguage->labels[18]; ?></th>
		</tr>		
	</thead>
	<tbody>
		<?php if (!empty($pages)) { ?>
			<?php foreach($pages as $row) { ?>
				<tr>
					<td>
						<a href="<?php echo $this->objUrl->getCurrent(array('a')).'/a/edit/id/'.$row['id']; ?>">
							<?php echo $this->objLanguage->labels[17]; ?>
						</a>
					</td>
					<td><?php echo $row['name']; ?></td>
					<td class="ta_r">
						<?php if (!in_array($row['id'], $objPage->not_removable)) { ?>
						<a href="<?php echo $this->objUrl->getCurrent(array('a')).'/a/remove/id/'.$row['id']; ?>">
							<?php echo $this->objLanguage->labels[18]; ?>
						<?php } else { ?>
							--
						<?php } ?>						
						</a>
					</td>
				</tr>
			<?php } ?>
		<?php } else { ?>
		
			<?php if (!empty($search)) { ?>
				
				<tr>
					<td colspan="3"><?php echo $this->objLanguage->labels[63]; ?></td>
				</tr>
				
			<?php } else { ?>
			
				<tr>
					<td colspan="3"><?php echo $this->objLanguage->labels[64]; ?></td>
				</tr>
			
			<?php } ?>
		
		<?php } ?>
	</tbody>
</table>

<?php echo $paging; ?>

<?php require_once('footer.php'); ?>











