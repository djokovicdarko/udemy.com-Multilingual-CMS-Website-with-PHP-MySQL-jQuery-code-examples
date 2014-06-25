<?php
class Login {

	public static $key_user_id = 'user_id';
	public static $key_log = 'logged';
	
	
	
	
	
	
	
	
	
	public static function isLogged() {
		if (
			!empty($_SESSION[self::$key_user_id]) &&
			!empty($_SESSION[self::$key_log])
		) {
			return true;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public static function logout() {
		session_destroy();
		Helper::redirect('/panel');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public static function loginAdmin($id = null) {
		if (!empty($id)) {
			$_SESSION[self::$key_user_id] = $id;
			$_SESSION[self::$key_log] = time();
		}
	}
	










}




