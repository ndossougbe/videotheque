<?php

class Note extends AppModel {
    var $name = 'Note';
    var $primaryKey = '_id';
    var $useDbConfig = 'mongo';
    var $useTable = false;
 
    function schema() {
        $this->_schema = array(
            '_id' => array('type' => 'integer', 'primary' => true, 'length' => 40),
            'title' => array('type' => 'string'),
            'body' => array('type' => 'text'),
            'numbered' => array('type' => 'integer'),
        );
        return $this->_schema;
    }
}
?>