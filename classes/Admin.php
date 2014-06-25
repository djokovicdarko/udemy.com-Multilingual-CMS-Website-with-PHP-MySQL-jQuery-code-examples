<?php
class Admin {

	private $table = 'admins';
	private $table_2 = 'access';
	private $table_3 = 'access_content';
	private $Db;
	
	private $objLanguage;
	public $user;
	
	
	
	
	
	
	
	
	
	
	
	
	public function __construct($objLanguage = null) {
		$this->objLanguage = is_object($objLanguage) ?
			$objLanguage :
			new Language();
		$this->Db = new Dbase();
	}
	
	
	
	
	
	
	
	
	
	
	public function getOne($id = null) {
		if (!empty($id)) {
			$sql = "SELECT `id`, `first_name`, `last_name`,
					`email`, `salt`, `access`,
					CONCAT_WS(' ', `first_name`, `last_name`) AS `full_name`
					FROM `{$this->table}`
					WHERE `id` = ?";
			return $this->Db->getOne($sql, $id);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getByEmail($email = null) {
		if (!empty($email)) {
			$sql = "SELECT *
					FROM `{$this->table}`
					WHERE `email` = ?";
			return $this->Db->getOne($sql, $email);
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function isAdmin($email = null, $password = null) {
		if (!empty($email) && !empty($password)) {
			$this->user = $this->getByEmail($email);
			if (!empty($this->user)) {
				$password = $this->makePassword($password, $this->user['salt']);
				if ($this->user['password'] == $password) {
					return true;
				}
				return false;
			}
			return false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	public function makePassword($password = null, $salt = null) {
		return sha1($password.$salt.$password);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getAll($search = null) {
		$fields = array();
		$values = array($this->objLanguage->language);
		$sql = "SELECT `u`.*,
				CONCAT_WS(' ', `u`.`first_name`, `u`.`last_name`) AS `full_name`,
				`a`.`label`
				FROM `{$this->table}` `u`
				LEFT JOIN `{$this->table_3}` `a`
					ON (`a`.`access` = `u`.`access` AND `a`.`language` = ?)";
		if (!empty($search) && is_array($search)) {
			$sql .= " WHERE (";
			foreach($search as $key => $value) {
				$fields[] = "`u`.`{$key}` LIKE ?";
				$values[] = "%{$value}%";
			}
			$sql .= implode(" OR ", $fields);
			$sql .= ")";
		}
		$sql .= " ORDER BY `u`.`first_name`, `u`.`last_name` ASC";
		return $this->Db->getAll($sql, $values);
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getAccess() {
		$sql = "SELECT `a`.`id`, `c`.`label`
				FROM `{$this->table_2}` `a`
				LEFT JOIN `{$this->table_3}` `c`
					ON (`c`.`access` = `a`.`id` AND `c`.`language` = ?)
				ORDER BY `a`.`id` ASC";
		return $this->Db->getAll($sql, $this->objLanguage->language);
	}
	
	
	
	
	
	
	
	
	
	
	public function duplicate($email = null, $id = null) {
		if (!empty($email)) {
			$values = array($email);
			$sql = "SELECT *
					FROM `{$this->table}`
					WHERE `email` = ?";
			if (!empty($id)) {
				$sql .= " AND `id` != ?";
				$values[] = $id;
			}
			return $this->Db->getAll($sql, $values);
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function update($array = null, $admin = null) {
		if (!empty($array) && !empty($admin)) {
			$array = Helper::makeArray($array);
			$fields = array();
			$values = array();
			$sql = "UPDATE `{$this->table}` SET ";
			foreach($array as $key => $value) {
				if (!Helper::isEmpty($value)) {
					switch($key) {
						case 'password':
						$fields[] = "`{$key}` = ?";
						$values[] = $this->makePassword($value, $admin['salt']);
						break;
						default:
						$fields[] = "`{$key}` = ?";
						$values[] = $value;
					}
				}
			}
			$sql .= implode(", ", $fields);
			$sql .= " WHERE `id` = ?";
			$values[] = $admin['id'];
			return $this->Db->execute($sql, $values);
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	public function remove($id = null) {
		if (!empty($id)) {
			$sql = "DELETE FROM `{$this->table}`
					WHERE `id` = ?";
			return $this->Db->execute($sql, $id);					
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function add($array = null) {
		if (!empty($array)) {
			$sql = "INSERT INTO `{$this->table}`
			(`first_name`, `last_name`, `email`, `password`, `access`, `salt`)
			VALUES (?, ?, ?, ?, ?, ?)";
			return $this->Db->insert($sql, array(
				$array['first_name'],
				$array['last_name'],
				$array['email'],
				$array['password'],
				$array['access'],
				$array['salt']
			));
		}
		return false;
	}
	
	
	













}