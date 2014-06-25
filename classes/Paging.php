<?php
class Paging {

	private $objUrl;
	private $objLanguage;
	
	private $total_records = 0;
	private $total_pages = 1;
	private $current = 1;
	private $first = 1;
	private $last = 1;
	
	public $records;
	public $per_page;
	public $extension;
	public $key = 'pg';
	
	
	
	
	
	
	
	
	
	public function __construct(
		$objUrl = null, $objLanguage = null,
		$records = null, $per_page = 10,
		$extension = null, $key = null
	) {
		
		$this->objUrl = is_object($objUrl) ? $objUrl : new Url();
		$this->objLanguage = is_object($objLanguage) ? 
			$objLanguage : new Language();
			
		if (!empty($records)) {
			
			$this->records = $records;
			$this->per_page = $per_page;
			
			if (!empty($extension)) {
				$this->extension = $extension;
			}
			if (!empty($key)) {
				$this->key = $key;
			}
			
			$this->process();
			
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	private function process() {
		
		if (!empty($this->records)) {
			$this->total_records = count($this->records);
			if ($this->total_records > $this->per_page) {
				$this->total_pages = ceil($this->total_records / $this->per_page);
				$this->last = $this->total_pages;
			}
			$current = $this->objUrl->get($this->key);
			$current = $current < 1 ? 1 : $current;
			$this->current = $current > $this->total_pages ?
				$this->total_pages : 
				$current;
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getRecords() {
		$first = ($this->current - 1) * $this->per_page;
		if (!empty($this->total_records) && $first <= $this->total_records) {
			return array_splice($this->records, $first, $this->per_page);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getPaging() {
	
		$out = array();
		
		if ($this->current != 1) {
			
			$first = $this->objUrl->getCurrent($this->key).
				'/'.$this->key.'/'.$this->first;
			
			$prev = $this->current - 1;
			$prev = $this->objUrl->getCurrent($this->key).
				'/'.$this->key.'/'.$prev;
				
			$item  = '<a href="'.$first.'">';
			$item .= $this->objLanguage->labels[55];
			$item .= '</a>';
			$out[] = $item;
			
			$item  = '<a href="'.$prev.'">';
			$item .= $this->objLanguage->labels[56];
			$item .= '</a>';
			$out[] = $item;
			
		} else {
			
			$item  = '<span>';
			$item .= $this->objLanguage->labels[55];
			$item .= '</span>';
			$out[] = $item;
			
			$item  = '<span>';
			$item .= $this->objLanguage->labels[56];
			$item .= '</span>';
			$out[] = $item;
			
		}
		
		if ($this->current < $this->total_pages) {
			
			$next = $this->current + 1;
			$next = $this->objUrl->getCurrent($this->key).
				'/'.$this->key.'/'.$next;
			
			$last = $this->objUrl->getCurrent($this->key).
				'/'.$this->key.'/'.$this->last;
				
			$item  = '<a href="'.$next.'">';
			$item .= $this->objLanguage->labels[57];
			$item .= '</a>';
			$out[] = $item;
			
			$item  = '<a href="'.$last.'">';
			$item .= $this->objLanguage->labels[58];
			$item .= '</a>';
			$out[] = $item;
			
		} else {
			
			$item  = '<span>';
			$item .= $this->objLanguage->labels[57];
			$item .= '</span>';
			$out[] = $item;
			
			$item  = '<span>';
			$item .= $this->objLanguage->labels[58];
			$item .= '</span>';
			$out[] = $item;
			
		}
		
		$return  = '<div class="paging"><ul>';
		$return .= '<li>'.implode('</li><li>', $out).'</li>';
		$return .= '</ul></div>';
		return $return;
	
	}
	
	










}




