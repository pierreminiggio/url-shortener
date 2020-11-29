<?php

namespace App\Repository;

use App\Entity\Redirection;

class RedirectionRepository
{
    public function findByFrom(string $from): ?Redirection
    {
        return new Redirection(1, $from, 'test to');
    }
}
