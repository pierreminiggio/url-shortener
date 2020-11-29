<?php

namespace App\Controller;

use App\Entity\Redirection;

Class RedirectionController
{

    public function redirect(string $path, ?string $queryParameters): string
    {
        $entity = new Redirection(1, 'test', 'test');

        var_dump($entity->getId());
        var_dump($entity->getFrom());
        var_dump($entity->getTo());

        return 'test';
    }
}
