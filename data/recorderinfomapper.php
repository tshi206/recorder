<?php

namespace OCA\Recorder\Data;

use OCP\IDBConnection;
use OCP\AppFramework\Db\Mapper;

class RecorderInfoMapper extends Mapper {
    public function __construct(IDBConnection $db){
    	parent::__construct($db,'recorder','\OCA\Recorder\Data\recorderinfo');
    }

    public function find($id){
    	$sql = 'SELECT * FROM *PREFIX*recorder '.
      	'WHERE id = ?';
    	return $this->findEntity($sql, [$id]);
    }
    
    public function findAll($limit=null, $offset=null){
    	$sql = 'SELECT * FROM *PREFIX*recorder';
    	return $this->findEntities($sql, $limit, $offset);
    }

    public function save($name,$type,$audio) {
		$query = $this->db->prepareQuery( 'INSERT INTO `*PREFIX*recorder`'
			.' ( `name`, `type`, `audio` ) VALUES( ?, ?, ? )' );
		
		return $query->execute(array( $name, $type, $audio));
	}
}

?>
