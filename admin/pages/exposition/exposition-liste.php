<?php
require_once('../../config.php');
$active = "exposition";
require_once('header.php');


if(isset($_GET['action'])) {

	if($_GET['action'] == "delete") {
		$expositions = $db->expositions("expositions_id", $_GET['id'])->fetch();
		if($expositions->delete()) print alert_message("exposition supprimée");
		else print alert_message("ID introuvable", "error");
	}
	if($_GET['action'] == "edit" && isset($_POST['expositions_id'])) {
		$expositions = $db->expositions("expositions_id", $_GET['id'])->fetch();
		$expositions->update($_POST);
		print alert_message("Exposition mise à jour", "secondary");
	}
	elseif($_GET['action'] == "add" && isset($_POST["action"])) {
		$array = array(
			"expositions_nom_fr" => $_POST["expositions_nom_fr"],
			"expositions_nom_en" => $_POST["expositions_nom_en"],
			"expositions_description_fr" => $_POST["expositions_description_fr"],
			"expositions_description_en" => $_POST["expositions_description_en"]
			);

		if($db->expositions()->insert($array)) print alert_message("Exposition créée", "success");
		else print alert_message("Erreur insertion");
	}
}


if(isset($_GET['action']) && $_GET['action'] == "edit") {

$expositions = $db->expositions("expositions_id", $_GET['id'])->fetch(); //On refetch pour obtenir les informations mises à jour.



	echo '

<form class="pure-form pure-form-aligned" method="post" action="#">
<legend>Modification de : '.$expositions['expositions_nom_fr'].'</legend>
	<input type="hidden" name="expositions_id" value="'.$expositions['expositions_id'].'">

	<fieldset >
		<div class="pure-control-group">
			<label for="nom">Nom Français</label>
			<input type="text" id="nom" name="expositions_nom_fr" required placeholder="Nom français" value="'.$expositions['expositions_nom_fr'].'">
		</div>

		<div class="pure-control-group">
			<label for="nom">Nom Anglais</label>
			<input type="text" id="nom" name="expositions_nom_en" required placeholder="Nom anglais" value="'.$expositions['expositions_nom_en'].'">
		</div>

		<div class="pure-control-group">
	        <label for="password">Description Française</label>
	        <input type="text" id="description" name="expositions_description_fr" required placeholder="Description française" value="'.$expositions['expositions_description_fr'].'">
		</div>

		<div class="pure-control-group">
	        <label for="password">Description Anglaise</label>
	        <input type="text" id="description" name="expositions_description_en" required placeholder="Description anglaise" value="'.$expositions['expositions_description_en'].'">
		</div>

		<div class="pure-controls">
		    <a href="'.$uri[0].'" class="pure-button pure-button-small pure-button-error">Retour</a>&nbsp;
			<button type="submit" class="pure-button pure-button-small  pure-button-secondary">Modifier</button>
		</div>
	</fieldset>

</form>';

}


if(isset($_GET['action']) && $_GET['action'] == "add") {


	echo '

	<form class="pure-form pure-form-aligned" method="post" action="#">
	<legend>Ajout exposition :</legend>
		<input type="hidden" name="action" value="add">

		<fieldset >
			<div class="pure-control-group">
				<label for="nom">Nom Français</label>
				<input type="text" id="nom" name="expositions_nom_fr" required placeholder="Nom français" value="Nom Français">
			</div>

			<div class="pure-control-group">
				<label for="nom">Nom Anglais</label>
				<input type="text" id="nom" name="expositions_nom_en" required placeholder="Nom anglais" value="Nom Anglais">
			</div>

			<div class="pure-control-group">
				<label for="description_fr">Description Française</label>
				<input type="text" id="description" name="expositions_description_fr" required placeholder="Description française" value="Description Française">
			</div>

			<div class="pure-control-group">
				<label for="description_en">Description Anglaise</label>
				<input type="text" id="description" name="expositions_description_en" required placeholder="Description anglaise" value="Description Anglaise">
			</div>

			<div class="pure-controls">
				<a href="'.$uri[0].'" class="pure-button pure-button-small pure-button-error">Retour</a>&nbsp;
				<button type="submit" class="pure-button pure-button-small  pure-button-secondary">Ajouter</button>
			</div>
		</fieldset>

	</form>';

	}
	else { ?>

<h1>Liste des expositions</h1>

<a href="?action=add" class="pure-button pure-button-small pure-button-secondary">Ajouter</a>&nbsp;

<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>ID <i class="pull-right icon-filter"></i></th>
			<th>Nom Français<i class="pull-right icon-filter"></i></th>
			<th>Nom Anglais<i class="pull-right icon-filter"></i></th>
			<th>Description Française<i class="pull-right icon-filter"></i></th>
			<th>Description Anglaise<i class="pull-right icon-filter"></i></th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>

<?php

	foreach ($db->expositions() as $expositions) {
		echo '<tr>';
			echo '<td>'.$expositions['expositions_id'].'</td>';
			echo '<td>'.$expositions['expositions_nom_fr'].'</td>';
			echo '<td>'.$expositions['expositions_nom_en'].'</td>';
			echo '<td>'.$expositions['expositions_description_fr'].'</td>';
			echo '<td>'.$expositions['expositions_description_en'].'</td>';
			echo '<td>';
				echo '<a href="?action=edit&id='.$expositions['expositions_id'].'" class="pure-button pure-button-small pure-button-secondary"><i class="icon-pencil"></i></a>&nbsp;';
				echo '<a href="?action=delete&id='.$expositions['expositions_id'].'" class="pure-button pure-button-small pure-button-error" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));"><i class="icon-remove"></i></a>';
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