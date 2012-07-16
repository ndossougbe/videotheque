<?php

class Personne extends AppModel{
	
	public $hasAndBelongsToMany = array('Video');
	public $hasMany = array('Movie' => array(
		'className' => 'Video',
		'foreignKey' => 'director_id'
	));
}
?>