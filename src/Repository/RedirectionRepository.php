<?php

namespace App\Repository;

use PierreMiniggio\DatabaseConnection\DatabaseConnection;
use PierreMiniggio\DatabaseConnection\DatabaseConnection\Exception\QueryException;
use App\Entity\Redirection;

class RedirectionRepository
{
    public function __construct(
        private DatabaseConnection $connection,
    )
    {}

    /**
     * @throws QueryException
     */
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

    /**
     * @return Redirection[]
     * 
     * @throws QueryException
     */
    public function findAll(): array
    {
        
        $this->connection->start();
        $res = $this->connection->query(
            'SELECT id, from_path, to_url FROM redirection ORDER BY from_path ASC;',
            []
        );
        
        $this->connection->stop();

        if (! $res) {

            return [];
        }

        return array_map(function (array $entry): Redirection {
            return new Redirection($entry['id'], $entry['from_path'], $entry['to_url']);
        }, $res);
    }
}
