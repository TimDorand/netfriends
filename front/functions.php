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

/*AJOUT d'un réponse à un commentaire*/
function reply($bdd, $id_comment, $auteur, $message) {

    $reqrep = $bdd->prepare("INSERT INTO reply(id_comments, auteur, commentaire) VALUES ('$id_comment','$auteur','$message') ");
    $reqrep->execute(array($id_comment, $auteur , $message));

    return $reqrep;
}


/*fonction d'inscription*/
/*
function signIn($bdd, $pseudo, $password)
{

    $reqsign = $bdd->prepare("INSERT INTO users(pseudo, password) VALUES ('$pseudo','$password') ");
    $reqsign->execute(array($pseudo, $password));

    return $reqsign;
}


function connect($bdd, $pseudo)
{

    $reqco = "SELECT * FROM users WHERE pseudo=".$pseudo;
    $query = msqli_query($bdd, $reqco);
    $data = [];
    while ($row = $query->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}*/
