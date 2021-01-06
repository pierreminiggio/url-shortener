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
        $connection = (new DatabaseConnectionFactory())->makeFromConfig();
        $repository = new RedirectionRepository($connection);
        $entity = $repository->findByFrom($path);

        if (! $entity) {
            return (new ErrorTemplate())->render(404);
        }

        $newUrl = $entity->to . ($queryParameters ? ('?' . $queryParameters) : '');
        header('Location: ' . $newUrl);

        return (new RedirectionTemplate())->render($newUrl);
    }

    public function list(): string
    {
        $connection = (new DatabaseConnectionFactory())->makeFromConfig();
        $repository = new RedirectionRepository($connection);
        $redirections = $repository->findAll();

        return (new RedirectionTemplate())->renderList($redirections);
    }
}
