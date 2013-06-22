<?php

	require_once('config.php');
	require_once('header.php');

	$message = "";
	if (empty($_SESSION['User']['users_login'])) {
		if(!empty($_POST['connexion'])) {
			$password = sha1($_POST['password']);
			if(!user_connexion($_POST['login'], $password)) {
				$message = "Login/Password incorrect";
			} else {
				header("Location: ".BASE_URL);
			}
		}
	} else {
		echo "welcome";
		exit();
	}
?>

<div class="header pure-u-1">
	<form class="pure-form pure-form-stacked" method="post" action="<?=BASE_URL?>" style="margin-top: 150px;">

			<input type="hidden" name="connexion" value="1">
	    <fieldset>
	        <legend>Museo Touch Administration</legend>
	        <div class="yui3-alert-error"><?=$message?></div>

<div class="pure-g">
 <div class="pure-u-1-8">
			<label for="login">Login</label>
	        <input type="text" id="login" name="login" placeholder="Login">

	        <label for="password">Mot de passe</label>
	        <input type="password" name="password" placeholder="Password">


	        <button type="submit" class="pure-button pure-button-secondary" style="margin-top:10px">Connexion</button>
	        </div> </div>
	    </fieldset>
	</form>
</div>

