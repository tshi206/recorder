<?php /** @noinspection SqlResolve */

/**
 * Created by PhpStorm.
 * User: mason
 * Date: 7/11/18
 * Time: 3:58 PM
 */

namespace OCA\Recorder\Db;


use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;
use OCP\ILogger;
use PDO;

class RecordingMapper extends Mapper
{

    private $logger;
    private $appName;

    public function __construct(ILogger $logger, $AppName, IDBConnection $db)
    {
        parent::__construct($db, "recorder_recordings", "\OCA\Recorder\Db\Recording");
        $this->logger = $logger;
        $this->appName = $AppName;
    }

    public function log($message) {
        $this->logger->error($message, ['app' => $this->appName]);
    }

    /**
     * @param Recording $entity
     * @return Recording
     */
    public function create(Recording $entity)
    {

        $filename = $entity->filename;
        $owner = $entity->owner;
        $uploader = $entity->uploader;
        $internal_path = $entity->internalPath;
        $path = $entity->path;
        $recording_type = $entity->recordingType;
        $upload_time = $entity->uploadTime;
        $city = $entity->city;
        $region = $entity->region;
        $region_name = $entity->regionName;
        $country = $entity->country;
        $country_code = $entity->countryCode;
        $timezone = $entity->timezone;
        $zip = $entity->zip;
        $latitude = $entity->latitude;
        $longitude = $entity->longitude;
        $content = $entity->content;
        $isAddedToMap = $entity->isAddedToMap;
        $userSelectedCity = $entity->cityName;
        $userSelectedSuburb = $entity->suburbName;

        // get city_lon, city_lat, suburb_lon, and suburb_lat
        $sql_get_city_lon_lat = 'SELECT city_lon, city_lat FROM oc_city_coords where city_name = ?';
        $result = $this->execute($sql_get_city_lon_lat, [$userSelectedCity]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $city_lon = $row['city_lon'];
        $city_lat = $row['city_lat'];
        $sql_get_suburb_lon_lat = 'SELECT suburb_lon, suburb_lat FROM oc_suburb_city_coords where suburb_name = ?';
        $result = $this->execute($sql_get_suburb_lon_lat, [$userSelectedSuburb]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $suburb_lon = $row['suburb_lon'];
        $suburb_lat = $row['suburb_lat'];

        $this->log("DEBUGGING IN RecordingMapper->create : PRE SAVED LAT => $latitude}");
        $this->log("DEBUGGING IN RecordingMapper->create : PRE SAVED LON => $longitude}");

        $sql = 'INSERT INTO `*PREFIX*recorder_recordings` (filename, owner, uploader, internal_path, path, recording_type, upload_time, city, region, region_name, country, country_code, timezone, zip, latitude, longitude, content, is_added_to_map, city_name, city_lon, city_lat, suburb_name, suburb_lon, suburb_lat) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
		)';

        $this->execute($sql, [$filename, $owner, $uploader, $internal_path, $path, $recording_type, $upload_time, $city, $region, $region_name, $country, $country_code, $timezone, $zip, $latitude, $longitude, $content, $isAddedToMap, $userSelectedCity, $city_lon, $city_lat, $userSelectedSuburb, $suburb_lon, $suburb_lat]);

        $sql1 = 'SELECT * From `*PREFIX*recorder_recordings` where upload_time = ? AND uploader = ?';

        $result = $this->execute($sql1, [$upload_time, $uploader]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            $this->log("DEBUGGING IN RecordingMapper->create : FAIL TO RETRIEVE SAVED RECORDING!!!!!!!}");
        }
        if (count($row) === 0) {
            $this->log("DEBUGGING IN RecordingMapper->create : FIND ZERO (0) RESULTS FOR SAVED RECORDING!!!!!!!}");
        }

        $savedRecording = new Recording();
        $savedRecording->id = $row['id'];
        $savedRecording->filename = $row['filename'];
        $savedRecording->owner = $row['owner'];
        $savedRecording->uploader = $row['uploader'];
        $savedRecording->internalPath = $row['internal_path'];
        $savedRecording->path = $row['path'];
        $savedRecording->recordingType = $row['recording_type'];
        $savedRecording->uploadTime = $row['upload_time'];
        $savedRecording->city = $row['city'];
        $savedRecording->region = $row['region'];
        $savedRecording->regionName = $row['region_name'];
        $savedRecording->country = $row['country'];
        $savedRecording->countryCode = $row['country_code'];
        $savedRecording->timezone = $row['timezone'];
        $savedRecording->zip = $row['zip'];
        $savedRecording->latitude = $row['latitude'];
        $savedRecording->longitude = $row['longitude'];
        $savedRecording->content = $row['content'];
        $savedRecording->isAddedToMap = $row['is_added_to_map'];
        $savedRecording->cityName = $row['city_name'];
        $savedRecording->cityLon = $row['city_lon'];
        $savedRecording->cityLat = $row['city_lat'];
        $savedRecording->suburbName = $row['suburb_name'];
        $savedRecording->suburbLon = $row['suburb_lon'];
        $savedRecording->suburbLat = $row['suburb_lat'];

        $this->log("DEBUGGING IN NoteMapper->create : SAVED Recording {
			id => $savedRecording->id;
			filename => $savedRecording->filename;
			content => $savedRecording->content;
			latitude => $savedRecording->latitude;
			longitude => $savedRecording->longitude;
			isAddedToMap => $savedRecording->isAddedToMap;
		}");

        return $savedRecording;
    }

}