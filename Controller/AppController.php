<?php
class AppController extends Controller{

	var $components = array('RequestHandler');

	// fonction exécutée avant les autres (show, menu, etc.)
	function beforeFilter(){
		// request contient un attribut prefix lorsqu'on demande une page préfixée.
		/*if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
			$this->layout = 'admin';
		}*/

		// Pas de layout sur les appels en ajax.
		if($this->RequestHandler->isAjax()){

			$this->layout = null;
		}
	}
}


?>