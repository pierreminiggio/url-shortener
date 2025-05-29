<?php

namespace App\Controller;

use App\App;
use App\Connection\DatabaseConnectionFactory;
use App\Entity\Redirection;
use App\Repository\ManagedLinksRepository;
use App\Repository\RedirectionRepository;
use App\Template\ErrorTemplate;
use App\Template\RedirectionTemplate;
use DateInterval;
use DateTime;
use Exception;

Class RedirectionController
{

    public function handleDynamicPath(string $path, ?string $queryParameters): string
    {
        $connection = (new DatabaseConnectionFactory())->makeFromConfig();
        $repository = new RedirectionRepository($connection);
        $entity = $repository->findByFrom($path);

        if ($entity) {
            return $this->displayEntity($entity, $queryParameters);
        }

        $managedLinksRepository = new ManagedLinksRepository();
        $response = $managedLinksRepository->callApi($path);

        if ($response === null) {
            return (new ErrorTemplate())->render(404);
        }

        if ($response instanceof Redirection) {
            return $this->displayEntity($response, $queryParameters);
        }

        if (is_string($response)) {
            return $response;
        }

        throw new Exception('Unexpected response');
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

        $cacheFolder = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache';

        if (! file_exists($cacheFolder)) {
            mkdir($cacheFolder);
        }

        $domain = $_SERVER['HTTP_HOST'] ?? null;

        if (! $domain) {
            throw new Exception('Empty $_SERVER[\'HTTP_HOST\']');
        }

        $domainInfoFile = $cacheFolder . DIRECTORY_SEPARATOR . str_replace('.', '-', $domain) . '-domain-infos.txt';

        beforeCheckFile:
        if (! file_exists($domainInfoFile)) {
            $command = 'dig @ns1.' . $domain . ' ' . $domain . ' axfr > ' . $domainInfoFile;
            shell_exec($command);
        }

        if (! file_exists($domainInfoFile)) {
            throw new Exception('Error while creating file');
        }

        $fileTimestamp = filectime($domainInfoFile);
        if ($fileTimestamp === false) {
            throw new Exception('File timestamp error');
        }

        $datetime = (new DateTime())->setTimestamp($fileTimestamp);
        if ((new DateTime()) > (clone $datetime)->add(new DateInterval('P3D'))) {
            unlink($domainInfoFile);
            goto beforeCheckFile;
        }

        $domainDot = $domain . '.';
        $wwwDot = 'www.';

        $handle = fopen($domainInfoFile, 'r');

        $alreadyChecked = [];

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = trim(preg_replace('/\s+/', ' ', $line));

                if (str_contains($line, 'IN A') || str_contains($line, 'IN AAAA') || str_contains($line, 'IN CNAME')) {
                    $explodedLine = explode(' ', $line, 2);
                    $entry = $explodedLine[0];

                    if (! str_ends_with($entry, $domainDot)) {
                        continue;
                    }

                    $entry = substr($entry, 0, - (strlen($domainDot)));

                    if (str_starts_with($entry, $wwwDot)) {
                        $entry = substr($entry, strlen($wwwDot));
                    }

                    if ($entry === '') {
                        continue;
                    }

                    if ($entry === '*.') {
                        continue;
                    }

                    if (str_ends_with($entry, '.')) {
                        $entry = substr($entry, 0, -1);
                    }

                    if (in_array($entry, $alreadyChecked)) {
                        continue;
                    }

                    $alreadyChecked[] = $entry;

                    if (str_contains($entry, '.')) {
                        continue;
                    }
                    
                    if (! in_array($entry, $urls)) {
                        $urls[] = $entry;
                    }
                }
            }

            fclose($handle);
        }

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

    private function displayEntity(Redirection $entity, ?string $queryParameters): string
    {
        $newUrl = $entity->to . ($queryParameters ? $queryParameters : '');
        header('Location: ' . $newUrl);

        return (new RedirectionTemplate())->render($newUrl);
    }
}
