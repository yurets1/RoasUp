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

    public function select(array $columns): MyQueryBuilder {
        foreach ($columns as $column) {
            $this->query = 'SELECT ' . $column;
        }
        return $this;
    }

    public function update(string $table): MyQueryBuilder {
        $this->query = 'UPDATE ' . $table;
        return $this;
    }

    public function set(string $column, mixed $value): MyQueryBuilder {
        $this->query .= ' SET ' . $column . ' = ' . "'$value'";
        return $this;
    }
     public function insert(string $table, mixed $name, mixed $login, mixed $pass, int $age): MyQueryBuilder{

        $this->query = "INSERT INTO $table  VALUES ('$name','$login', '$pass', $age)";
        return $this;
    }
     public function delete(): MyQueryBuilder {
        $this->query = 'DELETE ';
        return $this;
    }

    public function OrderBy(string $column, $attribute = ''): MyQueryBuilder {
        $this->query .= ' ORDER BY ' . $column . ' ' . $attribute;
        return $this;
    }

    public function from(string $table): MyQueryBuilder {
        $this->query .= ' FROM ' . $table;
        return $this;
    }

    public function where( $columns, $operator, mixed $value): MyQueryBuilder {
        $this->query .= ' WHERE ' . $columns . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function limit(int $limit): MyQueryBuilder {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    public function execute(): array{
        $statement = $this->connection->prepare($this->query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}