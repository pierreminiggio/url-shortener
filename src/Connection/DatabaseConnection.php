<?php

namespace App\Connection;

use PDO;
use PDOException;

class DatabaseConnection
{

    const UTF_8 = 'utf8';

    private ?PDO $connection;

    public function __construct(
        private string $host,
        private string $database,
        private string $username,
        private string $password,
        private string $charset = self::UTF_8
    )
    {}

    /**
     * @throws PDOException
     */
    public function start(): void
    {
        $this->connection = new PDO(
            'mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset,
            $this->username,
            $this->password
        );
    }

    public function stop(): void
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
