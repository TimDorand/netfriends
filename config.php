<?php

//define('SQL_HOST',       'timotheefxtim.mysql.db');
//define('SQL_USERNAME',   'timotheefxtim');
//define('SQL_PASSWORD',   'Adminparis96');
//define('SQL_DBNAME',	 'timotheefxtim');


define('SQL_HOST',       'localhost');
define('SQL_USERNAME',   'root');
define('SQL_PASSWORD',   'root');
define('SQL_DBNAME',	 'netfriends');

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:dbname='.SQL_DBNAME.';host='.SQL_HOST, SQL_USERNAME, SQL_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(Exception $e) {
    exit('Erreur : ' . $e->getMessage());
}

