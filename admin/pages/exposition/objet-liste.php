<?php
require_once('../../config.php');
$active = "exposition";
$subactive = "objet-liste";
require_once('header.php');

if(@$_POST['action'] == "add_props" && isset($_POST["objets_id"])) {
	$array = array(
		"objets_id" => $_POST["objets_id"],
		"objets_props_nom_fr" => $_POST["objets_props_nom_fr"],
		"objets_props_nom_en" => $_POST["objets_props_nom_en"],
		"objets_props_value_fr" => $_POST["objets_props_value_fr"],
		"objets_props_value_en" => $_POST["objets_props_value_en"],
		);
	if($db->objets_props()->insert($array)) print alert_message("Ajout de la propriété de l'objet", "success");
	else print alert_message("Erreur insertion");

} else if(isset($_GET['action'])) {
	$uniqname = null;

	if($_GET['action'] == "delete") {
		$objets = $db->objets("objets_id", $_GET['id']);
		if($objets->delete()) print alert_message("objet supprimée");
		else print alert_message("ID introuvable", "error");

	} else if(($_GET['action'] == "edit" || $_GET['action'] == "add") && isset($_POST["action"])) {

		if(!empty($_FILES['objets_photo']['tmp_name'])) {
			$uniqname = uniqid().'.png';
			$pinguLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($_FILES['objets_photo']['tmp_name']);

			$pinguLayer->resizeInPixel(null, null, true); //Originale
			$pinguLayer->save("../../assets/img/objets/origin/", $uniqname, true, null, 95);

			$pinguLayer->cropMaximumInPixel(0, 0, "MM");
			$pinguLayer->resizeInPixel(150, 150);
			$pinguLayer->save("../../assets/img/objets/150/", $uniqname, true, null, 95);
		}

		$array = array(
			"objets_nom_fr" => $_POST["objets_nom_fr"],
			"objets_nom_en" => $_POST["objets_nom_en"],
			"objets_description_fr" => $_POST["objets_description_fr"],
			"objets_description_en" => $_POST["objets_description_en"],
			"objets_photo" => $uniqname
		);
	}
	if($_GET['action'] == "edit" && isset($_POST['objets_id'])) {
		$objets = $db->objets("objets_id", $_GET['id'])->fetch();
		if($uniqname == null) $array['objets_photo'] = $objets['objets_photo'];

		$objets->update($array);
		print alert_message("Objet mis à jour", "secondary");
	} elseif($_GET['action'] == "add" && isset($_POST["action"])) {
		if($db->objets()->insert($array)) print alert_message("Objet créée", "success");
		else print alert_message("Erreur insertion");
	}
}



