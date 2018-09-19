<?php
/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author A.Daugieras <adau828@aucklanduni.ac.nz>, Mason Shi <tshi206@aucklanduni.ac.nz>
 * @copyright Daugieras,Mason 2018
 */

namespace OCA\Recorder\Controller;

use DateTime;
use OC;
use OCA\Recorder\Db\Recording;
use OCA\Recorder\Db\RecordingMapper;
use OCA\Recorder\Db\CityMapper; // OCA\recorder\lib\Db\CityMapper is not valid, don't put lib in!!!!!!!!! use Recorder (capitalized first letter) NOT recorder!!!!!!!!!!!!!!!!!!!!
use OCA\Recorder\Db\SuburbMapper;
use OCP\AppFramework\Http\ContentSecurityPolicy;
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

    private $suburbMapper;
    private $cityMapper;
    private $mapper;

    private $logger;

	private $config;
	private $userId;
	private $l10n;

	public function __construct(SuburbMapper $suburbMapper, CityMapper $cityMapper, RecordingMapper $mapper, ILogger $logger, $AppName, IRequest $request,IConfig $config, IL10N $l10n, $UserId){
		parent::__construct($AppName, $request);
		$this->suburbMapper = $suburbMapper;
		$this->cityMapper = $cityMapper;
		$this->mapper = $mapper;
		$this->logger = $logger;
		$this->userId = $UserId;
		$this->config = $config;
		$this->l10n = $l10n;
	}

    public function log($message) {
        $this->logger->emergency($message, ['app' => $this->appName]);
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
		$csp = new ContentSecurityPolicy();
		$csp->addAllowedConnectDomain("*")->addAllowedScriptDomain("*")->addAllowedImageDomain("*")->addAllowedStyleDomain("*")->addAllowedFontDomain("*");
		$response = new TemplateResponse('recorder', 'main', $params);
		$response->setContentSecurityPolicy($csp);
        return $response;
		//return new TemplateResponse('recorder', 'main', $params);
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
     * Create a wav and a txt file with data
     * @NoAdminRequired
     * @NoCSRFRequired
     * @param $path
     * @param $content , textual data
     * @param $blob , base 64 data
     * @param $geoInfo , array of geo data
     * @param $type , string representing recording type
     * @param $city
     * @param $suburb
     * @return DataResponse
     * @throws \OCP\Files\NotPermittedException
     */
	public function createTxt($path, $content, $blob, $geoInfo, $type, $city, $suburb){
	    $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : Base 64 string received => ".substr($blob, 0, 100)."......");
        $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : GEO INFO received => START reading array");
        foreach ($geoInfo as $key => $value) {
            $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : GEO INFO Array :: $key => $value");
        }
        $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : GEO INFO received => END of array");
        $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : RECORDING TYPE received => $type");
        $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : TRYING TO GET TABLE NAME => ".$this->mapper->getTableName());
        $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : SELECTED CITY NAME => ".$city);
        $this->log("DEBUGGING IN recorder\settingscontroller->createTxt : SELECTED SUBURB NAME => ".$suburb);

        /** @noinspection PhpUndefinedClassInspection */
        $folder = OC::$server->getUserFolder('Frenchalexia');

        // create wav
	    $newWav = $folder->newFile(explode('.', $path)[0].".wav");
        $this->base64_to_wav($blob, "/var/www/p4/owncloud/data/".$newWav->getPath()); // prefix by owncloud data path, see oc_storage table

        // create txt
		$newfile = $folder->newFile($path);
		$newfile->putContent($content);

		$recording = new Recording();
		$recording->filename = $newWav->getName();
		$recording->owner = $newWav->getOwner()->getUID();
		$recording->uploader = $this->userId;
		$recording->internalPath = $newWav->getInternalPath();
		$recording->path = $newWav->getPath();
		$recording->recordingType = $type;
		$recording->uploadTime = $this->getNowInSec();
		$recording->city = $geoInfo['city'];
		$recording->region = $geoInfo['region'] ? $geoInfo['region'] : "N/A";
		$recording->regionName = $geoInfo['regionName'] ? $geoInfo['regionName'] : "N/A";
		$recording->country = $geoInfo['country'] ? $geoInfo['country'] : $geoInfo['country']['name'];
		$recording->countryCode = $geoInfo['countryCode'] ? $geoInfo['countryCode'] : $geoInfo['country']['code'];
		$recording->timezone = $geoInfo['timezone'] ? $geoInfo['timezone'] : $geoInfo['location']['time_zone'];
		$recording->zip = $geoInfo['zip'] ? $geoInfo['zip'] : "N/A";
		$recording->latitude = $geoInfo['lat'] ? $geoInfo['lat'] : $geoInfo['location']['latitude'];
		$recording->longitude = $geoInfo['lon'] ? $geoInfo['lon'] : $geoInfo['location']['longitude'];
		$recording->content = $content;
        $recording->isStandalone = false;
        $recording->isRepresentative = false;
        // cityName, suburbName
        $recording->cityName = $city;
        $recording->suburbName = $suburb;

		return new DataResponse($this->mapper->create($recording));
	}

    /**
     * @param $base64_string
     * @param $output_file
     * @return mixed
     */
    private function base64_to_wav($base64_string, $output_file) {

        $this->log("DEBUGGING IN recorder\settingscontroller->base64_to_wav : attempt to decode base64 string and write it to $output_file");

        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:audio/wav;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }

    /**
     * PHP support date time up to microseconds and mysql support DATETIME(3) which preserve up to milliseconds precision.
     * However, owncloud DOES NOT support neither of those, it only supports the traditional DATETIME in its schema definition xml file and DATETIME only holds the precision up to seconds.
     * @return bool|string
     */
    private function getNowInSec(){
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        $d_str = $d->format("Y-m-d H:i:s.u");
        $d_milli = substr($d_str, 0, strlen($d_str) - 7);
        return $d_milli;
    }

    /**
     * get all cities
     */
    public function getCityList(){
        return new DataResponse($this->cityMapper->findAllCities());
    }

    /**
     * get suburbs by city
     * @param $city
     * @return DataResponse
     */
    public function getSuburbList($city){
        return new DataResponse($this->suburbMapper->findSuburbsByCity($city));
    }
}
