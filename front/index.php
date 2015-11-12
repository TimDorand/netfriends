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

// Si le submit de la REPONSE n'est pas vide, alors on affice la fonction d'ajout de reponse

if(!empty($_POST['submitrep'])) {
    $id_comment = $_POST['id_comment'];
    $auteur = $_POST['auteur'];
    $message = $_POST['message'];
    $errors = [];

    if(empty($message)) {
        $errors = "Message requis !";
    }
    if(empty($auteur)) {
        $errors = "Auteur requis !";
    }

    if(empty($errors)) {
        reply($bdd, $id_comment, $auteur, $message);
    }
}

?>



<div class="col-md-7">
    <div class="page-header">
        <h1>Feed NetFriends</h1>
    </div>
<!--Display des errors-->
        <?php
        if (!empty($errors)) {
            echo "<p class=\"bg-danger\" style=\"padding:5px\">";
            print_r($errors);
        }elseif(!empty($_POST['submit'])) {

            echo "<p class=\"bg-success\" style=\"padding:5px\">Succès !";
        }    echo '</p>';



        // On récupère les derniers POSTS avec REQ

        $req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 10');

        // Boucle pour récupérer les posts POST

        while ($post = $req->fetch())
        {
        ?>

    <div class="col-md-12">
        <div class="thumbnail">
            <div class="caption">
                <h3><?php echo htmlspecialchars($post['titre']); ?></h3>
                <p>le <?php echo $post['date_creation_fr']; ?></p>
                <p><?php echo $post['contenu']; ?></p>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add comment</button>
<!--                <button type="button" class="btn btn-default ">Show comments</button>-->
                <div class=" btn btn-default flip">Show comments</div>

                <div class="write">
                <hr/>

            <?php

            // Récupération des COMMENTAIRES en fonction de l'id de l'article avec REQ1

            $req1 = $bdd->prepare('SELECT id, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire_fr FROM comments WHERE id_billet = ? ORDER BY date_commentaire');
            $req1->execute(array($post['id']));

            //Boucle des commentaires  COMMENT

            while ($comment = $req1->fetch())
            {
                ?>

                <p><strong><?php echo htmlspecialchars($comment['auteur']); ?></strong> le <?php echo $comment['date_commentaire_fr']; ?></p>
                <p><?php echo nl2br(htmlspecialchars($comment['commentaire'])); ?></p>

                <?php

                // Récupération des REPONSES en fonction de l'id du commentaire avec la requete reqAffReply

                $reqaffreply = $bdd->prepare('SELECT auteur, reponse, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_reponse_fr FROM reply WHERE id_comments = ? ORDER BY date_reponse');
                $reqaffreply->execute(array($comment['id']));

                //Boucle des REPONSES REQREPLY

                while ($reqreply = $reqaffreply->fetch()) {
                    ?>

                    <p><strong><?php echo htmlspecialchars($reqreply['auteur']); ?></strong>le <?php echo $reqreply['date_commentaire_fr']; ?></p>
                    <p><?php echo nl2br(htmlspecialchars($reqreply['commentaire'])); ?></p>

                    <form method="POST" action="">
                        <label>Auteur</label>
                        <input class="form-control" type="text" name="auteur" placeholder="Auteur" /><br/>
                        <label>Content</label>
                        <input class="form-control" type="text" size="70" name="commentaire" placeholder="What's on your mind ?" /><br/>
                        <input type="hidden" value="<?php echo $reqreply['id']; ?>" name="id_post">
                        <input class="form-control btn-primary" type="submit" name="submit" value="Envoyer" />
                    </form>

                    <?php
                    } // Fin de la boucle des réponses
                    $reqaffreply->closeCursor();

                } // Fin de la boucle des commentaires
                $req1->closeCursor();
            ?>

        </div><!--Referme la div de tous les commentaires-->
            </div>
        </div>

        <!--ADD COMMENTAIRES POPUP MODAL-->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add a comment<?php echo $post['id']; ?></h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <label>Auteur</label>
                            <input class="form-control" type="text" name="auteur" placeholder="Auteur" /><br/>
                            <label>Content</label>
                            <input class="form-control" type="text" size="70" name="commentaire" placeholder="What's on your mind ?" /><br/>
                            <input type="hidden" value="<?php echo $post['id']; ?>" name="id_post">
                            <input class="form-control btn-primary" type="submit" name="submit" value="Envoyer" />
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<!--                        <button type="button" class="btn btn-primary">Save changes</button>-->

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--FIN MODAL-->

    </div>



    <?php
    } // Fin de la boucle des posts
    $req->closeCursor();
    ?>


</div>
<div data-spy="affix" data-offset-top="200" class="col-md-4 sidebar">
    <div class="caption form-group">
        <h2>Write a new post</h2>
        <form method="POST" action="">
            <label>Pseudo</label>
            <input class="form-control" type="text" name="titre" placeholder="Pseudo" /><br/>
            <label>Content</label>
            <textarea class="form-control" type="text" size="70" name="contenu" placeholder="What's on your mind ?" height="50px" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z ])(?!.*\s).*$"></textarea><br/>
            <input class="form-control" type="submit" name="submitpost" value="Envoyer" />

        </form>
    </div>
</div>


<footer>

</footer>
</body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
        <script>
            $(function(){
                $(".flip").on("click",function(){
                    $(this).next().slideToggle();
                });
            });
        </script>

<!--<script>
    $('.sidebar').affix({
        offset: {
                top: 100,
                bottom: function () {
                    return (this.bottom = $('.page-header').outerHeight(true))
                }
        }
    })
</script>-->

</html>