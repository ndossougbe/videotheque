<?php

class Personne extends AppModel{
	
	public $hasAndBelongsToMany = array(
        'EstActeur' =>
            array(
                'className'              => 'Video',
                'joinTable'              => 'personnes_videos_acteurs'
            )
    );
}
?>