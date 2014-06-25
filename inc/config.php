<?php
date_default_timezone_set('Europe/London');

defined("PAGE_EXT")
	|| define("PAGE_EXT", '.html');
	
defined("DS")
	|| define("DS", DIRECTORY_SEPARATOR);
	
defined("ROOT_PATH")
	|| define("ROOT_PATH", realpath(dirname(__FILE__) . DS . ".." . DS));
	
defined("CLASSES_PATH")
	|| define("CLASSES_PATH", ROOT_PATH.DS.'classes');
	
defined("TEMPLATE_PATH")
	|| define("TEMPLATE_PATH", ROOT_PATH.DS.'template');
	
defined("EMAILS_PATH")
	|| define("EMAILS_PATH", ROOT_PATH.DS.'emails');
	

set_include_path(implode(PATH_SEPARATOR, array(
	realpath(ROOT_PATH),
	realpath(CLASSES_PATH),
	get_include_path()
)));
	


defined("SMTP_HOST")
	|| define("SMTP_HOST", 'mail.dummyemail.com');	
	
defined("SMTP_PORT")
	|| define("SMTP_PORT", 25);		
	
defined("SMTP_USER")
	|| define("SMTP_USER", 'email@dummyemail.com');	
	
defined("SMTP_PASSWORD")
	|| define("SMTP_PASSWORD", 'password');	
	
	


defined("EMAIL_CONTACT")
	|| define("EMAIL_CONTACT", 'myemail@dummyemail.com');	
	
	
	
	
	
	
	
	
	
	
	
	
	
	