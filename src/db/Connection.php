<?php
declare(strict_types=1);

namespace TaskForce\db;

use mysqli;
/**
 * Class database
 */
class Connection
{
    /**
     * Connection parameters
     */
    const URL = "localhost";
    const USER = "root";
    const PASSWORD = "";
    const DB = "tasks";

    /**
     * Get db connection
     * @return mysqli
     */
    public function getConnection(): mysqli
    {
        $mysqli = new mysqli(self::URL, self::USER, self::PASSWORD, self::DB);
        $mysqli->set_charset("utf8");
        if($mysqli->connect_errno){
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        return $mysqli;
    }

}
