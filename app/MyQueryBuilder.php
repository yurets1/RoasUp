<?php

namespace App;

use PDO;

class MyQueryBuilder {

    private PDO $connection;
    private string $query;
    public function __construct(array $config) {
        $dbType = $config['dbType'];
        $host = $config['host'];
        $dbname = $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];

        $this->connection = new PDO("$dbType:host=$host;dbname=$dbname", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->query = '';
    }

    public function select($columns) {
        foreach ($columns as $column) {
            $this->query = 'SELECT ' . $column;
        }
        return $this;
    }

    public function update($table) {
        $this->query = 'UPDATE ' . $table;
        return $this;
    }

    public function set($column, $value) {
        $this->query .= ' SET ' . $column . ' = ' . "'$value'";
        return $this;
    }
     public function insert($table, $name, $login, $pass, $age){

        $this->query = "INSERT INTO $table  VALUES ('$name','$login', '$pass', $age)";
        return $this;
    }
     public function delete() {
        $this->query = 'DELETE ';
        return $this;
    }

    public function from($table) {
        $this->query .= ' FROM' . $table;
        return $this;
    }

    public function where($columns, $operator, $value) {
        $this->query .= ' WHERE ' . $columns . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function limit($limit) {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    public function execute() {
        $statement = $this->connection->prepare($this->query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}