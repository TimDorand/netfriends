<?php
include('config.php');

$req = $bdd->prepare('INSERT INTO commentaires (auteur, id_billet, commentaire)
		VALUES (:auteur, :id_billet, :commentaire)');

$req->execute(array(
    ':auteur' =>	$_POST['auteur'],
    ':commentaire' =>	$_POST['commentaire'],
    ':id_billet' => $_GET['billet']
));

// Récupération des commentaires
$req = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
$req->execute(array($_GET['billet']));

header('Location:comment.php?billet='.$_GET['billet']);

?>
