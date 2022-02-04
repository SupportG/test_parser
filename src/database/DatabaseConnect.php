<?php
namespace App\database;

use PDO;

class DatabaseConnect
{
    private $host;
    private $dbName;
    private $user;
    private $pass;

    /**
     * @param String $host
     * @param String $dbName
     * @param String $user
     * @param String $pass
     * @return void
     */

    function __construct($host, $dbName, $user, $pass)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->pass = $pass;
    }

    function pdoConnect()
    {
        $dbh = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->user, $this->pass);
        return $dbh;
    }
}
