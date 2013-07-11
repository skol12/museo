<?php
require_once('../../config.php');
$active = "nantes";
require_once('header.php');

if(isset($_GET['action'])) {
	if($_GET['action'] == "delete") {
		$exposition = $db->expositions("expositions_id", $_GET['id'])->fetch();
		if($exposition->delete()) print alert_message("Utilisateur supprimé");
		else print alert_message("ID introuvable", "error");
	}
	if($_GET['action'] == "edit" && isset($_POST['expositions_id'])) {
		$exposition = $db->expositions("expositions_id", $_GET['id'])->fetch();
		$exposition->update($_POST);
		print alert_message("Utilisateur mis à jour", "secondary");
	}
	elseif($_GET['action'] == "add" && isset($_POST["action"])) {
		$array = array( 
			"expositions_login" => $_POST["expositions_login"],
			"expositions_password" => $_POST["expositions_password"],
			"expositions_mail" => $_POST["expositions_mail"],
			"expositions_nom" => $_POST["expositions_nom"],
			"expositions_prenom" => $_POST["expositions_prenom"],
			"expositions_date" => $_POST["expositions_date"]
			); 

	if($db->expositions()->insert($array)) print alert_message("Utiliateur créé", "success");
		else print alert_message("Erreur insertion");
	}
}


if(isset($_GET['action']) && $_GET['action'] == "edit") {

$exposition = $db->expositions("expositions_id", $_GET['id'])->fetch(); //On refetch pour obtenir les informations mises à jour.



	echo '
<form class="pure-form pure-form-aligned" method="post" action="#">
<legend>Modification de : '.$exposition['expositions_login'].'</legend>
	<input type="hidden" name="expositions_id" value="'.$exposition['expositions_id'].'">

	<fieldset >
		<div class="pure-control-group">
			<label for="login">Login</label>
			<input type="text" id="login" name="expositions_login" required placeholder="Login" value="'.$exposition['expositions_login'].'">
		</div>

		<div class="pure-control-group">
	        <label for="password">Mot de passe</label>
	        <input type="password" id="password" name="expositions_password" required placeholder="Mot de passe.." value="'.$exposition['expositions_password'].'">
		</div>

		<div class="pure-control-group">
			<label for="mail">Adresse e-mail</label>
			<input type="text" id="mail" name="expositions_mail" required placeholder="Mail" value="'.$exposition['expositions_mail'].'">
		</div>

		<div class="pure-control-group">
			<label for="nom">Nom</label>
			<input type="text" id="nom" name="expositions_nom" required placeholder="Nom" value="'.$exposition['expositions_nom'].'">
		</div>

		<div class="pure-control-group">
			<label for="prenom">Prenom</label>
			<input type="text" id="prenom" name="expositions_prenom" required placeholder="Prenom" value="'.$exposition['expositions_prenom'].'">
		</div>

		<div class="pure-control-group">
			<label for="date">Date de naissance</label>
			<input type="text" id="date" name="expositions_date" required placeholder="Date" value="'.$exposition['expositions_date'].'">
		</div>

		<div class="pure-controls">
		    <a href="'.$uri[0].'" class="pure-button pure-button-small pure-button-error">Retour</a>&nbsp;
			<button type="submit" class="pure-button pure-button-small  pure-button-secondary">Modifier</button>
		</div>
	</fieldset>

</form>';
}

elseif(isset($_GET['action']) && $_GET['action'] == "add") {


	echo '
	
	<form class="pure-form pure-form-aligned" method="post" action="#">
		<legend>Ajout utilisateur :</legend>
			<input type="hidden" name="action" value="add">

			<fieldset >
				<div class="pure-control-group">
					<label for="nom">Login</label>
					<input type="text" id="nom" name="expositions_login" required placeholder="login" value="login">
				</div>

				<div class="pure-control-group">
					<label for="password">Password</label>
					<input type="password" id="nom" name="expositions_password" required placeholder="password" value="Mot de passe">
				</div>

				<div class="pure-control-group">
					<label for="mail">Mail</label>
					<input type="text" id="description" name="expositions_mail" required placeholder="Description française" value="Description Française">
				</div>

				<div class="pure-control-group">
					<label for="nom">Nom</label>
					<input type="text" id="description" name="expositions_nom" required placeholder="Nom" value="Nom">
				</div>

				<div class="pure-control-group">
					<label for="prenom">Prenom</label>
					<input type="text" id="description" name="expositions_prenom" required placeholder="Prenom" value="Prenom">
				</div>

				<div class="pure-control-group">
					<label for="date">Date de naissance</label>
					<input type="text" id="description" name="expositions_date" required placeholder="Date" value="Date de naissance">
				</div>

				<div class="pure-controls">
					<a href="'.$uri[0].'" class="pure-button pure-button-small pure-button-error">Retour</a>&nbsp;
					<button type="submit" class="pure-button pure-button-small  pure-button-secondary">Ajouter</button>
				</div>
			</fieldset>

	</form>';

} else { ?>

<h1>Liste des expositions de Nantes</h1>

<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>Nom Français<i class="pull-right icon-filter"></i></th>
			<th>Nom Anglais</th>
			<th>Description Français</th>
			<th>Description Anglais</th>
		</tr>
	</thead>
	<tbody>
<?php

	foreach ($db->expositions() as $expositions) {
		echo '<tr>';
			echo '<td>'.$expositions['expositions_nom_fr'].'</td>';
			echo '<td>'.$expositions['expositions_nom_en'].'</td>';
			echo '<td>'.$expositions['expositions_description_fr'].'</td>';
			echo '<td>'.$expositions['expositions_description_en'].'</td>';
		echo '</tr>';
	}

?>
	</tbody>
</table>


<?php
} //fin du if
require_once('footer.php');

?>