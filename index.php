
<?php
include('header_book.php');
// Connexion à la base de données
include('config.php');
echo'
<h4>Leave a comment on the district you like</h4><br/>
';

// On récupère les 5 derniers billets
$req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

while ($donnees = $req->fetch())
{
    ?>
    <div class="news">
        <h3>
            <?php echo htmlspecialchars($donnees['titre']); ?>
        </h3>

        <p>
            <?php
            // On affiche le contenu du billet
            echo nl2br(htmlspecialchars($donnees['contenu']));
            ?>
            <br />
            <em><a href="comment.php?billet=<?php echo $donnees['id']; ?>">Leave a comment here !</a></em>
        </p>
    </div>
<?php
} // Fin de la boucle des billets
$req->closeCursor();
?>


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
        <!-- <p style="font-family: helvetica; font-size:15px;">Note: Don't write any apostrophe (')</p> -->
        <small><a href="../index.php">&lt;  Return to the list</a></small><br/><br/>
        <div style="font-size:15px;"><a href="../../paris_backoffice">Administration</a></div>

    </div>




</div>



</body>
</html>
