<?php
require_once('../../config.php');
$active = "exposition";
$subactive = "exposition-liste";
require_once('header.php');

if(isset($_GET['action'])) {
	$uniqname = null;

	if($_GET['action'] == "delete") {
		$expositions = $db->expositions("expositions_id", $_GET['id'])->fetch();
		if($expositions->delete()) print alert_message("exposition supprimée");
		else print alert_message("ID introuvable", "error");
	} else if(($_GET['action'] == "edit" || $_GET['action'] == "add") && isset($_POST["action"])) {

		if(!empty($_FILES['expositions_photo']['tmp_name'])) {
			$uniqname = uniqid().'.png';
			$pinguLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($_FILES['expositions_photo']['tmp_name']);

			$pinguLayer->resizeInPixel(null, null, true); //Originale
			$pinguLayer->save("../../assets/img/expositions/origin/", $uniqname, true, null, 95);

			$pinguLayer->cropMaximumInPixel(0, 0, "MM");
			$pinguLayer->resizeInPixel(150, 150);
			$pinguLayer->save("../../assets/img/expositions/150/", $uniqname, true, null, 95);
		}

		$array = array(
			"expositions_nom_fr" => $_POST["expositions_nom_fr"],
			"expositions_nom_en" => $_POST["expositions_nom_en"],
			"expositions_description_fr" => $_POST["expositions_description_fr"],
			"expositions_description_en" => $_POST["expositions_description_en"],
			"expositions_musee" => $_POST["expositions_musee"],
			"expositions_photo" => $uniqname
		);
	}

	if($_GET['action'] == "edit" && isset($_POST['expositions_id'])) {
		$expositions = $db->expositions("expositions_id", $_GET['id'])->fetch();
		if($uniqname == null) $array['expositions_photo'] = $expositions['expositions_photo'];

		$expositions->update($array);
		print alert_message("Exposition mise à jour", "secondary");
	} elseif($_GET['action'] == "add" && isset($_POST["action"])) {
		if($db->expositions()->insert($array)) print alert_message("Exposition créée", "success");
		else print alert_message("Erreur insertion");
	}
}

