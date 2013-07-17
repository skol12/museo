<?php

require '_header.php';
?><!DOCTYPE html>

<html>
<head>
	<title>ERASME - Museo</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
</head>

<body>
<div id="header">
	<div class="wrap">
		<div class="menu">
				<a href="index.php" class="logo">ERASME</a>
				<h1>Bienvenue chez Museotouch</h1>
				<ul class="panier">
					<li class="caddie"><a href="panier.php">Panier </a></li>
					<li class="items">
						ARTICLES
						<span id="count"><?php echo $panier->count(); ?></span>
					</li>
					<li class="langue">LANGUES
						<span>
							<a href='switch_lang.php?langue=fr'> <img src="img\drapeau-fr.png"> </a>
							<a href='switch_lang.php?langue=en'> <img src="img\drapeau-en.png"> </a>
						</span>
					</li>
				</ul>
		</div>
	</div>
</div>

<div id="subheader">
	<div class="wrap">
		<h2>Bienvenue aux visiteurs : <a href="../admin/index.php">Login</a></h2>
	</div>
</div>


<div id="wrap">

	<div id="menu">
		<ul class="wrap">
			<li> <a href="index.php">Accueil</a> </li>
			<li> <a href="expositions.php">Expositions</a> </li>
		</ul>
	</div>
