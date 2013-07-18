<?php
require_once('../../config.php');
$active = "musee";
$subactive = "musee";
require_once('header.php');

if(isset($_GET['action'])) {
	$uniqname = null;

	if($_GET['action'] == "delete") {
		$musees = $db->musees("musees_id", $_GET['id']);
		if($musees->delete()) print alert_message("musee supprimé");
		else print alert_message("ID introuvable", "error");

	} else if(($_GET['action'] == "edit" || $_GET['action'] == "add") && isset($_POST["action"])) {

		$array = array(
			"musees_nom" => $_POST["musees_nom"],
		);
	}
	if($_GET['action'] == "edit" && isset($_POST['musees_id'])) {
		$musees = $db->musees("musees_id", $_GET['id'])->fetch();

		$musees->update($array);
		print alert_message("musee mis à jour", "secondary");
	} elseif($_GET['action'] == "add" && isset($_POST["action"])) {
		if($db->musees()->insert($array)) print alert_message("musee créé", "success");
		else print alert_message("Erreur insertion");
	}
}



if(isset($_GET['action']) && $_GET['action'] == "edit") {

$musees = $db->musees("musees_id", $_GET['id'])->fetch(); //On refetch pour obtenir les informations mises à jour.

echo '

<form class="pure-form pure-form-aligned" method="post" action="#" enctype="multipart/form-data">
<legend>Modification de : '.$musees['musees_nom'].'</legend>
<input type="hidden" name="musees_id" value="'.$musees['musees_id'].'">
<input type="hidden" name="action" value="edit">
<fieldset >
	<div class="pure-control-group">
		<label for="nom">Nom</label>
		<input type="text" id="nom" name="musees_nom" class="pure-input-1-2" required placeholder="Nom du musee" value="'.$musees['musees_nom'].'">
	</div>
<div class="pure-controls">
<a href="'.$uri[0].'" class="pure-button pure-button-error">Retour</a>&nbsp;
<button type="submit" class="pure-button pure-button-secondary">Modifier</button>
</div>
</fieldset>

</form>';

} elseif(isset($_GET['action']) && $_GET['action'] == "add") {

	echo '

	<form class="pure-form pure-form-aligned" method="post" action="#" enctype="multipart/form-data">
	<legend>Ajout musee :</legend>
	<input type="hidden" name="action" value="add">

	<fieldset >
	<div class="pure-control-group">
	<label for="nom">Nom</label>
	<input type="text" id="nom" name="musees_nom" class="pure-input-1-2" required placeholder="Nom du musee" value="">
	</div>

	<div class="pure-controls">
	<a href="'.$uri[0].'" class="pure-button pure-button-error">Retour</a>&nbsp;
	<button type="submit" class="pure-button pure-button-secondary">Ajouter</button>
	</div>
	</fieldset>

	</form>';

} else { ?>

<p class="titre">Liste des musees</p>
	<a href="?action=add" class="pure-button pure-button-secondary pull-right">Ajouter</a>


<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>ID<i class="pull-right icon-filter"></i></th>
			<th>Nom <i class="pull-right icon-filter"></i></th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

		<?php

		foreach ($db->musees() as $musees) {
			echo '<tr>';
			echo '<td>'.$musees['musees_id'].'</td>';

			echo '<td>'.$musees['musees_nom'].'</td>';
			echo '<td>';
			echo '<a href="?action=edit&id='.$musees['musees_id'].'" class="pure-button pure-button-small pure-button-secondary"><i class="icon-pencil"></i></a>&nbsp;';
			echo '<a href="?action=delete&id='.$musees['musees_id'].'" class="pure-button pure-button-small pure-button-error" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));"><i class="icon-remove"></i></a>';
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