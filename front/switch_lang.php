<?php require 'header.php'; ?>

<?php


	$langue = $_GET['langue']; 
	if($langue == "fr" || $langue == "en") 
   			$_SESSION['langue'] = $langue; 


header('Location:'.$_SERVER['HTTP_REFERER']);

?>

<?php require 'footer.php'; ?>