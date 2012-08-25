<?php

class User extends AppModel {

public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Un nom d\'utilisateur est requis'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Un mot de passe est requis'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'visiteur')),
                'message' => 'Entrez un rôle valide.',
                'allowEmpty' => false
            )
        )
    );


public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
}
	
}

?>