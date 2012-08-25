<?php
class AppController extends Controller{

  var $components = array(
    'RequestHandler'
    , 'Session'
    , 'Auth' => array(
        'loginRedirect' => array('controller' => 'videos', 'action' => 'index', 'admin'=> true)
      , 'logoutRedirect' => array('controller' => 'videos', 'action' => 'index', 'admin'=> false)
      , 'authorize' => 'Controller' /* Autorisation via la méthode isAuthorized */
      ));

  // fonction exécutée avant les autres (show, menu, etc.)

  function beforeFilter() {  
    $this->log("AppController::beforeFilter");
    //allow all non-logged in users access to items without a prefix 
    if( !isset($this->params['prefix'])) $this->Auth->allow('*'); 

    // Pas de layout sur les appels en ajax.
    if($this->RequestHandler->isAjax()){
      $this->autoRender = false;
      $this->layout = null;
    }
  }  

  function isAuthorized($user) {  
    $this->log("page:/".$this->request->params['controller']."/".$this->request->params['action']." admin:".$this->request->params['admin']);

    // Any registered user can access public functions
    if (empty($this->request->params['admin'])) {
      $this->log("Autorisé page non admin");
      return true;
    }

    // Only admins can access admin functions
    if (isset($this->request->params['admin'])) {
      $this->log("page admin. Rôle utilisateur: ".$user['role']);

      return (bool)($user['role'] === 'admin');
    }

    $this->log("Non autorisé");

    // Default deny
    return false;


    //if the prefix is setup, make sure the prefix matches their role 
    // if( isset($this->params['prefix'])) 
    //   return (strcasecmp($this->params['prefix'],$this->Auth->user('role'))===0); 
    
    // //shouldn't get here, better be safe than sorry 
    // return false;  
  }  

}


?>