    <?php
include('header.php');
?>
    <br/>
<br/>

	<div class="caption form-group col-md-6">
		<h2>Connectez-vous</h2>
		<form method="POST" action="validation.php">
			<label>Pseudo</label>
			<input class="form-control" type="text" name="pseudo" placeholder="Pseudo" /><br/>
			<label>Mot de passe</label>
			<input class="form-control" type="text" size="10" name="password" placeholder="Mot de passe" /><br/>
			<input class="form-control" type="submit" name="submit" value="Connectez-vous" />

		</form>
	</div>


	<div class="caption form-group col-md-6">
		<h2>ou Inscrivez-vous</h2>
		<form method="POST" action="signin.php">
			<label>Pseudo</label>
			<input class="form-control" type="text" name="pseudo" placeholder="Pseudo" /><br/>
			<label>Mot de passe</label>
			<input class="form-control" type="text" size="10" name="password" placeholder="Mot de passe" /><br/>
			<input class="form-control" type="submit" name="submit" value="Inscrivez-vous" />

		</form>
	</div>