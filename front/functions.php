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

//Ajout d'une réponse dans la base de donnée

function addReply($bdd, $id_comments, $interloc, $reponse) {

    $reqrep = $bdd->prepare("INSERT INTO reply(id_comments, interloc, reponse) VALUES ('$id_comments ','$interloc ',' $reponse') ");
    $reqrep->execute(array($id_comments, $interloc, $reponse));

    return $reqrep;
}


