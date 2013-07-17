<?php
require '_header.php';
$json = array('error' => true);
if(isset($_GET['objets_id'])){
	$objet = $DB->query('SELECT objets_id from museotouch.objets where objets_id=:objets_id', array('objets_id' => $_GET['objets_id']));
	if (empty($objet)) {
		$json['message'] = "Ce produit n'existe pas";
	}
	$panier->add($objet[0]->objets_id);
	$json['error'] = false; //Cela veut dire qu'il n'y a pas eu d'erreurs
	$json['count'] = $panier->count();

	$json['message'] = 'Le produit a bien ete ajoute a votre panier';
}else{
	$json['message'] = "Vous n'avez pas selectionne de produit dans votre panier";
}
echo json_encode($json);
?>