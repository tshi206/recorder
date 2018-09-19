<?php
/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Shawn <syu702@aucklanduni.ac.nz>, Daugieras <adau828@aucklanduni.ac.nz>
 * @copyright Shawn,Daugieras 2017
 */

namespace OCA\Recorder\Controller;

use OCP\IRequest;
use OCP\IConfig;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IUserSession;

use OCA\Recorder\data\recorderinfo;
use OCA\Recorder\data\recorderinfomapper;

class PageController extends Controller {

	private $mapper;
	private $userId;
	private $config;
	private $appName;

	public function __construct($AppName, IRequest $request,recorderinfomapper $mapper, IConfig $config, $UserId){
		parent::__construct($AppName, $request);
		$this->config = $config;
        $this->appName = $AppName;
		$this->userId = $UserId;
		$this->mapper = $mapper;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		$params = ['user' => $this->userId];
        $csp = new ContentSecurityPolicy();
        // Allows to access resources from a specific domain. Use * to allow everything from all domains.
        // Here we allow ALL Javascript, images, styles, and fonts from ALL domains.
        // Here we relax these constraints because we consider some developers might want to use cdn links for their frontend libraries (e.g., bootstrap, etc.)
        $csp->addAllowedScriptDomain("*")->addAllowedImageDomain("*")->addAllowedStyleDomain("*")->addAllowedFontDomain("*");
        $response = new TemplateResponse($this->appName, 'main');
        $response->setContentSecurityPolicy($csp);
		return $response;  // templates/main.php
	}

	public function create($name,$audio, $type) {
		 $recorder = new recorderinfo();
		 $recorder->setName($name);
		 $recorder->setAudio($audio);
		 $recorder->setType($type);
		 return new DataResponse($this->mapper->insert($recorder));
	}
}
