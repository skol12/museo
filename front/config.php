<?php

	require 'vendor/autoload.php';
	require_once('tools/fonctions.php');
	$path = __DIR__."/includes/";
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

	define('BRAND', 'Erasme');
	define('BRAND_CLEAN', strtolower(preg_replace("/[^a-z]+/i", "-", BRAND)));


if(preg_match('/wamp/', $_SERVER['DOCUMENT_ROOT'])) {
	define('DEBUG', true);
	define('BASE_URL', '/museo/front/');
	define('DB_NAME', 'museotouch');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB', '127.0.0.1');
} 


	/* Configuration générales du BO */

	$menu_links = array(
		$link1 = array(
				"nom" => 'Nantes',
				"href" => "nantes",
				"level_required" => 0,
				"active" => 'nantes' ),
		$link2 = array(
				"nom" => 'Lyon',
				"href" => "lyon",
				"level_required" => 0,
				"active" => 'lyon' )
				);

	$menu_links_lyon = array(
		$link1 = array(
				"nom" => 'Accueil',
				"href" => "",
				"level_required" => 0,
				"active" => 'accueil' ),
		$link2 = array(
				"nom" => 'Exposition',
				"href" => "lyon/exposition",
				"level_required" => 0,
				"active" => 'page_exposition_lyon' ),
		$link3 = array(
				"nom" => 'Administration',
				"href" => "../admin",
				"level_required" => 0,
				"active" => 'administration' )

	);
	
	$menu_links_nantes = array(
		$link1 = array(
				"nom" => 'Accueil',
				"href" => "",
				"level_required" => 0,
				"active" => 'accueil' ),
		$link2 = array(
				"nom" => 'Exposition',
				"href" => "nantes/exposition",
				"level_required" => 0,
				"active" => 'page_exposition_nantes' ),
		$link3 = array(
				"nom" => 'Administration',
				"href" => "../admin",
				"level_required" => 0,
				"active" => 'administration' )
	);

	


	$active = "";
	$html = "";

	$_POST = array_map('strip_tags', $_POST);
	$_GET = array_map('strip_tags', $_GET);
	$_POST = array_map('stripslashes', $_POST);
	$_GET = array_map('stripslashes', $_GET);

	//Pour se deconnecter
	if(@$_GET['action'] == "deco"){
		session_destroy();
		header("Location: ".BASE_URL);
	}

	$db = connect();