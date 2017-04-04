<?php
/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author A.Daugieras <adau828@aucklanduni.ac.nz>
 * @copyright Daugieras 2017
 */

namespace OCA\Recorder\Controller;

use OCP\IRequest;
use OCP\IConfig;
use OCP\IL10N;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;

class SettingsController extends Controller {

	private $config;
	private $userId;
	private $l10n;

	public function __construct($AppName, IRequest $request,IConfig $config, IL10N $l10n, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
		$this->config = $config;
		$this->l10n = $l10n;
	}

	/**
	 * Simply method that get the user value by key
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function getUserValue() {		
		$params = ['name' => $this->getItem('name'),
			'audio' => $this->getItem('audio'),
			'type' => $this->getItem('type'),
			'user' => $this->userId];
		return new TemplateResponse('recorder', 'main', $params);
	}

	protected function getItem($key){
                return $this->config->getUserValue($this->userId, $this->appName, $key);
        }
	
	protected function updateItem($key, $value){
		if ( ( $value==='' ) || ( $value === NULL ) ){
			return $this->config->deleteUserValue($this->userId, $this->appName, $key);
		}else{
			return $this->config->setUserValue($this->userId, $this->appName, $key, $value);
		}
	}

	/**
	 * Simply method that set the user value by key
	 * @NoAdminRequired
     * @NoCSRFRequired
	 */
	public function setRecorder($name, $audio, $type) {
		$this->updateItem('name', $name);
		$this->updateItem('audio', $audio);
		$this->updateItem('type', $type);
		return $this->getUserValue();  // templates/main.php
	}
}
