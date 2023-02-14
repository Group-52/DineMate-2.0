<?php

namespace core;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Database
 * Connects to the database.
 */
trait Database
{
    protected string $query = "";
    protected array $data = [];
    private ?PDO $db = null;

    /**
     * Fetch all rows from the query.
     */
    public function fetchAll(): array
    {
        return $this->execute()->fetchAll();
    }

    /**
     * Execute the query.
     * @return PDOStatement
     */
    public function execute(): PDOStatement
    {
        try {
            $statement = $this->prepare($this->query);
            $statement->execute($this->data);
            $this->query = "";
            $this->data = [];
            return $statement;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Prepare a query.
     * @param string $query
     * @return PDOStatement
     */
    protected function prepare(string $query): PDOStatement
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
            $connection_string = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $this->db = new PDO($connection_string, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Fetch a single row from the query.
     */
    public function fetch(): object|false
    {
        return $this->execute()->fetch();
    }

    /**
     * Get database query (for debugging)
     */
    public function getQuery(): string
    {
        return $this->query;
    }

}