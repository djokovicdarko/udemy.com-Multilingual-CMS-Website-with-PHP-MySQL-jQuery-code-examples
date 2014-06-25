<?php
$objNavigation = new Navigation($this->objLanguage);

$call = $this->objUrl->get('call');

if (!empty($call)) {
	
	switch($call) {
	
		case 'add':
		
		$message  = '<div class="confirmation confirmation-warning">';
		$message .= $this->objLanguage->labels[65];
		$message .= '</div>';
		
		if ($_POST && !empty($_POST['type']) && !empty($_POST['page'])) {
			$type = $_POST['type'];
			$page = $_POST['page'];
			if ($objNavigation->add($type, $page)) {
				$message  = '<div class="confirmation">';
				$message .= $this->objLanguage->labels[66];
				$message .= '</div>'; 
			}
		}
		
		echo json_encode(array('message' => $message));
		
		break;
		
		case 'order':
		
		$array = $_POST['rows'];
		
		if (!empty($array)) {
			
			$error = array();
			$list = explode("&", $array);
			$out = array();
			
			if (!empty($list)) {
				foreach($list as $row) {
					$element = explode("=", $row);
					if (!empty($element)) {
						$out[] = $element[1];
					}
				}
			}
			
			if (!empty($out)) {
				foreach($out as $order => $id) {
					$order = $order + 1;
					if (!$objNavigation->updateOrder($id, $order)) {
						$error[] = $id;
					}
				}
			}
			
		}
		
		break;
		
		case 'remove':
		
		$id = $this->objUrl->get('id');
		
		if (!empty($id)) {
			
			$record = $objNavigation->getOne($id);
			
			if (!empty($record) && $objNavigation->remove($id)) {
				
				$links = $objNavigation->getRecords($record['type']);
				
				if (empty($links)) {
					echo json_encode(array(
						'error' => false,
						'message' => '<tr><td colspan="2">'.$this->objLanguage->labels[64].'</td></tr>'
					));
				} else {
					echo json_encode(array(
						'error' => false
					));
				}
				
			} else {
				echo json_encode(array(
					'error' => true
				));
			}
			
		} else {
			echo json_encode(array(
				'error' => true
			));
		}
		
		break;
	
	}
	
} else {

	$this->addScript('/admin/js/jquery.tablednd_0_5.js');
	
	$navigations = $objNavigation->getAllTypes();
	
	$objPage = new Page($this->objLanguage);
	$pages = $objPage->getAll();
	
	$main = $objNavigation->getRecords(1);
	$left = $objNavigation->getRecords(2);
	$footer = $objNavigation->getRecords(3);
	

	require_once('header.php');
?>

<h1><?php echo $this->objLanguage->labels[10]; ?></h1>

<form method="post" class="form-add">
	<select name="type" id="type" class="field fll mrr4">
		<option value=""><?php echo $this->objLanguage->labels[43]; ?></option>
		<?php if (!empty($navigations)) { ?>
			<?php foreach($navigations as $row) { ?>
				<option value="<?php echo $row['navigation']; ?>">
					<?php echo $row['label']; ?>
				</option>
			<?php } ?>
		<?php } ?>
	</select>
	<select name="page" id="page" class="field fll mrr4">
		<option value=""><?php echo $this->objLanguage->labels[44]; ?></option>
		<?php if (!empty($pages)) { ?>
			<?php foreach($pages as $row) { ?>
				<option value="<?php echo $row['id']; ?>">
					<?php echo $row['name']; ?>
				</option>
			<?php } ?>
		<?php } ?>
	</select>
	<input type="submit" class="button button-orange" 
		value="<?php echo $this->objLanguage->labels[45]; ?>" />
		
		<div class="devider"></div>
</form>

<table class="tbl_repeat">
	<tr>
		<th><?php echo $this->objLanguage->labels[47]; ?></th>
		<th class="colone"><?php echo $this->objLanguage->labels[18]; ?></th>
	</tr>	
	<?php if (!empty($main)) { ?>
		<?php $i = 1; foreach($main as $row) { ?>
			<?php if ($i == 1) { ?>
				<tr class="sub-heading">
					<th colspan="2"><?php echo $row['label']; ?></th>
				</tr>
				<tbody class="tbody">
			<?php } ?>
			<tr id="<?php echo $row['id']; ?>">
				<td><?php echo $row['name']; ?></td>
				<td>
					<a href="#" class="remove" rel="<?php echo $this->objUrl->getCurrent().'/call/remove/id/'.$row['id']; ?>">
						<?php echo $this->objLanguage->labels[18]; ?>
					</a>
				</td>
			</tr>
		<?php $i++; } ?>
		</tbody>
	<?php } ?>
	<?php if (!empty($left)) { ?>
		<?php $i = 1; foreach($left as $row) { ?>
			<?php if ($i == 1) { ?>
				<tr class="sub-heading">
					<th colspan="2"><?php echo $row['label']; ?></th>
				</tr>
				<tbody class="tbody">
			<?php } ?>
			<tr id="<?php echo $row['id']; ?>">
				<td><?php echo $row['name']; ?></td>
				<td>
					<a href="#" class="remove" rel="<?php echo $this->objUrl->getCurrent().'/call/remove/id/'.$row['id']; ?>">
						<?php echo $this->objLanguage->labels[18]; ?>
					</a>
				</td>
			</tr>
		<?php $i++; } ?>
		</tbody>
	<?php } ?>
	<?php if (!empty($footer)) { ?>
		<?php $i = 1; foreach($footer as $row) { ?>
			<?php if ($i == 1) { ?>
				<tr class="sub-heading">
					<th colspan="2"><?php echo $row['label']; ?></th>
				</tr>
				<tbody class="tbody">
			<?php } ?>
			<tr id="<?php echo $row['id']; ?>">
				<td><?php echo $row['name']; ?></td>
				<td>
					<a href="#" class="remove" rel="<?php echo $this->objUrl->getCurrent().'/call/remove/id/'.$row['id']; ?>">
						<?php echo $this->objLanguage->labels[18]; ?>
					</a>
				</td>
			</tr>
		<?php $i++; } ?>
		</tbody>
	<?php } ?>
	
	<?php if (empty($main) && empty($left) && empty($footer)) { ?>
		
		<tr>
			<td colspan="2"><?php echo $this->objLanguage->labels[64]; ?></td>
		</tr>
		
	<?php } ?>
	
</table>

<div class="dn" id="add_url">/panel/content/c/pages/a/navigation/call/add</div>
<div class="dn" id="order_url">/panel/content/c/pages/a/navigation/call/order</div>

<?php require_once('footer.php'); } ?>




