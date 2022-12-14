<?php

/**
 * Database
 * Connects to the database.
 */

trait Database
{
    private ?PDO $db = null;
    protected string $query;
    protected array $data = [];

    /**
     * Execute the query.
     * @return PDOStatement
     */
    public function execute(): PDOStatement
    {
        try {
            $statement = $this->prepare($this->query);
            $statement->execute($this->data);
            return $statement;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Fetch all rows from the query.
     */
    public function fetchAll(): array
    {
        return $this->execute()->fetchAll();
    }

    /**
     * Fetch a single row from the query.
     */
    public function fetch(): array
    {
        return $this->execute()->fetch();
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