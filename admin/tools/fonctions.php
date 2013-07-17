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

function alert_message($message, $type = "success") {
	return '<div class="yui3-alert  yui3-alert-'.$type.'">'.$message.'</div>';
}

function URI() {
	return explode("?", $_SERVER['REQUEST_URI']);
}

function get_objets_dispo($expos_id) {
	$db = connect_pdo();
	$sth = $db->prepare('
		SELECT objets_id, objets_nom_fr, objets_photo
		FROM objets
		WHERE objets_valid = 1
		AND objets_id NOT IN (
		    SELECT objets_id
		    FROM expositions_objets
		    WHERE expositions_id = :expo_id
		)'
	);
	$sth->bindValue('expo_id', $expos_id, PDO::PARAM_STR);
	$sth->execute();
	$db = null;
	return $sth;
}

function get_objets_pasdispo($expos_id) {
	$db = connect_pdo();
	$sth = $db->prepare('
		SELECT objets_id, objets_nom_fr, objets_photo
		FROM objets
		WHERE objets_valid = 1
		AND objets_id IN (
		    SELECT objets_id
		    FROM expositions_objets
		    WHERE expositions_id = :expo_id
		)'
	);
	$sth->bindValue('expo_id', $expos_id, PDO::PARAM_STR);
	$sth->execute();
	$db = null;
	return $sth;
}

function create_liste_objets_dispo($expos_id) {
	$objets_dispo = get_objets_dispo($expos_id);
	$html ='<div class="pure-control-group">';
  		$html .= '<select name="objets_id" id="add_item">';
  		if(!$objets_dispo->rowCount()) echo '<option value="0">Aucun objet</option>';
  		while($objet = $objets_dispo->fetchObject()) {
  			$html .='<option value="'.$objet->objets_id.'">'.$objet->objets_nom_fr.'</option>';
  		}
		$html .= '</select> ';
		$html .= ' <button type="submit" class="pure-button pure-button-secondary">Ajouter</button>';
	$html .= '</div>';
	return $html;
}


function create_liste_objets_pasdispo($expos_id, $uri) {
	$objets_dispo = get_objets_pasdispo($expos_id);
	$html ='<ul>';
  		while($objet = $objets_dispo->fetchObject()) {
  			echo '<li><img src="'.DIR_PHOTO_OBJETS.'150/'.$objet->objets_photo.'" alt="" width="50" height="50" /> '.$objet->objets_nom_fr.'<a onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));" href="'.$uri.'?action=deleteObjet&id='.$objet->objets_id.'&id_expo='.$expos_id.'"> <i class="icon-remove"></i></a></li>';
  		}
	$html .= '</ul>';
	return $html;
}
