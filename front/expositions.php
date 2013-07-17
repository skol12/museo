<?php require 'header.php'; ?>

<div class="checkout">
	<div class="title">
				<div class="wrap">
						<h2 class="first"> Expositions :
						<a href="expositions_musees.php?exposition_musee='Nantes'">Nantes</a> - 
						<a href="expositions_musees.php?exposition_musee='Lyon'">Lyon</a></h2>
				</div>
			</div>
			<div class="table">
				<div class="wrap">

					<div class="rowtitle">
						<span class="name">Nom du produit</span>
						<span class="desc">Description</span>
					</div>

					<?php
					$expositions =$DB->query('select * from museotouch.expositions');
					
					foreach ($expositions as $exposition):

						?>
					<div class="row">
						<a href="expositions_details.php? exposition_id=<?php echo $exposition->expositions_id; ?>" class="img"> 
							<img src="../admin/assets/img/expositions/150/<?php echo $exposition->expositions_photo; ?>" height="53">
						</a>
						
						<span class="name"><?php echo $exposition->{'expositions_nom_'.$_SESSION['langue']};?></span>
						<span class="desc"><?php echo $exposition->{'expositions_description_'.$_SESSION['langue']};?></span>
					</div>
				<?php endforeach; ?>
				</div>

			</div>
</div>

<?php require 'footer.php'; ?>