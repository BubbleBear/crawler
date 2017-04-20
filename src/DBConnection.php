<?php

namespace Vatel;

class DBConnection
{
    private $conn;

    public function __construct($container)
    {
        $ch = $container['ConfigHandler'];
        $this->boot($ch->getDsn());
    }

    public function boot($dsn, $username = null, $password = null, array $options = array())
    {
        $this->conn = new \PDO($dsn, $username, $password, $options);
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function exec($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}
