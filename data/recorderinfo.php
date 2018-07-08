<?php
namespace OCA\Recorder\Data;

use OCP\AppFramework\Db\Entity;

class RecorderInfo extends Entity{
	protected $name;
	protected $audio;
	protected $type;


	public function __construct(){
	}
}
?>
