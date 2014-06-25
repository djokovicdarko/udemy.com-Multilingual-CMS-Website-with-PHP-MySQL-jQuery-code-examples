<?php
class Form {

	public $objUrl;
	
	
	
	
	
	
	
	
	public function __construct($objUrl = null) {
		$this->objUrl = is_object($objUrl) ? $objUrl : new Url();
	}
	
	
	
	
	
	public function post2Array($expected = null, $do_not_strip = null, $special = null) {
		if ($_POST) {
			$expected = Helper::makeArray($expected);
			$do_not_strip = Helper::makeArray($do_not_strip);
			$out = array();
			foreach($_POST as $key => $value) {
				$value = stripslashes($value);
				if (!empty($special) && array_key_exists($key, $special)) {
					$value = $this->special($special[$key], $value);
				}
				if (empty($do_not_strip) || !in_array($key, $do_not_strip)) {
					$value = strip_tags($value);
				}
				if (!empty($expected)) {
					if (in_array($key, $expected)) {
						$out[$key] = $value;
					}
				} else {
					$out[$key] = $value;
				}
			}
			return $out;
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function special($key = null, $value = null) {
		switch($key) {
			case 'sanitise':
			return Helper::sanitise($value);
			break;
			default:
			return $value;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	public function stickyText($key = null, $value = null) {
		if (!empty($key)) {
			if ($_POST && array_key_exists($key, $_POST)) {
				return stripslashes($_POST[$key]);
			} else {
				if (!empty($value)) {
					return $value;
				}
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function post2Url($key = null) {
		if (!empty($key) && isset($_POST[$key])) {
			$url = $this->objUrl->getCurrent($key);
			$post_key = urlencode(stripslashes($_POST[$key]));
			$url = !empty($post_key) ? 
				$url.'/'.$key.'/'.$post_key : 
				$url;
			Helper::redirect($url);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function stickySelect($key = null, $value = null, $data = null) {
		if (!empty($key)) {
			if ($_POST) {
				if (array_key_exists($key, $_POST) && $_POST[$key] == $value) {
					return ' selected="selected"';
				}
			} else {
				if (!empty($data) && $value == $data) {
					return ' selected="selected"';
				}
			}
		}
	}
	
	
	
	
	
	











}