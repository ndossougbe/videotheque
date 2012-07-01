<?php

class Categorie extends AppModel{
	
	public $hasAndBelongsToMany = array(
        'CategorieVideo' =>
            array(
                'className'              => 'Video',
                'joinTable'              => 'categories_videos'
            )
    );
}
?>