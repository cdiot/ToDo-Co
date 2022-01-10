# ToDO and Co

Il s'agit d'une application permettant de gérer ses tâches quotidiennes.

## Environnement de développement 

### Pré-requis

* PHP 7.4
* MySQL
* Apache
* Composer
* Somfony CLI

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirements
```

### Lancer l'environnement de développement 

Pour démarrer l'environnement de développement tapé les commandes suivantes :

```bash
composer install
symfony console doctrine:database:create
symfony console doctrine:schema:create
symfony serve -d
```

Vous pouvez configurer l'accès à la base de données dans le fichier .env

### Lancer les fixtures
Pour lancer les fixtures tapé les commandes suivantes :

```bash
composer reset
```

### Tests coverage
Pour générer le test coverage suivait cette commande

```bash
symfony php bin/phpunit --coverage-html var/log/test/test-coverage
```

Après ça pour consulter le résultat suivre ce lien `127.0.0.1:5500/var/log/test/test-coverage/index.html`.

### Lien vers le dossier de la documentation technique

```bash
documentation/guide_authentification.pdf
```

### Lien vers le dossier de la documentation technique de contribution

```bash
documentation/contribution.pdf
```

### Lien audit de qualité de code 

```bash
https://app.codacy.com/gh/cdiot/ToDo-Co/dashboard
```

### Lien vers le dossier de la documentation concernant l'audit de performance

```bash
documentation/audit_de_performance.pdf
```