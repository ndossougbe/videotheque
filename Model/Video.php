<?php

class Video extends AppModel{
	
	/** Règles de validation lors d'une création ou mise à jour*/ 
	public $validate = array(
		'name' => array(
			'rule'		 => "notEmpty",
			'required'	 => true,
			'message'	 => "Le titre ne doit pas être vide."
		),
		'releaseDate' => array(
			'rule'       => array('date','dmy'),
			'required'   => false,
			'allowEmpty' => true,
			'message'	 => "Le format de date est incorrect."
		),
		'duration' => array(
			'rule'       => 'time',
			'required'   => false,
			'allowEmpty' => true,
			'message'	 => "Le format est incorrect."
		),
		'rating' => array(
			'rule'       => array('decimal','1'),
			'required'   => false,
			'allowEmpty' => true,
			'message'	 => "Le format est incorrect."
		),
		'cover' => array(
			'rule'       => array('extension',array('png','gif','jpg','jpeg')),
			'required'   => false,
			'allowEmpty' => true,
			'message'	 => "Formats d'image acceptés: png, gif, jpg, jpeg."
		),

	);

	// many to one
	public $belongsTo = array('Format','Director' => array('className' => 'Personne'),'Country');
	public $hasMany = array('Actor', 'CategoriesVideo');
	// public $hasAndBelongsToMany = array(
	// 		'Personne' => array('unique' => 'keepExisting')
	// 	, 'Category' => array('unique' => 'keepExisting')
	// );


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
		// debug($this->data);
		// die();
		return true;
	}

	public function saveVideo($data){
		// Traiment cover? online vs local?
		// Traitement Note
		$rating = str_replace(',','.',$data['Video']['rating']);
		$data['Video']['rating'] = intval($rating);
	
		// Traitement réalisateur
		$directorName = trim($data['Director']['name']);
		if( $directorName != ''){
			$tmp = $this->Director->find('first', array('conditions' => array('Director.name' => $directorName)));
			if($tmp != null){
				$data['Director']['id'] = $tmp['Director']['id']; 
			}
		}

		// Traitement nationalité
		$nationality = trim($data['Country']['nationality']);
		if( $nationality != ''){
			$tmp = $this->Country->find('first', array('conditions' => array('Country.nationality' => $nationality)));
			if($tmp != null){
				$data['Country']['id'] = $tmp['Country']['id']; 
			}
		}

		// Traitement acteurs
		// Tableau témoin. Les entrées non visitées sont à enlever.
		$toDelete = $this->Actor->find('list',array('conditions' => array('Actor.video_id' => $data['Video']['id'])));
		foreach( explode(',',$data['Video']['Acteurs']) as $k => $v ) {
			$v = trim($v);
			if($v != ''){
				// La personne existe-t-elle en base?
				$person = $this->Actor->Personne->find('first', array('conditions' => array('Personne.name' => $v)));
				if( $person ){
					// Est-elle déjà un acteur dans ce film?
					$tmp = $this->Actor->find('first', array(
						 'conditions' => array('Actor.personne_id' => $person['Personne']['id'], 'Actor.video_id' => $data['Video']['id'])
					));
					if( $tmp ){
						// Oui, donc c'est cool, on signale qu'il faut la garder.
						// $actor = $tmp['Actor'];
						unset($toDelete[$tmp['Actor']['id']]);
					}
					else{
						// Non, on indique qu'elle est maintenant liée à la vidéo
						$data['Actor'][] = array(
							'video_id' => $data['Video']['id']
						, 'Personne' => $person['Personne']
						);
					}
				}
				else{
					// Elle n'existe pas, il faut la créer et la lier.
					$data['Actor'][] = array(
						'video_id' => $data['Video']['id']
					, 'Personne' => array('name' => $v)
					);
				}
			}
		}
		// On peut supprimer les enregistrements non trouvés dans la liste soumise. 
		$this->Actor->deleteAll(array('Actor.id' => $toDelete));

		// Traitement catégories
		// Tableau témoin. Les entrées non visitées sont à enlever.
		$toDelete = $this->CategoriesVideo->find('list',array('conditions' => array('CategoriesVideo.video_id' => $data['Video']['id'])));
		foreach( explode(',',$data['Video']['Categories']) as $k => $v ) {
			$v = trim($v);
			if($v != ''){
				// La catégorie existe-t-elle en base?
				$category = $this->CategoriesVideo->Category->find('first', array('conditions' => array('Category.name' => $v)));
				if( $category ){
					// Est-elle déjà un associée à ce film?
					$tmp = $this->CategoriesVideo->find('first', array(
						 'conditions' => array('CategoriesVideo.category_id' => $category['Category']['id'], 'CategoriesVideo.video_id' => $data['Video']['id'])
					));
					if( $tmp ){
						// Oui, donc c'est cool, on signale qu'il faut la garder.
						unset($toDelete[$tmp['CategoriesVideo']['id']]);
					}
					else{
						// Non, on indique qu'elle est maintenant liée à la vidéo
						$data['CategoriesVideo'][] = array(
							'video_id' => $data['Video']['id']
						, 'Category' => $category['Category']
						);
					}
				}
				else{
					// Elle n'existe pas, il faut la créer et la lier.
					$data['CategoriesVideo'][] = array(
						'video_id' => $data['Video']['id']
					, 'Category' => array('name' => $v)
					);
				}
			}
		}
		// On peut supprimer les enregistrements non trouvés dans la liste soumise. 
		$this->CategoriesVideo->deleteAll(array('CategoriesVideo.id' => $toDelete));

		//debug($data);
		return $this->saveAssociated($data, array('deep' => true));
	}
}
?>
