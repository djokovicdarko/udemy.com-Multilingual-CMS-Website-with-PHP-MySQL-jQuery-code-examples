<?php
class Validation {

	public $objLanguage;
	
	public $tag = 'span';
	public $wrap = false;
	
	public $errors = array();
	
	public $message = array(
		'full_name' => 28,
		'email' => 29,
		'enquiry' => 30,
		'name' => 31,
		'content' => 32,
		'meta_title' => 33,
		'meta_description' => 34,
		'meta_keywords' => 35,
		'identity' => 36,
		'identity_taken' => 37,
		'first_name' => 92,
		'last_name' => 94,
		'password' => 95,
		'access' => 96,
		'email_taken' => 97
	);
	
	
	
	
	
	
	
	
	
	
	
	public function __construct($objLanguage = null) {
		$this->objLanguage = is_object($objLanguage) ? $objLanguage : new Language();
	}
	
	
	
	
	
	
	
	
	
	
	public function isValid($array = null, $required = null, $special = null) {
		
		if (!empty($array)) {
			
			$array = Helper::makeArray($array);
			$required = Helper::makeArray($required);
			$special = Helper::makeArray($special);
			
			foreach($array as $key => $value) {
				if (Helper::isEmpty($value) && in_array($key, $required)) {
					$this->errors[$key] = $this->wrap ?
						$this->wrapMessage($this->objLanguage->labels[$this->message[$key]]) :
						$this->objLanguage->labels[$this->message[$key]];
				}
				if (!empty($special) && array_key_exists($key, $special)) {
					switch($special[$key]) {
						case 'email':
						$this->isEmail($key, $value);
						break;						
					}
				}
			}
			
			foreach($required as $key) {
				if (!array_key_exists($key, $array)) {
					$this->errors[$key] = $this->wrap ?
						$this->wrapMessage($this->objLanguage->labels[$this->message[$key]]) :
						$this->objLanguage->labels[$this->message[$key]];
				}
			}
			
			return empty($this->errors) ? true : false;
			
		}
		
		return false;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	public function isEmail($key = null, $email = null) {
		if (!empty($key) && !empty($email)) {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->errors[$key] = $this->wrap ? 
					$this->wrapMessage($this->objLanguage->labels[$this->message['email']]) :
					$this->objLanguage->labels[$this->message['email']];
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function add2Errors($key = null, $index = null) {
		if (!empty($key)) {
			$index = !empty($index) ? $index : $key;
			$this->errors[$key] = $this->wrap ? 
					$this->wrapMessage($this->objLanguage->labels[$this->message[$index]]) :
					$this->objLanguage->labels[$this->message[$index]];
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function getMessage($key = null) {
		if (!empty($key) && !empty($this->errors) && array_key_exists($key, $this->errors)) {
			return $this->wrapMessage($this->errors[$key]);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function wrapMessage($message = null) {
		return !empty($message) ? 
			'<'.$this->tag.' class="warning">'.$message.'</'.$this->tag.'>' :
			null;
	}
	










}




