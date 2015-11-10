<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/11/15
 * Time: 08:38
 */

// Fonction pour AJOUTER des COMMENTAIRES

function addComment($bdd, $id_post, $auteur, $message) {

    $reqcom = $bdd->prepare("INSERT INTO comments(id_billet, auteur, commentaire) VALUES ('$id_post','$auteur','$message') ");
    $reqcom->execute(array($id_post, $auteur,$message));

    return $reqcom;
}


//Ajout d'un post dans la base de donnée

function addPost($bdd, $titre, $contenu) {

    $reqpost = $bdd->prepare("INSERT INTO billets(titre, contenu) VALUES ('$titre','$contenu') ");
    $reqpost->execute(array($titre, $contenu));

    return $reqpost;
}



// Connexion à la base de données

$bdd = new PDO('mysql:host=localhost;dbname=netfriends;charset=utf8', 'root', 'root');

if(isset($_POST['titre']) AND isset($_POST['contenu']))
{
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    header('location:index.php');

}