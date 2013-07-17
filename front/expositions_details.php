<?php require 'header.php'; ?>

<div class="home">
	<div class="row">
		<div class="wrap">
			<?php $eos = $DB->query('select * FROM expositions, objets, expositions_objets WHERE expositions.expositions_id = expositions_objets.expositions_id AND objets.objets_id = expositions_objets.objets_id AND expositions_objets.expositions_id ='.$_GET['exposition_id']); ?>
			<?php foreach ( $eos as $eo ): ?>
				<div class="box">
					<div class="objet full">
						<a href="objets_details.php? objet_id=<?php echo $eo->objets_id; ?>" class="img">
							<img src="../admin/assets/img/objets/origin/<?= $eo->objets_photo; ?>" width="261" height="261">
						</a>
						<div class="description">
							<?= $eo->{'objets_nom_'.$_SESSION['langue']}; ?>
							
						</div>
						</a>

						<a class="add addPanier" href="addpanier.php?objets_id=<?= $eo->objets_id; ?>">
							add
						</a>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>



<?php require 'footer.php'; ?>