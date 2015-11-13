<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/11/15
 * Time: 08:38
 */

// Fonction pour AJOUTER des COMMENTAIRES

function addComment($bdd, $id_post, $auteur, $message) {

    //$reqcom = $bdd->prepare("INSERT INTO comments(id_billet, auteur, commentaire) VALUES ('$id_post','$auteur','$message') ");
    $reqcom = "INSERT INTO comments (id_billet, auteur, commentaire) VALUES (:id_billet, :auteur, :commentaire)";
    $prep = $bdd->prepare($reqcom);
    $prep->bindValue(':id_billet', $id_post, PDO::PARAM_INT);
    $prep->bindValue(':auteur', $auteur, PDO::PARAM_STR);
    $prep->bindValue(':commentaire', $message, PDO::PARAM_STR);

    $prep->execute();

    $result = $bdd->lastInsertId();

    $prep->closeCursor();
    $prep = NULL;

    return $result;
}


//Ajout d'un post dans la base de donnée

function addPost($bdd, $titre, $contenu) {

    $reqpost ="INSERT INTO billets(titre, contenu) VALUES (:titre, :contenu)";
    $prep = $bdd->prepare($reqpost);
    $prep->bindValue(':titre', $titre, PDO::PARAM_STR);
    $prep->bindValue(':contenu', $contenu, PDO::PARAM_STR);

    $prep->execute();

    $result = $bdd->lasInsertId();

    $prep->closeCursor();
    $prep = NULL;

    return $result;
}

//Ajout d'une réponse dans la base de donnée

function addReply($bdd, $id_comments, $interloc, $reponse) {

    $reqrep = "INSERT INTO reply(id_comments, interloc, reponse) VALUES (:id_comments, :interloc, :reponse)";
    $prep = $bdd->prepare($reqrep);
    $prep->bindValue(':id_comments', $id_comments, PDO::PARAM_INT);
    $prep->bindValue(':interloc', $interloc, PDO::PARAM_STR);
    $prep->bindValue(':reponse', $reponse, PDO::PARAM_STR);

    $prep->execute();

    $result = $bdd->lastInsertId();

    $prep->closeCursor();
    $prep = NULL;

    return $result;
}


