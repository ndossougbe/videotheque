<?php

class Country extends AppModel{
	
	public $hasMany = array('Video');
	// public $validate = array(
	// 	'nationality' => array(
	// 		'rule'		 => "isUnique",
	// 		'required'	 => true,
	// 	)
	// );
}
?>