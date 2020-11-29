<?php

namespace App\Controller;

use App\Entity\Redirection;

Class RedirectionController
{

    public function redirect(string $path, ?string $queryParameters): string
    {
        $entity = new Redirection(1, 'test', 'test');

        var_dump($entity->id);
        var_dump($entity->from);
        var_dump($entity->to);

        return 'test';
    }
}
