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

if(!empty($_POST['submitcomm'])) {
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

// Empty pour n'envoyer des réponses à la bdd que si $errors est vide !

if(!empty($_POST['submit'])) {
    $id_comments = $_POST['id_comments'];
    $interloc = $_POST['interloc'];
    $reponse = $_POST['reponse'];

    $reponse =  $_POST['reponse'];
    $errors = [];

    if(empty($reponse)) {
        $errors = "Interlocuteur requis !";
    }
    if(empty($interloc)) {
        $errors = "Réponse requise !";
    }

    if(empty($errors)) {
        addReply($bdd, $id_comments, $interloc, $reponse);
    }
}

?>





<div class="col-md-8">
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



        // On récupère les 5 derniers posts
        $req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 10');

        // Boucle pour récupérer les posts
        while ($post = $req->fetch())
        {
        ?>

            <!--SHOW POSTS-->
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
    // Récupération des commentaires
    $req1 = $bdd->prepare('SELECT id, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire_fr FROM comments WHERE id_billet = ? ORDER BY date_commentaire');
    $req1->execute(array($post['id']));

    //Boucle des commentaires
    while ($comment = $req1->fetch())
    {
        ?>

<!--SHOW COMMENTS-->
        <div class="thumbnail">
<p><strong><?php echo htmlspecialchars($comment['auteur']); ?></strong> le <?php echo $comment['date_commentaire_fr']; ?></p>
<p><?php echo nl2br(htmlspecialchars($comment['commentaire'])); ?></p>
        </div>
        <?php
        // Récupération des réponse
        $req2 = $bdd->prepare('SELECT interloc, reponse, DATE_FORMAT(date_reponse, \'%d/%m/%Y\') AS date_reponse_fr FROM reply WHERE id_comments = ? ORDER BY date_reponse');
        $req2->execute(array($comment['id']));

        //Boucle des réponses
        while ($reply = $req2->fetch())
        {
            ?>

            <!--SHOW REPLY-->
<div class="reply">
            <p><strong><?php echo htmlspecialchars($reply['interloc']); ?></strong> le <?php echo $reply['date_reponse_fr']; ?></p>
            <p><?php echo nl2br(htmlspecialchars($reply['reponse'])); ?></p>

</div>



            <?php
        } // Fin de la boucle des commentaires
        $req2->closeCursor();
        ?>
        <!--ADD REPLY--><br/>
        <form class="reply" method="POST" action="">
            <label>Reply</label><br/>
            <input class="form-horizontal" type="text"  name="interloc" placeholder="Author" /><br/>
            <input class="form-horizontal" type="text" size="70" name="reponse" placeholder="Can you reply ?" /><br/>
            <input type="hidden" value="<?php echo $comment['id']; ?>" name="id_comments">
            <input class="btn btn-default" type="submit" name="submit" value="Envoyer" />
        </form>


    <?php
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
                        <h4 class="modal-title">Add a comment</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <label>Auteur</label>
                            <input class="form-control" type="text" name="auteur" placeholder="Auteur" /><br/>
                            <label>Content</label>
                            <input class="form-control" type="text" size="70" name="commentaire"  placeholder="What's on your mind ?" /><br/>
                            <input type="hidden" value="<?php echo $post['id']; ?>" name="id_post">
                            <input class="form-control btn-primary" type="submit" name="submitcomm" value="Envoyer" />
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


<div class="thumbnail col-md-3 sidebar " data-spy="affix" data-offset-top="200" >
    <div class="caption form-group">
        <h2 style="color:white">Write a new post</h2>
        <form method="POST" action="">
            <label>Pseudo</label>
            <input class="form-control" type="text" name="titre" placeholder="Pseudo" /><br/>
            <label>Content</label>
            <textarea class="form-control" type="text" size="70" name="contenu" placeholder="What's on your mind ?" height="50px"></textarea><br/>
            <input class="form-control" type="submit" name="submitpost" value="Send" />

        </form>
    </div>
</div>



<footer  style="bottom:0;">
    <div class="container">
        <p class="muted credit">Développé par <a href="http://www.timothee-dorand.fr">Timothée Dorand</a> and <a href="http://melissagreu.fr">Melissa Greu</a>. Version 1.1</p>
    </div>
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

</html>