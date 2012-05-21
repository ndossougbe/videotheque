<?php
class AppController extends Controller{

	// fonction exécutée avant les autres (show, menu, etc.)
	function beforeFilter(){
		// request contient un attribut prefix lorsqu'on demande une page préfixée.
		/*if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
			$this->layout = 'admin';
		}*/
	}
}


?>