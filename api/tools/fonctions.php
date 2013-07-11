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
