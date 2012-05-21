<?php
class MediasController extends AppController{

	public $uses = array('Video','Media');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->layout = 'modal';
	}

	public function admin_index($id_video = null){
		if($id_video){
			$cover_dir = 'covers';
			if($this->request->is('post')){
				$data = $this->request->data['Media'];

				if(isset($data['url'])){
					$this->redirect(array(
						'action' => 'show',
						'?alt=&url='.urlencode($data['url'])
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

				// Sauvegarde en bdd
				$success = $this->Media->save(array(
					'name'	=> $data['name'],
					'url'	=> $cover_dir.'/'.$filename.$ext,
				));

				if($success){
					move_uploaded_file($data['file']['tmp_name'], $dir.DS.$filename.$ext );

					// Mise à jour de la vidéo avec la nouvelle image.			
					$this->Video->read(null,$id_video);	// charge tous les champs (fields == null) de la vidéo d'id $id_video
					$this->Video->set('media_id', $this->Media->id);	// modif d'un champ
					$this->Video->save(); // commit.

				}else{
					$this->Session->setFlash("L'image n'est pas au bon format",'notif',array('type' => 'error'));
				}

			}

			// Charge l'image de la vidéo dont l'id est passé en paramètre
			$video = $this->Video->find('first',array('conditions' => array('Video.id' => $id_video)));
			$d['medias'][0]['Media'] = $video['Media'];
			$this->set($d);
		}
		else{
			// Affiche toutes les images.
			$d['medias'] = $this->Media->find('all');
			$this->set($d);	
		}
		
	}

	function admin_show($id = null){
		$d = array();
		if($this->request->is('post')){
			$this->set($this->request->data['Media']);
			$this->layout = false;	// layout désactivé sur la prochaine fenêtre.
			$this->render('popup');
			return;
		}
		if($id && is_numeric($id)){
			$this->Media->id = $id;
			$media = current($this->Media->read());	// charge le média d'id $this->Media->id
			$d['url'] = Router::url('/img/'.$media['url']);
			$d['alt'] = $media['name'];
		}
		else{
			$d = $this->request->query;
			$d['url'] = urldecode($d['url']);

		}
		$this->set($d);

	}

	public function admin_delete($id){
		$this->Media->id = $id;					// charge l'objet d'id $id
		$file = $this->Media->field('url');	
		unlink(IMAGES.DS.$file);				// suppression de l'image
		$this->Media->delete($id);				// suppression dans la table.
		$this->Session->setFlash("L'image a bien été supprimée",'notif');
		$this->redirect($this->referer());
	}
	
}

?>