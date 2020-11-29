<?php

namespace App\Controller;

use App\Connection\DatabaseConnectionFactory;
use App\Repository\RedirectionRepository;
use App\Template\ErrorTemplate;
use App\Template\RedirectionTemplate;

Class RedirectionController
{

    public function redirect(string $path, ?string $queryParameters): string
    {
        $repository = new RedirectionRepository((new DatabaseConnectionFactory())->makeFromConfig());
        $entity = $repository->findByFrom($path);

        if (! $entity) {
            return (new ErrorTemplate())->render(404);
        }

        $newUrl = $entity->to . ($queryParameters ? ('?' . $queryParameters) : '');
        header('Location: ' . $newUrl);

        return (new RedirectionTemplate())->render($newUrl);
    }
}
