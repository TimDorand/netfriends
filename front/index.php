<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 09/11/15
 * Time: 08:45
 */


//Require functions, la page php où sont stocké toutes les fonctions

require("functions.php");
require('header.php');
require('config.php');



// Empty pour n'envoyer des commentaires à la bdd que si $errors est vide !

if(!empty($_POST['submit'])) {
    $id_post = $_POST['id_post'];
    $auteur = $_POST['auteur'];
    $message = $_POST['commentaire'];
    $errors = [];

    if(empty($message)) {
        $errors = "Message requis !";
    }
    if(empty($auteur)) {
        $errors = "Auteur requis !";
    }

    if(empty($errors)) {
        addComment($bdd, $id_post, $auteur, $message);
    }
}

// Empty pour n'envoyer des posts à la bdd que si $errors est vide !


if(!empty($_POST['submitpost'])) {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $errors = [];

    if(empty($contenu)) {
        $errors = "Message requis !";
    }
    if(empty($titre)) {
        $errors = "Titre requis !";
    }

    if(empty($errors)) {
        addPost($bdd, $titre, $contenu);
    }
}

?>
<!--MODAL-->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<!--FIN MODAL-->

<div class="sidebar" style="padding:30px">
    <div class="caption form-group">
        <h2>Write a new post</h2>
        <form method="POST" action="">
            <label>Pseudo</label>
            <input class="form-control" type="text" name="titre" placeholder="Pseudo" /><br/>
            <label>Content</label>
            <textarea class="form-control" type="text" size="70" name="contenu" placeholder="What's on your mind ?" height="50px"></textarea><br/>
            <input class="form-control" type="submit" name="submitpost" value="Envoyer" />

        </form>
    </div>
</div>




<div class="row">
    <div class="col-sm-10 col-md-10 col-md-offset-1">
        <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
                <h3>Article 1</h3>
                <p>...</p>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add comment</button> <button type="button" class="btn btn-default">Show comments</button>

            </div>
        </div>
    </div>

</div>






<footer>

</footer>
</body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</html>