<?php
session_start();

require_once('config.php');

function __autoload($class_name) {
	$class = explode('_', $class_name);
	$path = implode(DS, $class).'.php';
	if (0 === strpos($class_name, 'Swift')) {
		@require_once('Swift'.DS.'classes'.DS.$path);
	} else {
		@require_once($path);
	}
}