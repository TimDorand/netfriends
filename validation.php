<?php
require('config.php');
require('functions.php');


$pseudo		= $_POST['pseudo'];
$password	= $_POST['password'];
$query = connect($bdd, $pseudo);

foreach($query as $query) {
    if($query['password'] == $password) {
        session_start();
        // L'user est connecté
        $_SESSION['name'] = $pseudo;
        $_SESSION['id'] = $query['id'];
        header('Location: index(old for conncet.php');
    }
}


