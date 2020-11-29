<?php

namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Entity\Redirection;

class RedirectionRepository
{
    public function __construct(
        private DatabaseConnection $connection,
    )
    {}

    public function findByFrom(string $from): ?Redirection
    {
        $this->connection->start();
        $res = $this->connection->query(
            'SELECT id, from_path, to_url FROM redirection WHERE from_path = :from_path;',
            [
                ':from_path' => $from
            ]
        );

        $this->connection->stop();

        if (! $res) {

            return null;
        }

        $firstRes = $res[0];

        return new Redirection($firstRes['id'], $firstRes['from_path'], $firstRes['to_url']);
    }
}
