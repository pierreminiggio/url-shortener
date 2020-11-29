<?php

namespace App\Controller;

use App\Repository\RedirectionRepository;

Class RedirectionController
{

    public function redirect(string $path, ?string $queryParameters): string
    {
        $entity = (new RedirectionRepository())->findByFrom($path);

        var_dump($entity->getId());
        var_dump($entity->getFrom());
        var_dump($entity->getTo());

        return 'test';
    }
}
