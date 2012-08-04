<?php
class VideosController extends AppController{
	
	/* Liste des modèles utilisés dans ce contrôleur. Par défaut, le
	 * modèle utilisé est XXX pour XXXsController
	 */
	public $uses = array('Video','Personne','Category', 'Country', 'Actor', 'CategoriesVideo');
	public $jaquette_indisponible = "covers/jaquette_indisponible.png";
	
		/* Condition de projection*/
		/*$q=$this->Video->find('all',array(
			'fields'=>array('name')
		));
		*/

		/* Condition de sélection: find('all',array(
			'conditions' => array('format' => 1)
		));*/
	//Convention: $d => tableau des variables envoyées à la vue (display)

	/// Fonctions ajax
	public function ajaxPreview($id){
		$this->Video->id = $id;
		$video = $this->Video->read();

		$ret = array(
			'cover'      => $video['Video']['cover']
			, 'name'     => $video['Video']['name']
			, 'synopsis' => $video['Video']['synopsis']
			, 'casting'  => $this->Actor->formatTextArea($video['Actor'])
		);
		echo json_encode($ret);
	}
	
	public function admin_ajaxParse($video_id){
		$this->AllocineParser = $this->Components->load('AllocineParser');
		echo json_encode($this->AllocineParser->parse($video_id));
	}

	public function admin_ajaxAllocineSearch($video_title){
		$this->AllocineParser = $this->Components->load('AllocineParser');
		$this->autoRender = false;
		$this->layout = false;	// layout désactivé sur la prochaine fenêtre.
		echo $this->AllocineParser->searchResults($video_title);
	}

	/// Actions
	public function index(){
		// debug($this->request->data);
		// debug($this->request->params);

		$search = array();

		if($this->request->is("post")) {
	    $url = array('action'=>'index');
	    if( $this->request->params['admin'] ){
	    	$url['prefix'] = 'admin';
	    }
	    $filters = array();

	    if(isset($this->request->data['Search']) && $this->data['Search']){
	        //maybe clean up user input here??? or urlencode??
	        $filters['Search'] = $this->request->data['Search'];
	    }
	    //redirect user to the index page including the selected filters
	    $this->redirect(array_merge($url,$filters)); 
		}
		else if ( isset($this->request->params['named']['Search']) ){
			$search = $this->request->params['named']['Search'];
		}

		

		// debug($search);
		// Filtrage
		$conditions = array();
		$joins = array();

		if( !empty($search) ){
			if($search['name']) $conditions['Video.name LIKE'] = '%'.$search['name'].'%';	

			if($search['advanced']){
				// Le choix neutre a pour valeur 0 <=> false <=> pas de condition supplémentaire.
				if($search['format']) $conditions['Video.format_id'] = $search['format'];

				// HABTM, c'est un peu plus compliqué:
				if($search['category']){
					$joins[] = array(
							'table' => 'categories_videos'
            , 'alias' => 'CategoriesVideo'
            , 'type' => 'inner'
            , 'foreignKey' => false
            , 'conditions'=> array('CategoriesVideo.video_id = Video.id')
					);
					$conditions['CategoriesVideo.category_id'] = $search['category'];
				}

				
				if($search['actor']){
					$actors = $this->Personne->find('list',array(
						'conditions' => array('Personne.name LIKE' => '%'.$search['actor'].'%')
						, 'fields' => array('Personne.id')
						, 'recursive' => -1 	// Pour ne pas aller checher les infos de videos et cie associés.
					));
					// debug($actors);
					
					$joins[] = array(
							'table' => 'actors'
            , 'alias' => 'Actor'
            , 'type' => 'inner'
            , 'foreignKey' => false
            , 'conditions'=> array('Actor.video_id = Video.id')
					);
					$conditions['Actor.personne_id'] = $actors;
				}
			}
		}
		
		// Règles de pagination, définies ici localement. Mettre au début du ctrl pour global.
		$this->paginate = array('Video' => array(
				'conditions' => $conditions
			, 'joins' => $joins
			, 'fields' => array('DISTINCT Video.name', 'Video.format_id', 'Video.id', 'Format.name')
			// ,'limit' => 1
		));
		$d['videos'] = $this->Paginate('Video');

		foreach ($d['videos'] as $k => $v) {
			$d['videos'][$k]['Video']['categories'] = $this->CategoriesVideo->formatTextArea($d['videos'][$k]['CategoriesVideo']);
		}

		// Aussi étrange que ça puisse paraître, cela met bien le deuxième tableau à la suite du premier.
		$d['formats'] = array(0 => ' ------ ') + $this->Video->Format->find('list');
		$d['categories'] = array(0 => ' ------ ') + $this->Category->find('list');
		$d['lstActors'] = $this->Personne->find('typeahead');
		// debug($d);
		$this->set($d);
	}

	public function admin_index(){
		$this->index();
		$this->render('index');
	}

