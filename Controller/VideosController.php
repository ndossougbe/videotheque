<?php
class VideosController extends AppController{
	
	/* Liste des modèles utilisés dans ce contrôleur. Par défaut, le
	 * modèle utilisé est XXX pour XXXsController
	 */
	public $uses = array('Video','Personne');
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

	private function format_textarea($array){
		$ret = array();
		foreach ($array as $k => $v) {
			if(gettype($v) == 'array'){
				$ret[] = $v['name'];	
			}
			else{
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

	function admin_delete($id){
		// Message de notifications. Utilise le template View/Elements/notif.ctp
		$this->Session->setFlash('La vidéo a bien été supprimée. (!Commentée!)','notif'); 
		//$this->Video->delete($id);
		$this->redirect($this->referer()); // redirige sur la page appelante.
	}

	function admin_edit($id = null){
		// Pour charger la liste des formats dans la prochaine page
		$this->set('formats', $this->Video->Format->find('list'));
		$this->set('acteurs', $this->Video->Acteurs->find('list'));
		$this->set('webroot', $this->webroot);

		if($this->request->is('put') || $this->request->is('post')){	// Vrai quand du contenu a été modifié ou ajouté(cf /lib/Cake/Network/CakeRequest.php)
			if($this->Video->save($this->request->data)){
				$this->Session->setFlash('La vidéo a bien été modifiée.','notif'); 
				$this->redirect(array('action' => 'index'));
			}
		}elseif($id != null){
			// charge data avec les données de la vidéo dont l'id est passé en paramètre
			$this->Video->id = $id;
			$this->request->data = $this->Video->read();
			$this->request->data['Video']['Acteurs'] = $this->format_textarea($this->request->data['Acteurs']);

			// formatage du tableau pour bien passer dans le typeahead.
			$ret = array();
			foreach ($this->Personne->find('list') as $k => $v) {
				$ret[] = '"'.$v.'"' ;
			}

			$this->request->data['test'] = array("un","deux","trois");
			$this->request->data['lstActeurs'] = "[".implode(', ',$ret)."]";
		}
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

	public function truc(){
		$this->layout = false;	// layout désactivé sur la prochaine fenêtre.
	}
}
?>
