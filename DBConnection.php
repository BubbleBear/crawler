<?php

class Dao
{
    private $conn;

    public function __construct($dsn, $username = null, $password = null, array $options = array())
    {
        $this->conn = new \PDO($dsn, $username, $password, $options);
    }
}
