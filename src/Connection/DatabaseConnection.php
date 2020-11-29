<?php

namespace App\Connection;

use PDO;
use PDOException;

class DatabaseConnection
{
    private PDO $connection;

    public function __construct(
        private string $host,
        private string $db,
        private string $username,
        private string $password,
    )
    {}

    /**
     * @throws PDOException
     */
    public function connect(): void
    {
        $this->connection = new PDO(
            'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8',
            $this->username,
            $this->password
        );
    }

    public function disconnect(): void
    {
        $this->connection = null;
    }

    /**
     * @throws PDOException
     */
    public function query(string $query, array $parameters): array
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($parameters);

        return $statement->fetchAll();
    }

    /**
     * @throws PDOException
     */
    public function exec(string $query, array $parameters): void
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($parameters);
    }
}
