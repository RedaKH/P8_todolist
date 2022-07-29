# P8_todolist
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/1a96001db2d1468e984f5a76779099ad)](https://www.codacy.com/gh/RedaKH/P8_todolist/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=RedaKH/P8_todolist&amp;utm_campaign=Badge_Grade)
Installation du projet : 
 
  1/Il faut faire cette commande pour cloner le projet : 
   `git clone https://github.com/RedaKH/P8_todolist.git`
   
   2/Vous devez ensuite configurer la connexion à la base de données en allant sur le fichier .env et .env.test :
   `DATABASE_URL="mysql://votre_nom:votre_mdp@127.0.0.1:3306/votre_bdd?serverVersion=5.7&charset=utf8mb4"`

 3/Il faut installer composer en faisant ca :
   `composer install`
   
   
   
 4/Si vous n'avez pas créer de bases de données vous devez faire cette commande :   
   `php bin/console doctrine:database:create`
 5/La même chose pour les tests :
 `php bin/console doctrine:database:create --env=test`
   
   
  6/Ensuite effectuez cette commande pour créer vos tables en faisant cette commande pour la migration :
  `php bin/console doctrine:migrations:migrate `
  
  7/Pour les tests faites cette commande :
  ` php bin/console doctrine:schema:update --env=test --force `
  
  8/Enfin pour effectuer vos tests faites ceci :
  
  ` php bin/phpunit`
  