	public function menu(){
		$videos = $this->Video->find('all',array('fields' => array('id','name')));
		return $videos;
	}
	
	public function show($id = null){
		if( !$id )
			throw new NotFoundException('ID nul');
		
		$data = $this->Video->find('first',array('conditions' => array('Video.id' => $id)));
		
		if( !$data )
			throw new NotFoundException('Aucune vidéo ne correspond à cet ID ('.$id.').');
					
		$video = array(
				'name'        => $data['Video']['name']
			, 'url'         => $data['Video']['url']
			, 'format'      => $data['Format']['name']
			, 'created'     => $data['Video']['created']
			, 'cover'       => $data['Video']['cover']
			, 'director'    => $data['Director']['name']
			, 'nationality' => $data['Country']['nationality']
			, 'synopsis'    => $data['Video']['synopsis']
			, 'duration'    => $data['Video']['duration']
			, 'releasedate' => $data['Video']['releasedate']
			, 'rating'      => $data['Video']['rating']
			, 'actors'      => $this->Actor->formatTextArea($data['Actor'])
			, 'categories'  => $this->CategoriesVideo->formatTextArea($data['CategoriesVideo'])

		);	
		$d['video'] = $video;
		$this->set($d);
	}

	public function admin_show($id = null){
		$this->show($id);
		$this->render('show');
	}

	public function admin_delete($id){
		// Message de notifications. Utilise le template View/Elements/notif.ctp
		$this->Session->setFlash('La vidéo a bien été supprimée.','notif'); 
		$this->Video->delete($id);
		$this->redirect($this->referer()); // redirige sur la page appelante.
	}

	public function admin_edit($id = null){
		// Pour charger les listes dans la prochaine page
		if($this->request->is('put') || $this->request->is('post')){	// Vrai quand du contenu a été modifié ou ajouté(cf /lib/Cake/Network/CakeRequest.php)
			if($this->Video->saveVideo($this->request->data)){
				$this->Session->setFlash('La vidéo a bien été modifiée.','notif'); 
				$this->redirect(array('action' => 'index'));
				return;
			}
		}elseif($id != null){
			// charge data avec les données de la vidéo dont l'id est passé en paramètre
			$this->Video->id = $id;
			$this->request->data = $this->Video->read();
			
			$this->request->data['Video']['Acteurs'] = $this->Actor->formatTextArea($this->request->data['Actor']);
			$this->request->data['Video']['Categories'] = $this->CategoriesVideo->formatTextArea($this->request->data['CategoriesVideo']);
		}

		$d['formats'] = $this->Video->Format->find('list');
		$d['webroot'] = $this->webroot;
		$d['lstActors'] = $this->Personne->find('typeahead');
		$d['lstCategories'] = $this->Category->find('typeahead');
		$this->set($d);
	}

	public function admin_addimg($id_video = null){
		$this->layout = 'modal';
		if($id_video){
			$cover_dir = 'covers';
			if($this->request->is('post')){
				$data = $this->request->data;
				
				if(isset($data['url'])){
					$this->set('url', urlencode($data['url']));
					$this->redirect(array(
						'action' => 'updateCover',
						'controller' => 'Videos',
						'?url='.urlencode($data['url'])
					));
				}

				$dir = IMAGES.$cover_dir;
				if(!file_exists($dir)){
					mkdir($dir, 0777);
				}
				$f = explode('.',$data['file']['name']);	// découpe le nom de fichier en séparant par '.'
				$ext = '.'.end($f);	// dernier élément du tableau

				$f = array_slice($f, 0, -1);	// tous les éléments sauf le dernier
				$f = implode('.',$f);			// recollage en mettant des points
				$filename = Inflector::slug($f,'-'); // remplace les caractères spéciaux par '-'
				

				if(preg_match('/^.*\.(jpg|png|jpeg)$/',$filename.$ext)){
					
					move_uploaded_file($data['file']['tmp_name'], $dir.DS.$filename.$ext);

					$url = $cover_dir.'/'.$filename.$ext;

					$this->set('url', urlencode($url));
					$this->redirect(array(
						'action' => 'updateCover',
						'controller' => 'Videos',
						'?url='.urlencode($url)
					));
				}else{
					$this->Session->setFlash("L'image n'est pas au bon format",'notif',array('type' => 'error'));
				}

			}

			// Charge l'image de la vidéo dont l'id est passé en paramètre
			$video = $this->Video->find('first',array('conditions' => array('Video.id' => $id_video)));
			$d['src'] = $video['Video']['cover'];
			$this->set($d);
		}
		else{
			$this->set('src',$this->jaquette_indisponible);
		}
	}

	public function admin_updateCover(){
		//$this->set('url',Router::url('/img/'.urldecode($this->request->query['url'])));
		$this->set('url',urldecode($this->request->query['url']));
		$this->layout = false;	// layout désactivé sur la prochaine fenêtre.
		$this->render('popup');
	}

}
?>
