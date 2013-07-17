<?php
require 'db.class.php';
require 'panier.class.php';
$DB = new DB();
$panier = new panier($DB);

if(empty($_SESSION['langue']))
	$_SESSION['langue'] = 'fr';

?> 