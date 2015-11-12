<?php
require('config.php');
require('functions.php');

if(!empty($_POST['submit'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $errors = [];

    if(empty($password)) {
        $errors = "Password requis !";
    }
    if(empty($pseudo)) {
        $errors = "Pseudo requis !";
    }

    if(empty($errors)) {
        signIn($bdd, $pseudo, $password);
        header('Location:index(old for conncet.php');
    }
}
