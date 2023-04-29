<?php

namespace core;
/**
 * Base Model Trait
 */
class Model
{
    use Database;

    protected string $table = "";
    protected array $columns = [];
    protected array $errors = [];
    protected int $nrows = 1000;

    /**
     * Select rows from table
     * @param array|string $column_list
     * @return Model
     */
    public function select(array|string $column_list = "*"): Model
    {
        if (empty($column_list)) {
            $column_list = "*";
        }
        if (is_array($column_list)) {
            for ($i = 0; $i < count($column_list); $i++) {
                if (!str_contains($column_list[$i], ".")) {
                    $column_list[$i] = $this->table . "." . $column_list[$i];
                }
            }
            $column_list = implode(", ", $column_list);
        } else {
            if (!str_contains($column_list, ".")) {
                $column_list = $this->table . "." . $column_list;
            }
        }

        $this->query = "SELECT $column_list FROM $this->table";
        return $this;
    }

    public function count(string $column): Model
    {
        $this->query = "SELECT COUNT($column) FROM $this->table";
        return $this;
    }

    // Get number of pages according to the offset
    public function getPages(): int
    {
        $this->query = "SELECT COUNT(*) FROM $this->table";
        $c = $this->fetch();
        return ceil($c->{'COUNT(*)'}/$this->nrows);
    }

    /**
     * Insert a row into table
     * @param array $data
     * @return void
     */
    public function insert(array $data): void
    {
        foreach (array_keys($data) as $column) {
            if (!in_array($column, $this->columns)) {
                unset($data[$column]);
            }
        }
        if (empty($data)) {
            return;
        }
        $column_list = implode(", ", array_keys($data));
        $value_list = "";
        foreach ($data as $ignored) {
            $value_list .= "?, ";
        }
        $value_list = rtrim($value_list, ", ");
        $this->query = "INSERT INTO $this->table ($column_list) VALUES ($value_list)";
        $this->data = array_values($data);
        $this->execute();
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
            if (!in_array($column, $this->columns)) {
                unset($data[$column]);
            }
            $column_list .= "$column = ?, ";
        }
        if (empty($data)) {
            return $this;
        }
        $column_list = rtrim($column_list, ", ");
        $this->query = "UPDATE $this->table SET $column_list";
        $this->data = array_values($data);
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
    public function where(string $column, string $value, string $operator = "="): Model
    {
        $this->query .= " WHERE $column $operator ?";
        $this->data[] = $value;
        return $this;
    }

    /**
     * Where clause
     * @param string $column1
     * @param string $operator
     * @return Model
     * Compare two columns
     */
    public function wherecolumn(string $column1, string $column2, string $operator = "="): Model
    {
        $this->query .= " WHERE $column1 $operator $column2";
        return $this;
    }

    /**
     * And clause
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return Model
     */
    public function and(string $column, string $value, string $operator = "="): Model
    {
        $this->query .= " AND $column $operator ?";
        $this->data[] = $value;
        return $this;
    }
    //Check for null values
    //Usage: $this->checkNull("AND", "column", "value", "IS NOT");
    //Usage: $this->checkNull("OR", "column", "value");
    public function checkNull(string $operation,string $column, string $operator = "IS"): Model
    {
        $this->query .= " $operation $column $operator NULL";
        return $this;
    }

    /**
     * Or clause
     * @param string $column
     * @param string $operator
     * @param string $value
     * @return Model
     */
    public function or(string $column, string $value, string $operator = "="): Model
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
        if (empty($column)) {
            return $this;
        }
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

    /**
     * Join clause
     */
    public function join(string $table, string $column1, string $column2, string $operator = "="): Model
    {
        $this->query .= " JOIN $table ON $column1 $operator $column2";
        return $this;
    }

    /**
     * Left join clause
     */

    public function leftJoin(string $table, string $column1, string $column2, string $operator = "="): Model
    {
        $this->query .= " LEFT JOIN $table ON $column1 $operator $column2";
        return $this;
    }

    /**
     * Right join clause
     */

    public function rightJoin(string $table, string $column1, string $column2, string $operator = "="): Model
    {
        $this->query .= " RIGHT JOIN $table ON $column1 $operator $column2";
        return $this;
    }

    public function contains(array $columns, string $value): Model
    {
        $this->query .= " WHERE (";
        foreach ($columns as $column) {
            $this->query .= $column . " LIKE ? OR ";
            $this->data[] = "%$value%";
        }
        $this->query = rtrim($this->query, "OR ");
        $this->query .= ")";
        return $this;
    }

    /**
     * Return errors
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    /**
     * Return last insert id
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->db->lastInsertId();
    }
}
