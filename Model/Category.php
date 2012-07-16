<?php

class Category extends AppModel{
	
	public $hasAndBelongsToMany = array('Video');
}
?>