if(isset($_GET['action']) && $_GET['action'] == "edit") {

$objets = $db->objets("objets_id", $_GET['id'])->fetch(); //On refetch pour obtenir les informations mises à jour.

echo '

<form class="pure-form pure-form-aligned" method="post" action="#" enctype="multipart/form-data">
<legend>Modification de : '.$objets['objets_nom_fr'].'</legend>
<input type="hidden" name="objets_id" value="'.$objets['objets_id'].'">
<input type="hidden" name="action" value="edit">
<fieldset >
	<div class="pure-control-group">
		<label for="nom">Nom Français</label>
		<input type="text" id="nom" name="objets_nom_fr" class="pure-input-1-2" required placeholder="Nom français" value="'.$objets['objets_nom_fr'].'">
	</div>

	<div class="pure-control-group">
		<label for="nom">Nom Anglais</label>
		<input type="text" id="nom" name="objets_nom_en" class="pure-input-1-2" required placeholder="Nom anglais" value="'.$objets['objets_nom_en'].'">
	</div>

	<div class="pure-control-group">
		<label for="description_fr">Description Française</label>
		<textarea id="description_fr" class="pure-input-1-2" name="objets_description_fr" required placeholder="Description Française">'.$objets['objets_description_fr'].'</textarea>
	</div>

	<div class="pure-control-group">
		<label for="description_en">Description Anglaise</label>
		<textarea id="description_en" class="pure-input-1-2" name="objets_description_en" required placeholder="Description anglaise">'.$objets['objets_description_en'].'</textarea>
	</div>

	<div class="pure-control-group">
		<label for="objets_photo">Photo</label>
		<input type="file" name="objets_photo" id="objets_photo"/>
	</div>

	<div class="pure-controls">
		<a href="'.$uri[0].'" class="pure-button pure-button-error">Retour</a>&nbsp;
		<button type="submit" class="pure-button pure-button-secondary">Modifier</button>
	</div>
</fieldset>

</form>';

echo '<hr>';
echo '<div class="pure-g">';
	echo '<div class="pure-u-1-2">';

	echo '<p>Ajout une propriété à l\'objet :</p>';
	echo '<form class="pure-form pure-form-aligned" method="post" action="#" enctype="multipart/form-data">';
		echo '<input type="hidden" name="action" value="add_props">';
		echo '<input type="hidden" name="objets_id" value="'.$objets['objets_id'].'">';

		echo '<div class="pure-control-group">';
			echo '<label for="objets_props_nom_fr">Nom Français</label>';
			echo '<input type="text" id="objets_props_nom_fr" name="objets_props_nom_fr" class="pure-input-1-2" required placeholder="Nom français">';
		echo '</div>';
		echo '<div class="pure-control-group">';
			echo '<label for="objets_props_nom_en">Nom Anglais</label>';
			echo '<input type="text" id="objets_props_nom_en" name="objets_props_nom_en" class="pure-input-1-2" required placeholder="Nom Anglais">';
		echo '</div>';

		echo '<div class="pure-control-group">';
			echo '<label for="objets_props_value_fr">Valeur Française</label>';
			echo '<textarea id="objets_props_value_fr" class="pure-input-1-2" name="objets_props_value_fr" required placeholder="Valeur Française"></textarea>';
		echo '</div>';
		echo '<div class="pure-control-group">';
			echo '<label for="objets_props_value_en">Valeur Anglaise</label>';
			echo '<textarea id="objets_props_value_en" class="pure-input-1-2" name="objets_props_value_en" required placeholder="Valeur Anglaise"></textarea>';
		echo '</div>';
		echo '<div class="pure-controls"><button type="submit" class="pure-button pure-button-secondary">Ajouter</button></div>';
	echo '</form>';
	echo '</div>';
echo '</div>';
echo "<hr>";
echo '<p>Liste des propriétés : </p>';
foreach ($objets->objets_props() as $objets_props) {
	echo "<b>Nom FR </b> : " . $objets_props['objets_props_nom_fr']."<br>";
	echo "<b>Nom EN : </b>" . $objets_props['objets_props_nom_en']."<br>";
	echo "<b>Valeur FR : </b>" . $objets_props['objets_props_value_fr']."<br>";
	echo "<b>Valeur EN : </b>" . $objets_props['objets_props_value_en']."<br>";
	echo "<hr>";
}

} elseif(isset($_GET['action']) && $_GET['action'] == "add") {

	echo '

	<form class="pure-form pure-form-aligned" method="post" action="#" enctype="multipart/form-data">
	<legend>Ajout objet :</legend>
	<input type="hidden" name="action" value="add">

	<fieldset >
	<div class="pure-control-group">
	<label for="nom">Nom Français</label>
	<input type="text" id="nom" name="objets_nom_fr" class="pure-input-1-2" required placeholder="Nom français">
	</div>

	<div class="pure-control-group">
	<label for="nom">Nom Anglais</label>
	<input type="text" id="nom" name="objets_nom_en" class="pure-input-1-2" required placeholder="Nom anglais">
	</div>

	<div class="pure-control-group">
		<label for="description_fr">Description Française</label>
		<textarea id="description_fr" class="pure-input-1-2" name="objets_description_fr" required placeholder="Description Française"></textarea>
	</div>

	<div class="pure-control-group">
		<label for="description_en">Description Anglaise</label>
		<textarea id="description_en" class="pure-input-1-2" name="objets_description_en" required placeholder="Description anglaise"></textarea>
	</div>

	<div class="pure-control-group">
		<label for="objets_photo">Photo</label>
		<input type="file" name="objets_photo" id="objets_photo"/>
	</div>

	<div class="pure-controls">
	<a href="'.$uri[0].'" class="pure-button pure-button-error">Retour</a>&nbsp;
	<button type="submit" class="pure-button pure-button-secondary">Ajouter</button>
	</div>
	</fieldset>

	</form>';

} else { ?>

<p class="titre">Liste des objets</p>
	<a href="?action=add" class="pure-button pure-button-secondary pull-right">Ajouter</a>


<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>ID<i class="pull-right icon-filter"></i></th>
			<th>Photo</th>
			<th>Nom Français<i class="pull-right icon-filter"></i></th>
			<th>Nom Anglais<i class="pull-right icon-filter"></i></th>
			<th>Description Française<i class="pull-right icon-filter"></i></th>
			<th>Description Anglaise<i class="pull-right icon-filter"></i></th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

		<?php

		foreach ($db->objets() as $objets) {
			echo '<tr>';
			echo '<td>'.$objets['objets_id'].'</td>';
			echo '<td><a target="_blank" href="'.DIR_PHOTO_OBJETS.'150/'.$objets['objets_photo'].'"> <img width="50" height="50" src="'.DIR_PHOTO_OBJETS.'150/'.$objets['objets_photo'].'" alt="" title=""></a></td>';

			echo '<td>'.$objets['objets_nom_fr'].'</td>';
			echo '<td>'.$objets['objets_nom_en'].'</td>';
			echo '<td>'.$objets['objets_description_fr'].'</td>';
			echo '<td>'.$objets['objets_description_en'].'</td>';
			echo '<td>';
			echo '<a href="?action=edit&id='.$objets['objets_id'].'" class="pure-button pure-button-small pure-button-secondary"><i class="icon-pencil"></i></a>&nbsp;';
			echo '<a href="?action=delete&id='.$objets['objets_id'].'" class="pure-button pure-button-small pure-button-error" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));"><i class="icon-remove"></i></a>';
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