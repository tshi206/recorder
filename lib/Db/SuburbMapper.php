<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 7/13/18
 * Time: 6:38 PM
 */

namespace OCA\Recorder\Db; // Recorder NOT recorder!!!!!!!!!!!!!!!!


use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;
use OCP\ILogger;
use PDO;

class SuburbMapper extends Mapper
{
    private $logger;
    private $appName;

    public function __construct(ILogger $logger, $AppName, IDBConnection $db)
    {
        parent::__construct($db, "suburb_city_coords", null);
        $this->logger = $logger;
        $this->appName = $AppName;
    }

    public function log($message) {
        $this->logger->error($message, ['app' => $this->appName]);
    }

    /**
     * @param $city
     * @return array
     */
    public function findSuburbsByCity($city) {
        $sql =  "SELECT DISTINCT suburb_name FROM oc_suburb_city_coords where city_name = ? order by suburb_name";
        $result = $this->execute($sql, [$city]);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $suburbs = [];
        foreach ($rows as $row) {
            $suburbs[] = $row['suburb_name'];
        }
        return $suburbs;
    }

}