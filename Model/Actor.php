<?php

class Actor extends AppModel{
	
	public $belongsTo = array('Personne','Video');

	public function formatTextArea($array){
		$people = $this->Personne->find('list');

		$ret = array();
		foreach ($array as $k => $v) {
			$ret[] = $people[$v['personne_id']];	
		}
		return implode(', ',$ret);
	}
}
?>