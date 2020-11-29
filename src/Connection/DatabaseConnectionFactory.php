<?php

namespace App\Connection;

class DatabaseConnectionFactory
{
    public function makeFromConfig(): DatabaseConnection
    {
        $config = json_decode(file_get_contents(__DIR__ . '/../../.env.json'), true);
        
        return new DatabaseConnection(
            $config['host'],
            $config['database'],
            $config['username'],
            $config['password']
        );
    }
}
