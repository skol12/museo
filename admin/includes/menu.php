<?php

if(!empty($_SESSION['User']['users_login'])) { ?>

<div class="header pure-u-1">
	<div class="pure-menu pure-menu-open pure-menu-fixed pure-menu-horizontal">

		<ul>
			<?php
			foreach ($menu_links as $link) {
				if($link['level_required'] <= @$_SESSION['User']['level']){
					echo '<li';
					if(in_array($link['active'], explode('/', $_SERVER['REQUEST_URI']))) echo ' class="pure-menu-selected" ';
					echo '><a href="'.BASE_URL.$link['href'].'">'.$link['nom'].'</a>
					</li>';
				}
			}
			?>
			<li class="pull-right"><a href="<?=BASE_URL?>?action=deco">Deconnexion</a></li>
		</ul>
	</div>
</div>



<div class="pure-u" id="menu">
	<div class="pure-menu pure-menu-open">
		<a class="pure-menu-heading" href="<?=BASE_URL?>" style="">Erasme</a>
		<ul>

			<?php
			if(in_array($active, explode('/', $_SERVER['REQUEST_URI']))) { 

				foreach (${"menu_links_".$active} as $link) {
					if($link['level_required'] <= @$_SESSION['User']['level']){
						echo '<li';
						if(in_array($link['active'], explode('/', $_SERVER['REQUEST_URI']))) echo ' class="pure-menu-selected" ';
						echo '><a href="'.BASE_URL.$link['href'].'">'.$link['nom'].'</a>
						</li>';
					}
				}
			}
			?>

		</ul>
	</div>
</div>



<?php } ?>