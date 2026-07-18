<?php

namespace App\Template;

class HomeTemplate
{

    public function render(string $domain): string
    {
        $linkShortenerDomains = ['ggio.be', 'ggio.dev', 'ggio.fr', 'ggio.link', 'ggio.org'];

        if (! in_array($domain, $linkShortenerDomains)) {
            return <<<HTML
                <p>Domain not supported</p>
            HTML;
        }
        
        $ggioFrDomain = 'ggio.fr';

        $ggioFrProjects = [
            [
                'name' => 'Tous Les Verbes',
                'description' => 'API des verbes français',
                'url' => 'https://api.touslesverbes.ggio.fr/doc'
            ],
            [
                'name' => 'Apprendre PHP',
                'description' => 'Playlist Youtube pour vous aider à apprendre PHP',
                'url' => 'https://apprendrephp.ggio.fr'
            ],
            [
                'name' => 'Certificates',
                'description' => 'Formulaire vous permettant d\'obtenir le droit d\'utiliser mes musiques sur vos vidéos',
                'url' => 'https://certificates.ggio.fr'
            ],
            [
                'name' => 'Email',
                'description' => 'Pour être informé de la sortie de mes prochaines vidéos',
                'url' => 'https://email.ggio.fr'
            ],
            [
                'name' => 'Je suis boosted',
                'description' => 'Le site du groupe Facebook "Je suis boosted sur League Of Legends", le meilleur groupe Facebook de tous les temps',
                'url' => 'https://jesuisboosted.ggio.fr'
            ],
            [
                'name' => 'Likes',
                'description' => 'Mes likes Youtube',
                'url' => 'https://likes.ggio.fr'
            ],
            [
                'name' => 'Language de merde',
                'description' => 'Un site qui répertories tous les languages de programmation qui puent grave la merde',
                'url' => 'https://merde.ggio.fr'
            ],
            [
                'name' => 'Uno !',
                'description' => 'Uno !!!',
                'url' => 'https://uno.ggio.fr'
            ]
        ];

        return <<<HTML
            <p>$domain</p>
        HTML;
    }
}
