<?php

class AppModel extends Model{


	public function formatTextArea($array){
		$ret = array();
		foreach ($array as $k => $v) {
			$ret[] = $v['name'];	
		}
		return implode(', ',$ret);
	}

	public function find($type, $options = array()) { 

		switch ($type) { 
			case 'typeahead':
			$lst = array();
			foreach ($this->find('list',$options) as $k => $v) {
				$lst[] = '"'.$v.'"' ;
			}
			return "[".implode(', ',$lst)."]";
			break;
		}
		return parent::find($type, $options); 
	}
	
}