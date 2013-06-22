<?php

	require 'vendor/autoload.php';
	require_once('tools/fonctions.php');
	$path = __DIR__."/includes/";
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

	define('BRAND', 'Erasme');
	define('BRAND_CLEAN', strtolower(preg_replace("/[^a-z]+/i", "-", BRAND)));


if(preg_match('/wamp/', $_SERVER['DOCUMENT_ROOT'])) {
	define('DEBUG', true);
	define('BASE_URL', '/museo/');
	define('DB_NAME', "museotouch");
	define('DB_USER', "klaitos");
	define('DB_PASSWORD', "");
	define('DB', '127.0.0.1');
} else {
	define('DEBUG', false);
	define('BASE_URL', '/');
	define('DB_NAME', "christopherbrookes_museotouch");
	define('DB_USER', "34417");
	define('DB_PASSWORD', "password");
	define('DB', 'mysql.alwaysdata.com');

}

	session_start();



	if($_SERVER["REQUEST_URI"] != BASE_URL) //Toutes pages sauf l'accueil
		if(!empty($_SESSION['User']['users_password']) && !empty($_SESSION['User']['users_login'])){ //La session existe on va check le user voir s'il est toujours valid
			if(!user_verif($_SESSION['User']['users_login'], $_SESSION['User']['users_password'])) header("Location: ".BASE_URL); //mauvais user
		}else if(strlen($_COOKIE['cookie_user'])>0 && strlen($_COOKIE['cookie_password'])>0){ //Pas de session, on regarde dans les cookies si le user est toujours valid,
			if(!user_verif($_COOKIE['User']['users_login'], $_COOKIE['User']['users_password'])) header("Location: ".BASE_URL); //mauvais user
		}else{
			header("Location: ".BASE_URL);
		}




	/* Configuration générales du BO */

	$menu_links = array(
		$link1 = array(
				"nom" => 'Exposition',
				"href" => "exposition",
				"level_required" => 0,
				"active" => 'exposition' ),
		$link2 = array(
				"nom" => 'Administration',
				"href" => "administration",
				"level_required" => 0,
				"active" => 'administration' )
	);

	$menu_links_admin = array(
		$link1 = array(
				"nom" => 'Utilisateurs',
				"href" => "administration/users",
				"level_required" => 0,
				"active" => 'users' ),
		$link2 = array(
				"nom" => 'Droits',
				"href" => "administration/droits",
				"level_required" => 0,
				"active" => 'droits' )
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