<?php

namespace App\Controller;

use App\App;
use App\Connection\DatabaseConnectionFactory;
use App\Entity\Redirection;
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
