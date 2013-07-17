<?php require 'header.php'; ?>

<div class="objet">
	<div class="objet_title">
		<div class="wrap">
				<h2 class="first">Objet</h2>
		</div>
	</div>
		<div class="objet_table">
			<div class="wrap">
				<div class="objet_rowtitle">
					<span class="image">Image</span>
					<span class="name">Nom <? echo $_SESSION['langue'];?></span>
					<span class="description">Description <? echo $_SESSION['langue'];?></span>
					<span class="action">Action</span>
				</div>
			<?php $objets = $DB->query('select * FROM objets WHERE objets.objets_id ='.$_GET['objet_id']); ?>
			<?php foreach ( $objets as $objet ): ?>

				<div class="objet_row">

					<span class="image">
						<img src="../admin/assets/img/objets/origin/<?= $objet->objets_photo; ?>" width="261" height="261">
					</span>
					<span class="name">
						<?= $objet->{'objets_nom_'.$_SESSION['langue']}; ?>
					</span>
					<span class="description">
							<?= $objet->{'objets_description_'.$_SESSION['langue']}; ?>
					</span>
					<span class="action">
						<a class="add addPanier" href="addpanier.php?objets_id=<?= $objet->objets_id; ?>">
							Add
						</a>
					</span>
				</div>
			<?php endforeach ?>
			</div>
		</div>
</div>



<?php require 'footer.php'; ?>