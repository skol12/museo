<?php



function connect_pdo() {
	try{
		$db=new PDO('mysql:host='.DB.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
	}catch(Exception $e){
		echo 'Erreur : '.$e->getMessage().'<br />';
		echo 'N° : '.$e->getCode();
	}
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec('SET CHARACTER SET utf8');

	return $db;
}

function connect() {
	//Customisation structure de la bdd
	$structure = new NotORM_Structure_Convention(
		$primary = '%s_id',
		$foreign = '%s_id',
		$table = '%s',
		$prefix = ''
		);

	return new NotORM(connect_pdo(), $structure);
}



function user_connexion($login, $password) {
	$result = user_verif($login, $password);

	if(!$result){
		session_destroy();
		setcookie("cookie_user","", time() - 3600); 
		setcookie("cookie_password","", time() - 3600); 
		return false;
	} else {
		$expire = 365*24*3600;
		setcookie("cookie_user", $login, time()+$expire); 
		setcookie("cookie_password", $password, time()+$expire);
		$_SESSION['User'] = array(
			'users_login' => $result['users_login'],
			'users_id' => $result['users_id'],
			'users_password' => $result['users_password']
			);
		return true;
	}
}

function user_verif($login, $password) {
	$db = connect();
	$user = $db->users()->where("users_login", $login)->where("users_password", $password);

	if($data = $user->fetch()) {
		return $data;
	}
	return false; //user invalid ou inexistant
}

function page_404() {
	return $page404 = json_encode(array(
		"error_code" => '404',
		"error_msg" => "Not Found"
		));
}

function generate_item_array($item) {
	return array(
		"objet_id" => $item['objets_id'],
		"objets_nom_fr" => $item['objets_nom_fr'],
		"objets_nom_en" => $item['objets_nom_en'],
		"objets_desc_fr" => $item['objets_description_fr'],
		"objets_desc_en" => $item['objets_description_en']
	);
}

function generate_expo_array($expo, $items = array()) {
	$array = array(
		"expo_id" => $expo['expositions_id'],
		"expo_nom_fr" => $expo['expositions_nom_fr'],
		"expo_nom_en" => $expo['expositions_nom_en'],
		//"expo_nom_fr" => $expo['expositions_nom_fr'],
		"objets" => $items
	);

	return $array;
}
