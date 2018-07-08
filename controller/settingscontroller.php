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

use OC;
use OCP\ILogger;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IL10N;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
//use OCP\Files\Folder;
//use OCP\Files\IRootFolder;
//use OCP\Files\Node;
use OCP\PreConditionNotMetException;

class SettingsController extends Controller {

    private $logger;

	private $config;
	private $userId;
	private $l10n;

	public function __construct(ILogger $logger, $AppName, IRequest $request,IConfig $config, IL10N $l10n, $UserId){
		parent::__construct($AppName, $request);
		$this->logger = $logger;
		$this->userId = $UserId;
		$this->config = $config;
		$this->l10n = $l10n;
	}

    public function log($message) {
        $this->logger->error($message, ['app' => $this->appName]);
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
            try {
                return $this->config->setUserValue($this->userId, $this->appName, $key, $value);
            } catch (PreConditionNotMetException $e) {
                $this->log($e->getMessage());
                return $e->getMessage();
            }
        }
	}

    /**
     * Simply method that set the user value by key
     * @NoAdminRequired
     * @NoCSRFRequired
     * @param $name
     * @param $audio
     * @param $type
     * @return TemplateResponse
     */
	public function setRecorder($name, $audio, $type) {
		$this->updateItem('name', $name);
		$this->updateItem('audio', $audio);
		$this->updateItem('type', $type);
		return $this->getUserValue();  // templates/main.php
	}

    /**
     * Simply method that create a txt file with data
     * @NoAdminRequired
     * @NoCSRFRequired
     * @param $path
     * @param $content
     * @return DataResponse
     * @throws \OCP\Files\NotPermittedException
     */
	public function createTxt($path, $content){
        /** @noinspection PhpUndefinedClassInspection */
        $folder = OC::$server->getUserFolder('Frenchalexia');

		$newfile = $folder->newFile($path);
		$newfile->putContent($content);
	
		return new DataResponse();
	}
}
