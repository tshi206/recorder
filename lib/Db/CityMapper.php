<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 7/13/18
 * Time: 6:25 PM
 */

namespace OCA\Recorder\Db; // Recorder NOT recorder!!!!!!!!!!!!!!!!


use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;
use OCP\ILogger;
use PDO;

class CityMapper extends Mapper
{
    private $logger;
    private $appName;

    public function __construct(ILogger $logger, $AppName, IDBConnection $db)
    {
        parent::__construct($db, "city_coords", null);
        $this->logger = $logger;
        $this->appName = $AppName;
    }

    public function log($message) {
        $this->logger->error($message, ['app' => $this->appName]);
    }

    /**
     * @return array
     */
    public function findAllCities(){
        $sql =  "SELECT DISTINCT city_name FROM oc_city_coords order by city_name";
        $result = $this->execute($sql);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $cities = [];
        foreach ($rows as $row) {
            $cities[] = $row['city_name'];
        }
        $this->log("cities length => ".count($cities));
        return $cities;
    }

}