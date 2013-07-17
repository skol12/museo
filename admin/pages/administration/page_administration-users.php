<?php
require_once('../../config.php');
$active = "administration";
$subactive = "user-liste";
require_once('header.php');

if(isset($_GET['action'])) {
	if($_GET['action'] == "delete") {
		$user = $db->users("users_id", $_GET['id'])->fetch();
		if($user->delete()) print alert_message("Utilisateur supprimé");
		else print alert_message("ID introuvable", "error");
	}
	if($_GET['action'] == "edit" && isset($_POST['users_id'])) {
		$user = $db->users("users_id", $_GET['id'])->fetch();
		$user->update($_POST);
		print alert_message("Utilisateur mis à jour", "secondary");
	}
	elseif($_GET['action'] == "add" && isset($_POST["action"])) {
		$array = array(
			"users_login" => $_POST["users_login"],
			"users_password" => $_POST["users_password"],
			"users_mail" => $_POST["users_mail"],
			"users_nom" => $_POST["users_nom"],
			"users_prenom" => $_POST["users_prenom"],
			"users_date" => $_POST["users_date"]
			);

	if($db->users()->insert($array)) print alert_message("Utiliateur créé", "success");
		else print alert_message("Erreur insertion");
	}
}


if(isset($_GET['action']) && $_GET['action'] == "edit") {

$user = $db->users("users_id", $_GET['id'])->fetch(); //On refetch pour obtenir les informations mises à jour.



	echo '
<form class="pure-form pure-form-aligned" method="post" action="#">
<legend>Modification de : '.$user['users_login'].'</legend>
	<input type="hidden" name="users_id" value="'.$user['users_id'].'">

	<fieldset >
		<div class="pure-control-group">
			<label for="login">Login</label>
			<input type="text" id="login" name="users_login" required placeholder="Login" value="'.$user['users_login'].'">
		</div>

		<div class="pure-control-group">
	        <label for="password">Mot de passe</label>
	        <input type="password" id="password" name="users_password" required placeholder="Mot de passe.." value="'.$user['users_password'].'">
		</div>

		<div class="pure-control-group">
			<label for="mail">Adresse e-mail</label>
			<input type="text" id="mail" name="users_mail" required placeholder="Mail" value="'.$user['users_mail'].'">
		</div>

		<div class="pure-control-group">
			<label for="nom">Nom</label>
			<input type="text" id="nom" name="users_nom" required placeholder="Nom" value="'.$user['users_nom'].'">
		</div>

		<div class="pure-control-group">
			<label for="prenom">Prenom</label>
			<input type="text" id="prenom" name="users_prenom" required placeholder="Prenom" value="'.$user['users_prenom'].'">
		</div>

		<div class="pure-control-group">
			<label for="date">Date de naissance</label>
			<input type="text" id="date" name="users_date" required placeholder="Date" value="'.$user['users_date'].'">
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
					<input type="text" id="nom" name="users_login" required placeholder="login" value="login">
				</div>

				<div class="pure-control-group">
					<label for="password">Password</label>
					<input type="password" id="nom" name="users_password" required placeholder="password" value="Mot de passe">
				</div>

				<div class="pure-control-group">
					<label for="mail">Mail</label>
					<input type="text" id="description" name="users_mail" required placeholder="Description française" value="Description Française">
				</div>

				<div class="pure-control-group">
					<label for="nom">Nom</label>
					<input type="text" id="description" name="users_nom" required placeholder="Nom" value="Nom">
				</div>

				<div class="pure-control-group">
					<label for="prenom">Prenom</label>
					<input type="text" id="description" name="users_prenom" required placeholder="Prenom" value="Prenom">
				</div>

				<div class="pure-control-group">
					<label for="date">Date de naissance</label>
					<input type="text" id="description" name="users_date" required placeholder="Date" value="Date de naissance">
				</div>

				<div class="pure-controls">
					<a href="'.$uri[0].'" class="pure-button pure-button-small pure-button-error">Retour</a>&nbsp;
					<button type="submit" class="pure-button pure-button-small  pure-button-secondary">Ajouter</button>
				</div>
			</fieldset>

	</form>';

} else { ?>

<p class="titre">Liste des utilisateurs</p>
	<a href="?action=add" class="pure-button pure-button-secondary pull-right">Ajouter</a>

<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>Login <i class="pull-right icon-filter"></i></th>
			<th>Mail <i class="pull-right icon-filter"></i></th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php

	foreach ($db->users() as $users) {
		echo '<tr>';
			echo '<td>'.$users['users_login'].'</td>';
			echo '<td>'.$users['users_mail'].'</td>';
			echo '<td>';
				echo '<a href="?action=edit&id='.$users['users_id'].'" class="pure-button pure-button-small pure-button-secondary"><i class="icon-pencil"></i></a>&nbsp;';
				echo '<a href="?action=delete&id='.$users['users_id'].'" class="pure-button pure-button-small pure-button-error" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));"><i class="icon-remove"></i></a>';
			echo '</td>';
		echo '</tr>';
	}

?>
	</tbody>
</table>


<?php
} //fin du if
require_once('footer.php');

?>