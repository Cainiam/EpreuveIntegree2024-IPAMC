# Epreuve intégrée "Site web de vente en ligne de figurine avec le framework Laravel" (année 2023-2024)

## Résumé :
Développement d'un site web e-commerce ayant comme thème la vente en ligne de figurines (licenciée de série japonaise). Il a été réalisé dans le cadre d'une épreuve intégrée à l'école de promotion sociale IPAMC, implentation d'Ecaussinnes (anciennement nommée EICE, Ecole Industrielle Et Commerciale d'Ecaussinnes), au cours de l'année scolaire 2023-2024 pour la validation d'un Bachelier en Informatique de Gestion. Le projet a été remis le 18 novembre 2024, "installé" (site disponible en ligne au moment de la défense orale) à l'école le samedi 30 novembre et la défense a été réalisée le samedi 7 décembre à 10h.

## Auteur de l'Epreuve Intégrée :
* Jordan Boisdenghien

## Chargé d'enseignement :
* Monsieur F. Mahieu

## Description brève de l'Epreuve Intégrée :
Il s'agit ici d'un site web e-commerce ayant comme thème la vente en ligne de figurine sur base d'un magasin fictif basé à Binche en Belgique.
Le site web permet la connexion à 2 types d'utilisateurs (défini via un rôle) : client (les utilisateurs "classiques" qui utilisent le site) et gérant (les utilisateurs "administrateur" / gestionnaire du magasin).
Le gérant peut, via un interface "Dashboard", gérer partiellement la base de données.
L'utilisateur peut, sans être connecté, via les différentes pages, parcourir les figurines disponibles, les ajouter à son panier (le payement nécessite la connexion).
Le client (utilisateur connecté) peut gérer un "profil", réaliser des payements (soit fictif, soit PayPal Sandbox), consulter ses commandes (impression facture / vue détaillée).

## "Techonologies" utilisée :
* Visual Studio Code
* Laravel 11.x LTS avec les composants :
** Laravel Breeze-Livewire (Tailwind CSS inclus) - Créé un premier jet d'interface utilisateur : profil / login / register.
** Barryvdh/laravel-dompdf - Permet de créer des PDF via des vues HTML.
** Skrmlive/laravel-paypal - Permet de simplifier la mise en place des paiements avec PayPal.
* Composer 2.6.6
* PHP 8.3 (Laravel 11 nécessite PHP > 8.2 !)
* Autres pré-requis de Laravel 11
* Jira (pour Kanban board)
* Hébergement via Hostinger pour les tests du jury

## Composition du dépôt :
* Dossier "rokuban" - site web.
* Dossier "remise" - dossier de l'épreuve intégrée, errata remis lors de l'oral et slides utilisée lors de l'oral.
