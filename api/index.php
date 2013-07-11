<?php

require 'config.php';

$app->get("/", function () use ($app, $db) {
	echo 'api home';
});



//Liste des expositions
$app->get("/v1/expos", function () use ($app, $db) {
	$app->response()->header("Content-Type", "application/json");
	$expos = array();
	foreach ($db->expositions()->where('expositions_valid', 1) as $expo) {
		$expos[] = array(
			"expo_id" => $expo['expositions_id'],
			"expo_nom_fr" => $expo['expositions_nom_fr']
			);
	}
	echo json_encode(array("expos" => $expos));
});

$app->run();