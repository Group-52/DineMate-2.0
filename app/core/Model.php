<?php

/**
 * Base Model Trait
 */

class Model
{
    use Database;

    protected string $table = "";
    protected array $columns = [];
    protected array $errors = [];

    /**
     * Select rows from table
     * @param array|string $columns
     * @return Model
     */
    public function select(array|string $columns): Model
    {
        $column_list = "*";
        if (is_array($columns)) {
            $column_list = implode(", ", $columns);
        } else if (is_string($columns)) {
            $column_list = $columns;
        }
        $this->query = "SELECT $column_list FROM $this->table";
        return $this;
    }

    /**
     * Insert a row into table
     * @param array $data
     * @return Model
     */
    public function insert(array $data): Model
    {
        $column_list = implode(", ", array_keys($data));
        $value_list = "";
        foreach ($data as $ignored) {
            $value_list .= "?, ";
        }
        $value_list = rtrim($value_list, ", ");
        $this->query = "INSERT INTO $this->table $column_list VALUES $value_list";
        $this->data[] = array_values($data);
        return $this;
    }

    /**
     * Update a row in table
     * @param array $data
     * @return Model
     */
    public function update(array $data): Model
    {
        $column_list = "";
        foreach (array_keys($data) as $column) {
            $column_list .= "$column = ?, ";
        }
        $column_list = rtrim($column_list, ", ");
        $this->query = "UPDATE $this->table SET $column_list";
        $this->data[] = array_values($data);
        return $this;
    }

    /**
     * Delete a row from table
     * @return Model
     */
    public function delete(): Model
    {
        $this->query = "DELETE FROM $this->table";
        return $this;
    }

    /**
     * Where clause
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return Model
     */
    public function where(string $column, string $operator, string $value): Model
    {
        $this->query .= " WHERE $column $operator ?";
        $this->data[] = $value;
        return $this;
    }

    /**
     * And clause
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return Model
     */
    public function and(string $column, string $operator, string $value): Model
    {
        $this->query .= " AND $column $operator ?";
        $this->data[] = $value;
        return $this;
    }

    /**
     * Or clause
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return Model
     */
    public function or(string $column, string $operator, string $value): Model
    {
        $this->query .= " OR $column $operator ?";
        $this->data[] = $value;
        return $this;
    }

    /**
     * Order by clause
     * @param string $column
     * @param string $direction
     * @return Model
     */
    public function orderBy(string $column, string $direction = "ASC"): Model
    {
        $this->query .= " ORDER BY $column $direction";
        return $this;
    }

    /**
     * Limit clause
     * @param int $limit
     * @return Model
     */
    public function limit(int $limit): Model
    {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    /**
     * Offset clause
     * @param int $offset
     * @return Model
     */
    public function offset(int $offset): Model
    {
        $this->query .= " OFFSET $offset";
        return $this;
    }
}