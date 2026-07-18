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

        $html = <<<HTML
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset='utf-8'>
                    <title>Vous vous êtes égaré ?</title>
                    <link href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
                    <style>
                        body {
                            background: #121212;
                            color: #eee
                        }
                        
                        .card {
                            background: #1e1e1e
                        }
                        
                        .code {
                            font-family: monospace
                        }

                        .collection-item.code {
                            background-color: #666666;
                        }
                        
                        .footer {
                            padding: 20px;
                            text-align: center;
                            color: #aaa
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h3><i class='material-icons left'>explore_off</i>Vous vous êtes égaré ?</h3>
                        <p>Oups ! Vous avez probablement fait une petite erreur en saisissant un lien. Ce domaine est habituellement utilisé comme réducteur de lien avec un des formats suivants :</p>
                        <ul class='collection'>
                            <li class='collection-item code'>https://$domain/quelquechose</li>
                            <li class='collection-item code'>https://$domain/quelquechose/quelquechose</li>
                            <li class='collection-item code'>https://quelquechose.$domain</li>
                            <li class='collection-item code'>https://quelquechose.$domain/quelquechose</li>
                        </ul>
                        <div id='back' style='display:none'><a class='btn blue' href='javascript:history.back()' id='backlink'></a></div>
        HTML;
        if ($domain === $ggioFrDomain) {
            $html .= <<<HTML
                        <h4>Ou bien peut-être cherchais-tu un de ces projets ?</h4>
                        <div class='row'>
            HTML;
            
            foreach ($ggioFrProjects as $project) {
                $html .= <<<HTML
                            <div class='col s12 m6 l4'>
                                <div class='card'>
                                    <div class='card-content'>
                                        <span class='card-title'>{$project['name']}</span>
                                        <p>{$project['description']}</p>
                                    </div>
                                    <div class='card-action'>
                                        <a href='{$project['url']}' target='_blank'>Visiter</a>
                                    </div>
                                </div>
                            </div>
                HTML;
            }

            $html .= <<<HTML
                        </div>
            HTML;
        }
        
        $html .= <<<HTML
                        <h4>Ou sinon tu peux retrouver <a target='_blank' href='https://miniggiodev.fr'>mon site miniggiodev.fr</a></h4>    
                        <p>Tu pourras y retrouver mes projets, mes vidéos, mes musiques et bien plus encore !</p>
                    </div>
                    <footer class='footer'><a target='_blank' href='https://miniggiodev.fr'>Pierre Miniggio</a> • <a target='_blank' href='https://miniggiodev.fr'>miniggiodev.fr</a></footer>
                    <script>if(history.length>1){const b=document.getElementById('back');const l=document.getElementById('backlink');let t='← Retourner';if(document.referrer){try{const h=new URL(document.referrer).hostname;const hide=['example.com','example.org','example.net','localhost','127.0.0.1'];t=hide.includes(h)?'← Retourner à la page précédente':'← Retourner sur '+h}catch(e){t='← Retourner à la page précédente'}}l.textContent=t;b.style.display='block';}</script>
                </body>
            </html>
        HTML;

        return $html;
    }
}
