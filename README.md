# SalgadoEval
Projet symfony de première année de master dev web

## Installation

```bash
cd salgadoEval
```
Toutes les prochaines commandes devront s'exécuter depuis l'intérieur du dossier SalgadoEval;


```bash
composer install
```
```bash
npm install
```

## Initialisation

Après avoir ajouté vos infos de connexion à votre base de donnée dans le **.env.dev** :
Générez la table ainsi que le schéma et remplissez la avec un jeu de données

```symfony
symfony console doctrine:database:create
```

```symfony
rm -r .\var\*
```

```symfony
symfony console make:migration
```

```symfony
symfony console doctrine:migrations:migrate -n
```
```symfony
symfony console doctrine:fixtures:load -n
```


## Utilisation
Pour lancer l'application, dans 2 terminaux différents, lancez :
```symfony
symfony serve
```
```npm
npm run watch
```


Merci
