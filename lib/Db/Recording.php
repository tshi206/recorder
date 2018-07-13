<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 7/11/18
 * Time: 3:33 PM
 */

namespace OCA\Recorder\Db;


use OCP\AppFramework\Db\Entity;

class Recording extends Entity implements \JsonSerializable
{

    public $filename;
    public $owner;
    public $uploader;
    public $internalPath;
    public $path;
    public $recordingType;
    public $uploadTime;
    public $city;
    public $region;
    public $regionName;
    public $country;
    public $countryCode;
    public $timezone;
    public $zip;
    public $latitude;
    public $longitude;
    public $content;
    public $isAddedToMap;
    public $cityName;
    public $cityLon;
    public $cityLat;
    public $suburbName;
    public $suburbLon;
    public $suburbLat;

    public function __construct() {
        // add types in constructor
        $this->addType('zip', 'integer');
        $this->addType('internalPath', 'string');
        $this->addType('path', 'string');
        $this->addType('content', 'string');
    }

    // map attribute (e.g., phoneNumber) to the database column (e.g., phonenumber)
    public function columnToProperty($column) {
        switch ($column){
            case "filename":
                return 'filename';
            case "owner":
                return 'owner';
            case "uploader":
                return 'uploader';
            case "internal_path":
                return "internalPath";
            case "path":
                return "path";
            case "recording_type":
                return "recordingType";
            case "upload_time":
                return "uploadTime";
            case "city":
                return "city";
            case "region":
                return "region";
            case "region_name":
                return "regionName";
            case "country":
                return "country";
            case "country_code":
                return "countryCode";
            case "timezone":
                return "timezone";
            case "latitude":
                return "latitude";
            case "longitude":
                return "longitude";
            case "content":
                return "content";
            case "is_added_to_map":
                return 'isAddedToMap';
            case "city_name":
                return 'cityName';
            case "city_lon":
                return 'cityLon';
            case "city_lat":
                return 'cityLat';
            case "suburb_name":
                return 'suburbName';
            case "suburb_lon":
                return 'suburbLon';
            case "suburb_lat":
                return 'suburbLat';
            default:
                return parent::columnToProperty($column);
        }
    }

    public function propertyToColumn($property) {
        switch ($property){
            case "filename":
                return 'filename';
            case "owner":
                return 'owner';
            case "uploader":
                return 'uploader';
            case "internalPath":
                return "internal_path";
            case "path":
                return "path";
            case "recordingType":
                return "recording_type";
            case "uploadTime":
                return "upload_time";
            case "city":
                return "city";
            case "region":
                return "region";
            case "regionName":
                return "region_name";
            case "country":
                return "country";
            case "countryCode":
                return "country_code";
            case "timezone":
                return "timezone";
            case "latitude":
                return "latitude";
            case "longitude":
                return "longitude";
            case "content":
                return "content";
            case "isAddedToMap":
                return 'is_added_to_map';
            case "cityName":
                return 'city_name';
            case "cityLon":
                return 'city_lon';
            case "cityLat":
                return 'city_lat';
            case "suburbName":
                return 'suburb_name';
            case "suburbLon":
                return 'suburb_lon';
            case "suburbLat":
                return 'suburb_lat';
            default:
                return parent::propertyToColumn($property);
        }
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'content' => $this->content,
            'recordingType' => $this->recordingType,
            'coordinates' => [$this->latitude, $this->longitude],
            'region' => $this->region,
            'city' => $this->city,
            'country' => $this->country,
            'uploadTime' => $this->uploadTime
        ];
    }
}