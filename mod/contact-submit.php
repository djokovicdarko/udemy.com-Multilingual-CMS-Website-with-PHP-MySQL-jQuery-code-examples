<?php
require_once('../inc/autoload.php');

if (isset($_POST['full_name'])) {
	
	$objForm = new Form();
	$objValidation = new Validation();
	$objValidation->wrap = true;
	
	$expected = array('full_name', 'email', 'enquiry');
	$required = array('full_name', 'email', 'enquiry');
	
	$array = $objForm->post2Array($expected);
	
	if ($objValidation->isValid($array, $required)) {
		
		$objEmail = new Email();
		
		if ($objEmail->send(
			1,
			array($array['email'] => $array['full_name']),
			array(EMAIL_CONTACT => 'SSD Tutorials'),
			$array
		)) {
			echo json_encode(array('error' => false, 'message' => 'successful'));
		} else {
			echo json_encode(array('error' => false, 'message' => 'unsuccessful'));
		}
	
	} else {
		echo json_encode(array('error' => true, 'validation' => $objValidation->errors));
	}

} else {
	echo json_encode(array('error' => true));
}










