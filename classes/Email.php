<?php
require_once('Swift'.DS.'swift_required.php');

class Email {

	private $_smtp_host = SMTP_HOST;
	private $_smtp_port = SMTP_PORT;
	private $_smtp_user = SMTP_USER;
	private $_smtp_pass = SMTP_PASSWORD;




	
	
	
	
	
	
	
	public function send($case = null, $from = null, $to = null, $data = null) {
	
		if (!empty($case) && !empty($from) && !empty($to)) {
		
			$from = is_array($from) ? $from : array($from => $from);
			$to = is_array($to) ? $to : array($to => $to);
			
			$file = EMAILS_PATH.DS.$case.'.php';
			
			if (is_file($file)) {
				ob_start();
				require_once($file);
				$body = ob_get_clean();
			} else {
				$body = 'Missing email template';
			}
			
			$transport = Swift_SmtpTransport::newInstance($this->_smtp_host, $this->_smtp_port);
			$transport->setUsername($this->_smtp_user);
			$transport->setPassword($this->_smtp_pass);
			
			$objMailer = Swift_Mailer::newInstance($transport);
			
			switch($case) {
				
				case 1:
				$message = Swift_Message::newInstance('Contact from My Website');
				$message->setMaxLineLength(700);
				$message->setPriority(2);
				$message->setFrom($from);
				$message->setTo($to);
				$message->setBody($body, 'text/html');
				$message->addPart(strip_tags($body), 'text/plain');
				break;
				
			}
			
			$result = $objMailer->send($message);
			
			return empty($result) ? false : true;
			
		}
		
		return false;
	
	}
	
	
	
	
	
	
	



}





