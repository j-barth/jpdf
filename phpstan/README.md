#Tests standards COE / PHP

##Documentation
https://phpstan.org/user-guide/getting-started

##Lancer l'inspection
Dans le dossier racine de <b>coe</b> exécuter la commande :
```
./vendor/bin/phpstan.phar analyse -c phpstan/phpstan.neon
```

##Générer un baseline
Dans le dossier racine de <b>coe</b> exécuter la commande :
```
./api/bin/phpstan.phar analyse -c phpstan/phpstan.neon --generate-baseline ./phpstan/phpstan-baseline.neon
```
