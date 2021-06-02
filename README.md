# Ma Biblio

## Concept : Bibliothèque virtuelle

Site web/web mobile permettant de se constituer une bibliothèque virtuelle pour ajouter ses livres, les classer, leur attribuer une note et y apporter un commentaire personnel.

## Stack technique

### Back

* Symfony 5 (PHP 7.4)
* MySQL 8.0
* ORM Doctrine
* PHP CURL / PHP GD
* API Google Book

## Front

* Twig (moteur de templates)
* Bootstrap 4
* JavaScript (Vanilla)
* jQuery / Ajax
* Select2

## Installation du projet

Si besoin, le composer install peut se faire avec le `composer.phar` inclut dans le projet.

Il faudra ensuite configurer un VHOST Apache ou Nginx avec une des configurations proposées dans la documentation officielle de Symfony : https://symfony.com/doc/current/setup/web_server_configuration.html

Puis effectuer les opérations suivantes :
* Copier / coller le `.env` en `.env.local` et modifier les variables en conséquence, notamment passer `APP_ENV=dev` en `APP_ENV=prod`.
* `bin/console doc:dat:crea` (pour créer la base de données si non précédemment créée)
* `bin/console doc:mig:mig` (pour jouer les migrations)
* `bin/console init:data` (permet de créer les données de départ : rôles, catégories, administrateurs)

## Exemple mis en ligne

Nom de domaine : https://ma-biblio.com/

### Stack utilisée pour la mise en production

* Nginx
* iptables
* fail2ban
* Let's Encrypt via Certbot
* activation de HTTP2
