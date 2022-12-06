<?php

/**
 * Database
 * Connects to the database.
 */

trait Database
{
    private ?PDO $db = null;

    /**
     * Query the database.
     * @param string $query
     * @param array $data
     * @return array | bool
     */
    public function query(string $query, array $data = []): bool|array
    {
        try {
            $statement = $this->prepare($query);
            $statement->execute($data);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Prepare a query.
     * @param string $query
     * @return PDOStatement
     */
    private function prepare(string $query): PDOStatement
    {
        try {
            if ($this->db == null) {
                $this->connect();
            }
            return $this->db->prepare($query);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Connect to the database.
     */
    private function connect(): void
    {
        try {
            $connection_string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
            $this->db = new PDO($connection_string, DBUSER, DBPASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}