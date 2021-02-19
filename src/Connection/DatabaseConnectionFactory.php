<?php

namespace App\Connection;

use PierreMiniggio\DatabaseConnection\DatabaseConnection;

class DatabaseConnectionFactory
{
    public function makeFromConfig(): DatabaseConnection
    {
        $config = json_decode(file_get_contents(
            __DIR__
                .  DIRECTORY_SEPARATOR
                . '..'
                 . DIRECTORY_SEPARATOR
                . '..'
                 . DIRECTORY_SEPARATOR
                . '.env.json'
        ), true);
        
        return new DatabaseConnection(
            $config['host'],
            $config['database'],
            $config['username'],
            $config['password'],
        );
    }
}
