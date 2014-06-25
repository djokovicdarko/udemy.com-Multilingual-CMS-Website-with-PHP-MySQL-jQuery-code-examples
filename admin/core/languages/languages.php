<?php
if ($this->admin['access'] != 1) {
	Helper::redirect('/panel/content/c/pages/a/index');
}

$objForm = new Form($this->objUrl);
$objForm->post2Url('srch');
$search = $this->objUrl->get('srch');
$search = urldecode(stripslashes($search));

$call = $this->objUrl->get('call');

if (!empty($call)) {
	
	switch($call) {
	
		case 'update':
		
		$message  = '<div class="confirmation confirmation-warning">';
		$message .= $this->objLanguage->labels[67];
		$message .= '</div>';
		
		if (!empty($_POST['values'])) {
			$out = array();
			foreach($_POST['values'] as $key => $value) {
				$key = explode('_', $value['name']);
				if ($key[0] == 'content') {
					$out[$key[1]] = $value['value'];
				}
			}
			if ($this->objLanguage->updateLanguages($out)) {
				$message  = '<div class="confirmation">';
				$message .= $this->objLanguage->labels[68];
				$message .= '</div>';
			}
		}
		
		echo json_encode(array('message' => $message));
		
		break;
		
		case 'add':
		
		$message  = '<div class="confirmation confirmation-warning">';
		$message .= $this->objLanguage->labels[67];
		$message .= '</div>';
		
		if (!empty($_POST['content'])) {
			if ($this->objLanguage->addLanguage($_POST['content'])) {
				$message  = '<div class="confirmation">';
				$message .= $this->objLanguage->labels[66];
				$message .= '</div>';
			}
		}
		
		echo json_encode(array('message' => $message));
		
		break;
		
		case 'remove':
		
		$id = $this->objUrl->get('id');
		
		if (!empty($id) && $this->objLanguage->removeLanguage($id)) {
			
			if (!empty($search)) {
				$message = $this->objLanguage->labels[63];
				$labels = $this->objLanguage->getAll(array(
					'content' => $search,
					'label' => $search
				));
			} else {
				$message = $this->objLanguage->labels[64];
				$labels = $this->objLanguage->getAll();
			}
			
			if (empty($labels)) {
				echo json_encode(array(
					'error' => false,
					'message' => '<tr><td colspan="4">'.$message.'</td></tr>'
				));
			} else {
				echo json_encode(array('error' => false));
			}
			
		} else {
			echo json_encode(array('error' => true));
		}
		
		break;
	
	}
	
} else {
	
	if (!empty($search)) {
		$languages = $this->objLanguage->getAll(array(
			'label' => $search,
			'language_id' => $search
		));
	} else {
		$languages = $this->objLanguage->getAll();
	}
	
	$objPaging = new Paging($this->objUrl, $this->objLanguage, $languages, 10);
	$languages = $objPaging->getRecords();
	$paging = $objPaging->getPaging();
	
	require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[62]; ?></h1>

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

<form method="post" class="form-add">
	<table class="tbl_repeat">
		<tr>
			<th>
				<input type="text" name="content" 
					class="table-field fll mrr4"
					value="" />
				<input type="submit" class="button button-orange"
					value="<?php echo $this->objLanguage->labels[45]; ?>" />
			</th>
		</tr>
	</table>
</form>

<form method="post" class="form-update">
	<table class="tbl_repeat">
		<thead>
			<tr class="sub-heading">
				<th class="colone nw">#</th>
				<th><?php echo $this->objLanguage->labels[46]; ?></th>
				<th class="colone ta_r">
					<?php echo $this->objLanguage->labels[18]; ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($languages)) { ?>
				
				<?php foreach($languages as $row) { ?>
					
					<tr>
						<td class="nw">
							<?php echo $row['name']; ?> (<?php echo $row['id']; ?>)
						</td>
						<td>
							<input type="text" 
								name="content_<?php echo $row['id']; ?>"
								id="content_<?php echo $row['id']; ?>"
								value="<?php echo $row['label']; ?>"
								class="field fll mrr4" />
						</td>
						<td class="ta_r">
							<a href="#" rel="<?php echo $this->objUrl->getCurrent().'/call/remove/id/'.$row['id']; ?>" class="remove">
								<?php echo $this->objLanguage->labels[18]; ?>
							</a>
						</td>
					</tr>
					
				<?php } ?>
				
			<?php } else { ?>
				
				<?php if (!empty($search)) { ?>
					
					<tr>
						<td colspan="3">
							<?php echo $this->objLanguage->labels[63]; ?>
						</td>
					</tr>
					
				<?php } else { ?>
					
					<tr>
						<td colspan="3">
							<?php echo $this->objLanguage->labels[64]; ?>
						</td>
					</tr>
					
				<?php } ?>
				
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">
					<input type="submit" class="button button-orange flr"
						value="<?php echo $this->objLanguage->labels[27]; ?>" />
				</th>
			</tr>
		</tfoot>
	</table>
	
	<?php echo $paging; ?>
	
	<div class="dn" id="update_url">/panel/languages/c/languages/a/languages/call/update</div>
	<div class="dn" id="add_url">/panel/languages/c/languages/a/languages/call/add</div>
	
</form>


<?php require_once('footer.php'); } ?>






