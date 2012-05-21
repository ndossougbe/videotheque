<?php

class Media extends AppModel{

	// Les noms de classe et de table ne correspondent pas aux spécifs par défaut.
	// Il faut donc utiliser useTable pour préciser la table dans la bdd à utiliser.
	public $useTable = 'medias';

	public $validate = array(
		'url' => array(
			'rule'		=> '/^.*\.(jpg|png|jpeg)$/',
			'required'	=> true,
			'message'	=> "Le fichier n'est pas une image valide."
		)
	);

}

?>