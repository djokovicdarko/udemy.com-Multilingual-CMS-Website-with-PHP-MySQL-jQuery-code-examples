<?php
class Language {

	private $table = 'languages';
	private $table_2 = 'labels';
	private $table_3 = 'labels_content';
	private $table_4 = 'labels_types';
	private $table_5 = 'languages_content';
	private $table_6 = 'labels_types_content';
	private $table_7 = 'pages_content';
	private $table_8 = 'navigation_types_content';

	public $language = 1;
	private $Db;
	
	public $labels = array();










	public function __construct() {
		if (!empty($_COOKIE['lang'])) {
			$this->language = $_COOKIE['lang'];
		}
		$this->Db = new Dbase();
		$this->getLabels();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getLabels() {
	
		$sql = "SELECT `l`.`id`, `c`.`content`
				FROM `{$this->table_2}` `l`
				LEFT JOIN `{$this->table_3}` `c`
					ON `c`.`label` = `l`.`id`
				WHERE `c`.`language` = ?
				ORDER BY `l`.`name` ASC";
		$labels = $this->Db->getAll($sql, $this->language);
		if (empty($labels)) {
			setcookie('lang', 1, time() + 31536000, '/');
			$this->language = 1;
			$sql = "SELECT `l`.`id`, `c`.`content`
					FROM `{$this->table_2}` `l`
					LEFT JOIN `{$this->table_3}` `c`
						ON `c`.`label` = `l`.`id`
					WHERE `c`.`language` = ?
					ORDER BY `l`.`name` ASC";
			$labels = $this->Db->getAll($sql, $this->language);
		}
		if (!empty($labels)) {
			foreach($labels as $row) {
				$this->labels[$row['id']] = $row['content'];
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function getAll($search = null) {
		$fields = array();
		$values = array($this->language);
		$sql = "SELECT `l`.`id`, `l`.`name`, `c`.`label`
				FROM `{$this->table}` `l`
				LEFT JOIN `{$this->table_5}` `c`
					ON `c`.`language_id` = `l`.`id`
				WHERE `c`.`language` = ?";
		if (!empty($search) && is_array($search)) {
			$sql .= " AND (";
			foreach($search as $key => $value) {
				$fields[] = "`c`.`{$key}` LIKE ?";
				$values[] = "%{$value}%";
			}
			$sql .= implode(" OR ", $fields);
			$sql .= ")";			
		}
		$sql .= " ORDER BY `l`.`name` ASC";
		return $this->Db->getAll($sql, $values);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getAllLabels($search = null) {
		$fields = array();
		$values = array($this->language, $this->language);
		$sql = "SELECT `l`.`id`, `l`.`name`, `l`.`type`,
				`c`.`content`, `t`.`content` AS `type_name`
				FROM `{$this->table_2}` `l`
				LEFT JOIN `{$this->table_3}` `c`
					ON `c`.`label` = `l`.`id`
				LEFT JOIN `{$this->table_6}` `t`
					ON `t`.`label` = `l`.`type`
				WHERE `c`.`language` = ?
				AND `t`.`language` = ?";
		if (!empty($search) && is_array($search)) {
			$sql .= " AND (";
			foreach($search as $key => $value) {
				$fields[] = "`c`.`{$key}` LIKE ?";
				$values[] = "%{$value}%";
			}
			$sql .= implode(" OR ", $fields);
			$sql .= ")";
		}
		$sql .= " ORDER BY `l`.`type`, `l`.`name` ASC";
		return $this->Db->getAll($sql, $values);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getTypes($search = null) {
		$fields = array();
		$values = array($this->language);
		$sql = "SELECT `c`.*, `t`.`name`,
				IF (
					(
						SELECT COUNT(`id`)
						FROM `{$this->table_2}`
						WHERE `type` = `t`.`id`
					) > 0,
					1,
					0
				) AS `is_assigned`
				FROM `{$this->table_4}` `t`
				LEFT JOIN `{$this->table_6}` `c`
					ON `c`.`label` = `t`.`id`
				WHERE `c`.`language` = ?";
		if (!empty($search) && is_array($search)) {
			$sql .= " AND (";
			foreach($search as $key => $value) {
				$fields[] = "`c`.`{$key}` LIKE ?";
				$values[] = "%{$value}%";
			}
			$sql .= implode(" OR ", $fields);
			$sql .= ")";
		}
		$sql .= " ORDER BY `t`.`name` ASC";
		return $this->Db->getAll($sql, $values);		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function updateAll($array = null) {
		if (!empty($array)) {
			$array = Helper::makeArray($array);
			$errors = array();
			foreach($array as $key => $value) {
				$sql = "UPDATE `{$this->table_3}`
						SET `content` = ?
						WHERE `label` = ?
						AND `language` = ?";
				if (!$this->Db->execute($sql, array($value, $key, $this->language))) {
					$errors[] = $key;
				}
			}
			return empty($errors) ? true : false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function add($content = null, $type = null) {
		if (!empty($content) && !empty($type)) {
			
			$sql = "INSERT INTO `{$this->table_2}`
					(`name`, `type`) VALUES (?, ?)";
			if ($this->Db->insert($sql, array($content, $type))) {
				$id = $this->Db->_id;
				$errors = array();
				$languages = $this->getAll();
				if (!empty($languages)) {
					foreach($languages as $row) {
						$sql = "INSERT INTO `{$this->table_3}`
								(`label`, `language`, `content`)
								VALUES (?, ?, ?)";
						if (!$this->Db->insert($sql, array($id, $row['id'], $content))) {
							$errors[] = $row['id'];
						}
					}
					return empty($errors) ? true : false;
				}
				return false;
			}
			return false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function remove($id = null) {
		if (!empty($id)) {
			$sql = "DELETE FROM `{$this->table_2}`
					WHERE `id` = ?";
			return $this->Db->execute($sql, $id);
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function updateLanguages($array = null) {
		if (!empty($array)) {
			$array = Helper::makeArray($array);
			$errors = array();
			foreach($array as $key => $value) {
				$sql = "UPDATE `{$this->table_5}`
						SET `label` = ?
						WHERE `language_id` = ?
						AND `language` = ?";
				if (!$this->Db->execute($sql, array($value, $key, $this->language))) {
					$errors[] = $key;
				}
			}
			return empty($errors) ? true : false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	public function addLanguage($label = null) {
		
		if (!empty($label)) {
			
			$sql = "INSERT INTO `{$this->table}`
					(`name`) VALUES (?)";
			
			if ($this->Db->insert($sql, $label)) {
				
				$id = $this->Db->_id;
				$languages = $this->getAll();
				$values = array();
				
				if (!empty($languages)) {
					
					$sql = "START TRANSACTION;";
					
					foreach($languages as $language) {
						
						$sql .= "INSERT INTO `{$this->table_5}`
								(`language_id`, `language`, `label`)
								VALUES (?, ?, ?);";
						
						$values[] = $id;
						$values[] = $language['id'];
						$values[] = $label;
						
						$sql .= "INSERT INTO `{$this->table_5}`
								(`language_id`, `language`, `label`)
								VALUES (?, ?, ?);";
						
						$values[] = $language['id'];
						$values[] = $id;
						$values[] = $language['label'];
						
					}
					
					$sql .= "INSERT INTO `{$this->table_5}`
							(`language_id`, `language`, `label`)
							VALUES (?, ?, ?);";
					
					$values[] = $id;
					$values[] = $id;
					$values[] = $label;
					
					$objPage = new Page();
					$pages = $objPage->getAll();
					
					if (!empty($pages)) {
						foreach($pages as $page) {
							$sql .= "INSERT INTO `{$this->table_7}`
									(`page`, `language`, `name`, `content`,
									`meta_title`, `meta_description`,
									`meta_keywords`)
									VALUES (?, ?, ?, ?, ?, ?, ?);";
							$values[] = $page['id'];
							$values[] = $id;
							$values[] = $page['name'];
							$values[] = $page['content'];
							$values[] = $page['meta_title'];
							$values[] = $page['meta_description'];
							$values[] = $page['meta_keywords'];
						}
					}
					
					
					$objNavigation = new Navigation();
					$navigation_types = $objNavigation->getAllTypes();
					
					if (!empty($navigation_types)) {
						foreach($navigation_types as $navigation_type) {
							$sql .= "INSERT INTO `{$this->table_8}`
									(`navigation`, `language`, `label`)
									VALUES (?, ?, ?);";
							$values[] = $navigation_type['navigation'];
							$values[] = $id;
							$values[] = $navigation_type['label'];
						}
					}
					
					
					$label_types = $this->getTypes();
					
					if (!empty($label_types)) {
						foreach($label_types as $label_type) {
							$sql .= "INSERT INTO `{$this->table_6}`
									(`label`, `language`, `content`)
									VALUES (?, ?, ?);";
							$values[] = $label_type['label'];
							$values[] = $id;
							$values[] = $label_type['name'];
						}
					}
					
					
					
					if (!empty($this->labels)) {
						foreach($this->labels as $key => $value) {
							$sql .= "INSERT INTO `{$this->table_3}`
									(`label`, `language`, `content`)
									VALUES (?, ?, ?);";
							$values[] = $key;
							$values[] = $id;
							$values[] = $value;
						}
					}
					
					$sql .= "COMMIT;";
					
					return $this->Db->execute($sql, $values);
					
					
				}
				return false;
			}
			return false;
			
		}
		return false;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	public function removeLanguage($id = null) {
		if (!empty($id)) {
			$sql = "DELETE FROM `{$this->table}`
					WHERE `id` = ?";
			return $this->Db->execute($sql, $id);
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	public function updateTypes($array = null) {
		if (!empty($array)) {
			$array = Helper::makeArray($array);
			$errors = array();
			foreach($array as $key => $value) {
				$sql = "UPDATE `{$this->table_6}`
						SET `content` = ?
						WHERE `label` = ?
						AND `language` = ?";
				if (!$this->Db->execute($sql, array($value, $key, $this->language))) {
					$errors[] = $key;
				}				
			}
			return empty($errors) ? true : false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function addType($label = null) {
	
		if (!empty($label)) {
			
			$sql = "INSERT INTO `{$this->table_4}`
					(`name`) VALUES (?)";
			
			if ($this->Db->insert($sql, $label)) {
				
				$id = $this->Db->_id;
				
				$types = $this->getAll();
				
				if (!empty($types)) {
					
					$errors = array();
					
					foreach($types as $type) {
					
						$sql = "INSERT INTO `{$this->table_6}`
								(`label`, `language`, `content`)
								VALUES (?, ?, ?)";
						
						if (!$this->Db->insert($sql, array($id, $type['id'], $label))) {
							$errors[] = $type['id'];
						}
					
					}
					
					return empty($errors) ? true : false;
				
				}
				return false;
				
			}
			return false;
			
		}
		return false;
	
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getType($id = null) {
		if (!empty($id)) {
			$sql = "SELECT `c`.*, `t`.`name`,
					IF (
						(
							SELECT COUNT(`id`)
							FROM `{$this->table_2}`
							WHERE `type` = `t`.`id`
						) > 0,
						1,
						0
					) AS `is_assigned`
					FROM `{$this->table_4}` `t`
					LEFT JOIN `{$this->table_6}` `c`
						ON `c`.`label` = `t`.`id`
					WHERE `t`.`id` = ?
					AND `c`.`language` = ?";
			return $this->Db->getOne($sql, array($id, $this->language));
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	public function removeType($id = null) {
		if (!empty($id)) {
			$sql = "DELETE FROM `{$this->table_4}`
					WHERE `id` = ?";
			return $this->Db->execute($sql, $id);
		}
		return false;
	}












}



