<?php

class CategoriesVideo extends AppModel{
	
	public $belongsTo = array('Category','Video');

	public function formatTextArea($array){
		$categories = $this->Category->find('list');

		$ret = array();
		foreach ($array as $k => $v) {
			$ret[] = $categories[$v['category_id']];	
		}
		return implode(', ',$ret);
	}
}
?>