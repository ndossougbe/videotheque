<?php

class Video extends AppModel{
	
	/** Règles de validation lors d'une création ou mise à jour*/ 
	public $validate = array(
		'name' => array(
			'rule'		=> "notEmpty",
			'required'	=> true,
			'message'	=> "Le nom ne doit pas être vide."
		),
		'size' => array(
			'rule' => 'numeric',
			'required' => false,
			'allowEmpty' => true

		)

	);

	// many to one
	public $belongsTo = 'Format';
	public $hasAndBelongsToMany = array(
        'Acteurs' =>
            array(
                'className'              => 'Personne',
                'joinTable'              => 'personnes_videos_acteurs'
            ),
		'CategoriesVids' =>
			array(
			    'className'              => 'Categorie',
			    'joinTable'              => 'categories_videos'
			)
    );

	public function sizeValidation($check){
		if(empty($this->data['Video']['format']) && !isset($this->data['Video']['format']))
			return false;
		
		$format = $this->data['Video']['format'];
		if($format == 2){
			$check['size'] = null;
			return true;
		} else{
			if(empty($check['size']) || !isset($check['size'])){
				return false;
			}
			return true;
		}
	}


	/**
	 * Fonction appelée après le find. On la surcharge pour
	 * générer les infos à passer lorsqu'on veut afficher un lien.
	 * (cf Html helper, link)
	 */
	/*public function afterFind($data){

		//$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u, ");
		//$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,_");
	
		foreach($data as $k=>$d){
			if(isset($d['Video']['id']) && isset($d['Video']['name'])){
				$d['Video']['link'] = array(
					'controller'=> 'videos',
					'action'	=> 'show',
					'id'		=> $d['Video']['id'],
				);
			}
			$data[$k] = $d;
		}
		return $data;
	}*/

	public function beforeSave(){
		debug($this->data);
		die();
		return true;
	}
}
?>
