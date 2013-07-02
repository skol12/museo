<?php
require_once('../../config.php');
$active = "administration";
require_once('header.php');

if(isset($_GET['action'])) {
	$user = $db->users("users_id", $_GET['id'])->fetch();
	if($_GET['action'] == "delete") {
		if($user->delete()) print alert_message("Utilisateur supprimé");
		else print alert_message("ID introuvable", "error");
	}
	if($_GET['action'] == "edit" && isset($_POST['users_id'])) {
		$user->update($_POST);
		print alert_message("Utilisateur mis à jour", "secondary");
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

		<div class="pure-controls">
		    <a href="'.$uri[0].'" class="pure-button pure-button-small pure-button-error">Retour</a>&nbsp;
			<button type="submit" class="pure-button pure-button-small  pure-button-secondary">Modifier</button>
		</div>
	</fieldset>

</form>';

} else { ?>

<h1>Liste des utilisateurs</h1>

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