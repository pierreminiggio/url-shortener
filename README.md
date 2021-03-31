# url-shortener

Prérequis :
- PHP 8
- Un serveur de base de données SQL

Créer le fichier de config :
```console
cp .env.example.json .env.json
```

Remplir le fichier de config avec vos identifiants DB.

Créer la table dans la base de données :
```sql
CREATE TABLE `redirection` (
  `id` int UNSIGNED NOT NULL,
  `from_path` varchar(255) NOT NULL,
  `to_url` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `redirection`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `from_path` (`from_path`);

ALTER TABLE `redirection`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
```
