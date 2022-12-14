<?php

/**
 * Base Model Trait
 */

class Model
{
    use Database;

    protected string $table = "";
    protected string $primary_key = "";
    protected array $columns = [];
    protected int $limit = 10;
    protected int $offset = 0;
    protected string $order_by = "";
    protected string $order = "";
    public array $errors = [];

    /**
     * Get all records.
     * @return bool|array
     */
    public function findAll(): false|array
    {
        try {
            $query = $this->query("SELECT * FROM $this->table LIMIT $this->limit OFFSET $this->offset");
            if ($this->order_by && $this->order) {
                $query .= " ORDER BY $this->order_by $this->order";
            }
            return $query;
        } catch (Exception $e) {
            $this->errors[] = "Unknown error.";
        }
        return false;
    }

    /**
     * Get a record by its primary key.
     * @param int $id
     * @return array | false
     */
    public function find(int $id): false|array
    {
        try {
            return $this->query("SELECT * FROM $this->table WHERE $this->primary_key = ?", [$id]);
        } catch (Exception) {
            $this->errors[] = "Unknown error.";
        }
        return false;
    }

    /**
     * Get a record by multiple columns.
     * @param array $data
     * @param array $data_not
     * @return false|array
     */
    public function findBy(array $data, array $data_not = []): false|array
    {
        try {

            $query = "SELECT * FROM $this->table WHERE ";
            $params = [];


            foreach ($data as $key => $value) {
                if (!in_array($key, $this->columns)) {
                    unset($data[$key]);
                } else {
                    $query .= "$key = ? AND ";
                    $params[] = $value;
                }
            }

            foreach ($data_not as $key => $value) {
                if (!in_array($key, $this->columns)) {
                    unset($data[$key]);
                } else {
                    $query .= "$key != ? AND ";
                    $params[] = $value;
                }
            }

            $query = rtrim($query, "AND ");
            $query .= " LIMIT $this->limit OFFSET $this->offset";

            return $this->query($query, $params);

        } catch (Exception) {

            $this->errors[] = "Unknown error.";

        }
        return false;
    }

    /**
     * Get a record by multiple columns with LIKE.
     * @param array $data
     * @return false|array
     */
    public function findLike(array $data): false|array
    {
        try {

            $query = "SELECT * FROM $this->table WHERE ";
            $params = [];

            foreach ($data as $key => $value) {
                if (!in_array($key, $this->columns)) {
                    unset($data[$key]);
                } else {
                    $query .= "$key LIKE ? OR ";
                    $params[] = "%$value%";
                }
            }

            $query = rtrim($query, "OR ");
            $query .= " LIMIT $this->limit OFFSET $this->offset";

            return $this->query($query, $params);

        } catch (Exception) {
            $this->errors[] = "Unknown error.";

        }
        return false;
    }


    /**
     * Get a record by multiple columns with LIKE for a category
     * @param array $like_data
     * @param array $where_data
     * @return false|array
     */
    public function findLikeWhere(array $like_data, array $where_data): false|array
    {
        try {

            $query = "SELECT * FROM $this->table WHERE ";
            $params = [];

            foreach ($like_data as $key => $value) {
                if (!in_array($key, $this->columns)) {
                    unset($like_data[$key]);
                } else {
                    $query .= "$key LIKE ? OR ";
                    $params[] = "%$value%";
                }
            }
            $query = rtrim($query, "OR ");
            foreach ($where_data as $key => $value) {
                if (!in_array($key, $this->columns)) {
                    unset($where_data[$key]);
                } else {
                    $query .= "$key = ? AND ";
                    $params[] = $value;
                }
            }
            $query = rtrim($query, "AND ");

            $query .= " LIMIT $this->limit OFFSET $this->offset";

            return $this->query($query, $params);

        } catch (Exception) {
            $this->errors[] = "Unknown error.";

        }
        return false;
    }

    /**
     * Insert a record.
     * @param array $data
     * @return array|bool
     */
    public function insert(array $data): bool|array
    {
        $query = "INSERT INTO $this->table (";
        $params = [];

        foreach ($data as $key => $value) {
            if (!in_array($key, $this->columns)) {
                unset($data[$key]);
            } else {
                $query .= "$key, ";
                $params[] = $value;
            }
        }

        $query = rtrim($query, ", ");
        $query .= ") VALUES (";

        foreach ($data as $key => $value) {
            $query .= "?, ";
        }

        $query = rtrim($query, ", ");
        $query .= ")";

        return $this->query($query, $params);
    }

    /**
     * Update a record by its primary key.
     * @param int $id
     * @param array $data
     * @return array|bool
     */
    public function update(int $id, array $data): bool|array
    {
        $params = [];

        $set = "";
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->columns)) {
                unset($data[$key]);
            } else {
                $set .= "$key = ?, ";
                $params[] = $value;
            }
        }

        $set = rtrim($set, ", ");

        $query = "UPDATE $this->table SET $set WHERE $this->primary_key = ?";
        $params[] = $id;

        return $this->query($query, $params);
    }

    /**
     * Delete a record by its primary key.
     * @param int $id
     * @return array|bool
     */
    public function delete(int $id): bool|array
    {
        return $this->query("DELETE FROM $this->table WHERE $this->primary_key = ?", [$id]);
    }

}