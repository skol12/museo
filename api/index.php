<?php

require 'config.php';
/**
 * Génération du token, dans l'idéal il faudrait le stocker en base de données et vérifier sa validité à chaque web services, on simplifie içi !
 */
$app->get("/v1/login", function () use ($app, $db) {
	$token = uniqid(md5(rand()), true); //On génère un token pour identifiant l'utilisateur (notamment lorsqu'il va créer un panier)
	echo json_encode(array('token' => $token));
});

/**
 * Liste des expositions, il ne faut pas renvoyer toutes les infos, juste celle nécessaire à l'affichage
 */
$app->get("/v1/expos", function () use ($app, $db) {
	$expos = array();
	foreach ($db->expositions()->where('expositions_valid', 1) as $expo) {
		$expos[] = generate_expo_array($expo);
	}
	echo json_encode($expos);
});

/**
 * Fiche détaillée d'une exposition
 */
$app->get("/v1/expos/:id", function ($id) use ($app, $db) {
	$expo = $db->expositions()->where('expositions_valid', 1)->where('expositions_id', $id)->fetch();
	if($expo) {
		$expo_objets = array();
		foreach ($expo->expositions_objets()->select('objets.*') as $expo_objet) { //On va chercher tout les objets associés à l'exposition {id} pour les stocker dans le tableau $expo_objets
			$expo_objets[] = generate_item_array($expo_objet);
		}

		echo json_encode(generate_expo_array($expo, $expo_objets));
	} else {
		echo page_404();
	}
});


/**
 * Liste des objets, il ne faut pas renvoyer toutes les infos, juste celle nécessaire à l'affichage
 */
$app->get("/v1/objets", function () use ($app, $db) {
	$objets = array();
	foreach ($db->objets()->where('objets_valid', 1) as $objet) {
		$objets[] = generate_item_array($objet);
	}
	echo json_encode(array("objets" => $objets));
});

/**
 * Fiche détaillé d'un objet
 */
$app->get("/v1/objets/:id", function ($id) use ($app, $db) {
	$objet = $db->objets()->where('objets_valid', 1)->where('objets_id', $id)->fetch();
	if($objet) {
		echo json_encode(generate_item_array($objet));
	} else {
		echo page_404();
	}
});

/**
 * Recherche d'objet par leur nom FR & EN
 */
$app->get("/v1/objets/search", function () use ($app, $db) {
	$data = $app->request()->get(); //Récupération des paramètres GET
	$value = "%".$data['value']."%";

	$objets = array();
	foreach ($db->objets()
		->where('objets_valid', 1)
		->where("objets_nom_fr LIKE ? OR objets_nom_en LIKE ?", $value, $value) as $objet) {  //On va rechercher tout les objets dont le nom_fr ou nom_en contient le mot recherché ($value)
		$objets[] = generate_item_array($objet);
	}
	echo json_encode($objets);
});

/**
 * Ajout d'un objet dans le panier
 */
$app->post("/v1/paniers/add", function () use ($app, $db) {
	$data = $app->request()->post(); //Récupération des paramètres POST
	$token = $data['token'];
	$objet_id = $data['objet_id'];

	echo json_encode($objets);
});


/**
 * Récupération d'un panier
 */
$app->post("/v1/paniers", function () use ($app, $db) {
	$data = $app->request()->post(); //Récupération des paramètres POST
	$token = $data['token'];
	$password = $data['password'];
	$panier = $db->baskets()->where('paniers_valid', 1)->where('paniers_token', $token)->fetch();
	if(!$panier) {
		return json_encode(array(
			"error_code" => '#1',
			"error_msg" => "Le panier est vide"
		));
	} elseif($panier['paniers_private'] && $panier['paniers_password'] != $password) {
		return json_encode(array(
			"error_code" => '#2',
			"error_msg" => "Mauvais password"
		));
	} else {
		echo "panier ok";
	}
	echo json_encode($objets);
});

$app->run();