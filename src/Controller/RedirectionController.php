<?php

namespace App\Controller;

use App\App;
use App\Connection\DatabaseConnectionFactory;
use App\Entity\Redirection;
use App\Repository\ManagedLinksRepository;
use App\Repository\RedirectionRepository;
use App\Template\ErrorTemplate;
use App\Template\RedirectionTemplate;
use Exception;

Class RedirectionController
{

    public function handleSingleArgumentPath(string $path, ?string $queryParameters): string
    {
        $connection = (new DatabaseConnectionFactory())->makeFromConfig();
        $repository = new RedirectionRepository($connection);
        $entity = $repository->findByFrom($path);

        if ($entity) {
            $newUrl = $entity->to . ($queryParameters ? ('?' . $queryParameters) : '');
            header('Location: ' . $newUrl);

            return (new RedirectionTemplate())->render($newUrl);
        }

        $managedLinksRepository = new ManagedLinksRepository();
        $response = $managedLinksRepository->findUserProfile($path);

        if ($response) {
            return $response;
        }

        return (new ErrorTemplate())->render(404);
    }

    public function list(): string
    {
        $redirections = $this->findAll();

        return (new RedirectionTemplate())->renderList($redirections);
    }

    public function listUrlsJson(): string
    {
        $redirections = $this->findAll();
        
        $urls = array_map(
            fn (Redirection $redirection): string => $redirection->from,
            $redirections
        );
        
        $urls[] = App::$allUri;
        $urls[] = App::$allurlsjsonUri;

        return json_encode($urls);
    }

    /**
     * @return \App\Entity\Redirection[]
     */
    private function findAll(): array
    {
        $connection = (new DatabaseConnectionFactory())->makeFromConfig();
        $repository = new RedirectionRepository($connection);

        return $repository->findAll();
    }
}
