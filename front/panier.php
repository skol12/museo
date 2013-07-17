<?php require 'header.php'; ?>

<div class="checkout">
	<div class="title">
		<div class="wrap">
			<h2 class="first">Panier</h2>
				<a href ="panier_partage.php" class="proceed">
					Partager
				</a>
		</div>
	</div>
			<div class="table">
				<div class="wrap">

					<div class="rowtitle">
						<span class="name">Nom du produit</span>
						<span class="description">Description</span>
						<span class="action">Actions</span>
					</div>

					<?php
					$variable =array_keys($_SESSION['panier']);
					if (empty($variable)) {
						$objets = array();
					}else{
						$objets =$DB->query('select * from museotouch.objets WHERE objets_id IN('.implode(',',$variable).')');
					}
					foreach ($objets as $objet):
					?>

					<div class="row">
						<a href="objets_details.php? objet_id=<?php echo $objet->objets_id; ?>" class="img"> <img src="../admin/assets/img/objets/origin/<?= $objet->objets_photo; ?>" height="53"></a>
						<span class="name"><?php echo $objet->{'objets_nom_'.$_SESSION['langue']};?></span>
						<span class="description"><?php echo $objet->{'objets_description_'.$_SESSION['langue']}; ?></span>
						<span class="action">
							<a href="panier.php?delPanier=<?php echo $objet->objets_id; ?>" class="del"><img src="img/del.png"></a>
						</span>
					</div>
				<?php endforeach; ?>
				<div class="rowtotal">
						Total : <span id="total"><?php echo $panier->count(); ?> Objet(s)</span>
					</div>
				</div>
				</div>
	</div>
</div>

<?php require 'footer.php'; ?>
