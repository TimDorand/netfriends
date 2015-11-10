<?php
    include('header_book.php');
    // Connexion à la base de données
   include('config.php');

    // Récupération du billet
    $req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
    $req->execute(array($_GET['billet']));
    $donnees = $req->fetch();
    ?>

    <div class="news">
        <h3>
            <?php echo htmlspecialchars($donnees['titre']); ?>
           <!-- <em>le <?php // echo $donnees['date_creation_fr']; ?></em>-->
        </h3>

        <p>
            <?php
            echo nl2br(htmlspecialchars($donnees['contenu']));
            ?>
        </p>
        <br/>

</div>
<br/>
<div class="commentaires">

    <h3>Commentaires</h3>
    <br/>
    <?php
    $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête

    // Récupération des commentaires
    $req = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
    $req->execute(array($_GET['billet']));

    while ($donnees = $req->fetch())
    {
        ?>
        <p><strong><?php echo htmlspecialchars($donnees['auteur']); ?></strong><!--le <?php// echo $donnees['date_commentaire_fr']; ?></p> -->
        <div class="commentaire"><p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?><br/>________<br/></p></div>
    <?php
    } // Fin de la boucle des commentaires
    $req->closeCursor();
    ?>
</div><div class="espace"><br/></div>

<div class="formulaire">
    <form action="comment_post.php?billet=<?php echo $_GET['billet']; ?>" method="post">
        <br/>
        <input type="text" name="auteur" placeholder="The username">
        <br/><br/>
        <textarea name="commentaire" rows="5" placeholder="Your comment"></textarea>
        <br/><br/>
        <input type="submit" value="Add your comment">
    </form>
    </div>

  <!-- <ul>
  <a href="marais.html"><li>Marais | <small>2th district</small></li></a>
       <a href="st_michel.html"><li>St-Michel | <small>5th district</small></li> </a>
     <li><a href="bastille.html">Bastille | </a><small>11th district</small></li>
     <li><a href="hippolyte_maindron.html">Hippolyte Maindron | </a><small>14th district</small></li>
     <li><a href="mirabeau.html">Mirabeau | </a><small>15th district</small></li>
     <li><a href="buttes-aux-cailles.html">Buttes-aux-Cailles | </a><small>13th district</small></li>
   </ul>
<br/><br/><br/><br/><br/><br/> -->
   <small><a href="index.php">&lt;  Return to the articles </a></small><br/><br/>
<div style="font-size:15px;"><a href="../../paris_backoffice">Administration</a></div>

 </div>
 



</div>



</body>
</html>