if(isset($_GET['action']) && $_GET['action'] == "edit") {

$expositions = $db->expositions("expositions_id", $_GET['id'])->fetch(); //On refetch pour obtenir les informations mises à jour.

	echo '

<form class="pure-form pure-form-aligned" method="post" action="#" enctype="multipart/form-data">
<legend>Modification de : '.$expositions['expositions_nom_fr'].'</legend>
	<input type="hidden" name="expositions_id" value="'.$expositions['expositions_id'].'">
	<input type="hidden" name="action" value="edit">

	<fieldset >
		<div class="pure-control-group">
			<label for="nom_fr">Nom Français</label>
			<input type="text" id="nom" class="pure-input-1-2" name="expositions_nom_fr" required placeholder="Nom français" value="'.$expositions['expositions_nom_fr'].'">
		</div>

		<div class="pure-control-group">
			<label for="nom_en">Nom Anglais</label>
			<textarea id="nom" class="pure-input-1-2" name="expositions_nom_en" required placeholder="Nom anglais" value="">'.$expositions['expositions_nom_en'].'</textarea>
		</div>

		<div class="pure-control-group">
	        <label for="description_fr">Description Française</label>
	        <textarea id="description" class="pure-input-1-2" name="expositions_description_fr" required placeholder="Description française">'.$expositions['expositions_description_fr'].'</textarea>
		</div>

		<div class="pure-control-group">
	        <label for="description_en">Description Anglaise</label>
	        <input type="text" id="description" class="pure-input-1-2" name="expositions_description_en" required placeholder="Description anglaise" value="'.$expositions['expositions_description_en'].'">
		</div>

		<div class="pure-control-group">
	       <div class="pure-control-group">
	       		<label for="musee">Musée</label>
	      		<select name="expositions_musee" id="musee" class="pure-u-1-8">
					<option value="Lyon">Lyon</option>
					<option value="Nantes" ';
					if($expositions['expositions_musee']) echo "selected";
					echo '>Nantes</option>
				</select>
			</div>
		</div>

    	<div class="pure-control-group">
    		<label for="expositions_photo">Photo</label>
    		<input type="file" name="expositions_photo" id="expositions_photo"/>
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
	<legend> Ajouter une exposition</legend>
		<input type="hidden" name="action" value="add">

		<fieldset >
			<div class="pure-control-group">
				<label for="nom">Nom Français</label>
				<input type="text" id="nom" class="pure-input-1-2" name="expositions_nom_fr" required placeholder="Nom français" value="Nom Français">
			</div>

			<div class="pure-control-group">
				<label for="nom">Nom Anglais</label>
				<input type="text" id="nom" class="pure-input-1-2" name="expositions_nom_en" required placeholder="Nom anglais" value="Nom Anglais">
			</div>

			<div class="pure-control-group">
				<label for="description_fr">Description Française</label>
				<textarea id="description" class="pure-input-1-2" name="expositions_description_fr" required placeholder="Description française"></textarea>
			</div>
			<div class="pure-control-group">
				<label for="description_en">Description Anglaise</label>
				<textarea id="description" class="pure-input-1-2" name="expositions_description_en" required placeholder="Description anglaise"></textarea>
			</div>

			<div class="pure-control-group">
	       		<label for="musee">Musée</label>
	      		<select name="expositions_musee" id="musee" class="pure-u-1-8">
					<option value="Lyon">Lyon</option>
					<option value="Nantes">Nantes</option>
				</select>
			</div>

	    	<div class="pure-control-group">
	    		<label for="expositions_photo">Photo</label>
	    		<input type="file" name="expositions_photo" id="expositions_photo"/>
			</div>

			<div class="pure-controls">
				<a href="'.$uri[0].'" class="pure-button pure-button-error">Retour</a>&nbsp;
				<button type="submit" class="pure-button   pure-button-secondary">Ajouter</button>
			</div>
		</fieldset>


	</form>';

	} else { ?>

<p class="titre">Liste des expositions</p>
	<a href="?action=add" class="pure-button pure-button-secondary pull-right">Ajouter</a>


<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>Id<i class="pull-right icon-filter"></i></th>
			<th>Photo</th>
			<th>Nom Français<i class="pull-right icon-filter"></i></th>
			<th>Nom Anglais<i class="pull-right icon-filter"></i></th>
			<th>Description Française<i class="pull-right icon-filter"></i></th>
			<th>Description Anglaise<i class="pull-right icon-filter"></i></th>
			<th>Musee<i class="pull-right icon-filter"></i></th>
			<th>Action</th>

		</tr>
	</thead>

	<tbody>

<?php

	foreach ($db->expositions() as $expositions) {
		echo '<tr>';
			echo '<td>'.$expositions['expositions_id'].'</td>';
			echo '<td><a target="_blank" href="'.DIR_PHOTO_EXPOS.'150/'.$expositions['expositions_photo'].'"> <img width="50" height="50" src="'.DIR_PHOTO_EXPOS.'150/'.$expositions['expositions_photo'].'" alt="" title=""></a></td>';
			echo '<td>'.$expositions['expositions_nom_fr'].'</td>';
			echo '<td>'.$expositions['expositions_nom_en'].'</td>';
			echo '<td>'.$expositions['expositions_description_fr'].'</td>';
			echo '<td>'.$expositions['expositions_description_en'].'</td>';
			echo '<td>'.$expositions['expositions_musee'].'</td>';
			echo '<td>';
				echo '<a href="?action=edit&id='.$expositions['expositions_id'].'" class="pure-button pure-button-small pure-button-secondary"><i class="icon-pencil"></i></a>&nbsp;';
				echo '<a href="?action=delete&id='.$expositions['expositions_id'].'" class="pure-button pure-button-small pure-button-error" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));"><i class="icon-remove"></i></a>';
			echo '</td>';
		echo '</tr>';
	}

?>
	</tbody>
</table>
<?php } //fin du if

require_once('footer.php');