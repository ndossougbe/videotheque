<?php
class VideosController extends AppController{
	
	/* Liste des modèles utilisés dans ce contrôleur. Par défaut, le
	 * modèle utilisé est XXX pour XXXsController
	 */
	public $uses = array('Video');
	
		/* Condition de projection*/
		/*$q=$this->Video->find('all',array(
			'fields'=>array('name')
		));
		*/

		/* Condition de sélection: find('all',array(
			'conditions' => array('format' => 1)
		));*/
		//Convention: $d => tableau des variables envoyées à la vue (display)
	
	function index(){
		$d['videos'] = $this->Video->find('all',array('fields' => array('id','name')));
		$this->set($d);
	}
	
	function menu(){
		$videos = $this->Video->find('all',array('fields' => array('id','name')));
		return $videos;
	}
	
	function show($id = null){
		if(!$id)
			throw new NotFoundException('ID nul');
		
		$video = $this->Video->find('first',array('conditions' => array('id' => $id)));
		
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
		// Règles de pagination, définies ici localement. Mettre au début du ctrl pour global.
		// défaut: 20
		$this->paginate = array('Video' => array(
			'limit' => 10	
		));
		$d['videos'] = $this->Paginate('Video');
		$this->set($d);
		$this->set('formats', $this->Video->Format->find('list'));
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
		}
	}
}
?>
