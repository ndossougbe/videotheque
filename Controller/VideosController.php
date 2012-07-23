<?php
class VideosController extends AppController{
	
	/* Liste des modèles utilisés dans ce contrôleur. Par défaut, le
	 * modèle utilisé est XXX pour XXXsController
	 */
	public $uses = array('Video','Personne','Category', 'Country');
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

	private function format_textarea($array, $list=false){
		$ret = array();
		foreach ($array as $k => $v) {
			if(gettype($v) == 'array'){
				$ret[] = $v['name'];	
			}
			else if($list){
				$ret[] = "'".$v."'";
			}
			
		}
		return implode(', ',$ret);
	}



	
	function index(){
		// Règles de pagination, définies ici localement. Mettre au début du ctrl pour global.
		// défaut: 20
		$this->paginate = array('Video' => array(
			'limit' => 10	
		));
		$d['videos'] = $this->Paginate('Video');
		$this->set($d);
		$this->set('formats', $this->Video->Format->find('list'));
	}
	
	function menu(){
		$videos = $this->Video->find('all',array('fields' => array('id','name')));
		return $videos;
	}
	
	function show($id = null){
		if(!$id)
			throw new NotFoundException('ID nul');
		
		$video = $this->Video->find('first',array('conditions' => array('Video.id' => $id)));
		
		if(empty($video))
			throw new NotFoundException('Aucune vidéo ne correspond à cet ID ('.$id.').');
			
/*
		if($slug != $video['Video']['link']['slug'])
			//erreur 301: moved permanently. ex, dit à google que la page a été remplacée.
			$this->redirect($video['Video']['link'],301);
*/
			
		// Une fois que les vérifs sont faites, on envoie l'objet
		$d['video'] = current($video);
		$this->set($d);
	}

	function admin_index(){
		$this->index();
		$this->render('index');
	}

	function admin_show($id = null){
		$this->show($id);
		$this->render('show');
	}

	function admin_delete($id){
		// Message de notifications. Utilise le template View/Elements/notif.ctp
		$this->Session->setFlash('La vidéo a bien été supprimée. (!Commentée!)','notif'); 
		//$this->Video->delete($id);
		$this->redirect($this->referer()); // redirige sur la page appelante.
	}


	function saveVideo($data){

		// debug($data);
		// die();
		// // Traiment cover? online vs local?

		// Traitement Note
		$rating = str_replace(',','.',$data['Video']['rating']);
		// TODO passage 2.2 règle le problème de refus de 1 au lieu de 1.O
		$data['Video']['rating'] = $rating;
	

		// Traitement réalisateur
		$directorName = trim($data['Director']['name']);
		if( $directorName != ''){
			$tmp = $this->Personne->find('first', array('conditions' => array('Personne.name' => $directorName)));
			if($tmp != null){
				$data['Director']['id'] = $tmp['Personne']['id']; 
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

		// Sauvegarde de la vidéo et des association belongsTo.
		if(!$this->Video->saveAssociated($data)) return false;


		//// Associations HABTM

		// Traitement acteurs
		$actors = explode(',',$data['Video']['Acteurs']);
		$data['Video']['Acteurs'] = array();

		$actorArray = array();
		foreach ($actors as $k => $v) {
			$actor = array();
			$v = trim($v);
			if($v != ''){
				$actor['Video'] = array('id' => $data['Video']['id']);

				$tmp = $this->Personne->find('first', array('conditions' => array('Personne.name' => $v)));
				if($tmp != null){
					$actor['Personne'] = $tmp['Personne']; 
				}else{
					$this->Personne->create();
					$actor['Personne'] = array('name' => $v);	
				}
				$actorArray[] = $actor;
			}
		}
		if(!$this->Personne->saveAll($actorArray)) return false;

		// Traitement catégories
		$categories = explode(',',$data['Video']['Categories']);
		$categoryArray = array();
		foreach ($categories as $k => $v) {
			$category = array();
			$v = trim($v);
			if($v != ''){
				$category['Video'] = array('id' => $data['Video']['id']);

				$tmp = $this->Category->find('first', array('conditions' => array('Category.name' => $v)));
				if($tmp != null){
					$category['Category'] = $tmp['Category']; 
				}else{
					$this->Category->create();
					$category['Category'] = array('name' => $v);	
				}
				$categoryArray[] = $category;
			}
		}
		if(!$this->Category->saveAll($categoryArray)) return false;


		return true;
	}


	function admin_edit($id = null){
		// Pour charger la liste des formats dans la prochaine page
		$this->set('formats', $this->Video->Format->find('list'));
		$this->set('acteurs', $this->Video->Personne->find('list'));
		$this->set('webroot', $this->webroot);

		if($this->request->is('put') || $this->request->is('post')){	// Vrai quand du contenu a été modifié ou ajouté(cf /lib/Cake/Network/CakeRequest.php)
			if($this->saveVideo($this->request->data)){
				$this->Session->setFlash('La vidéo a bien été modifiée.','notif'); 
				$this->redirect(array('action' => 'index'));
				return;
			}
		}elseif($id != null){
			// charge data avec les données de la vidéo dont l'id est passé en paramètre
			$this->Video->id = $id;
			$this->request->data = $this->Video->read();
			$this->request->data['Video']['Acteurs'] = $this->format_textarea($this->request->data['Personne']);
			$this->request->data['Video']['Categories'] = $this->format_textarea($this->request->data['Category']);
		}
		// formatage du tableau pour bien passer dans le typeahead.
		$lstActeurs = array();
		foreach ($this->Personne->find('list') as $k => $v) {
			$lstActeurs[] = '"'.$v.'"' ;
		}

		$lstCategories = array();
		foreach ($this->Category->find('list') as $k => $v) {
			$lstCategories[] = '"'.$v.'"' ;
		}

		$this->request->data['lstActeurs'] = "[".implode(', ',$lstActeurs)."]";
		$this->request->data['lstCategories'] = "[".implode(', ',$lstCategories)."]";
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
}
?>
