<?php

class Personne extends AppModel{
	
	// public $hasAndBelongsToMany = array('Video');
	// public $hasAndBelongsToMany = array('Video' 'Personne' => array('unique' => 'keepExisting'));
	public $hasMany = array(
		'Movie' => array(
			'className' => 'Video',
			'foreignKey' => 'director_id'
		)
		, 'Actor'
	);
}
?>