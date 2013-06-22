<?php
require_once('../../config.php');
$active = "administration";

require_once('header.php');
?>

<h1>Liste des utilisateurs</h1>

<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>Login</th>
			<th>Mail</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
<?php

	foreach ($db->users() as $users) {
		echo '<tr>';
			echo '<td>'.$users['users_login'].'</td>';
			echo '<td>'.$users['users_mail'].'</td>';
			echo '<td>';
				echo '<button type="submit" class="pure-button pure-button-small pure-button-secondary">Modifier</button>&nbsp;';
				echo '<button type="submit" class="pure-button pure-button-small pure-button-error"><i class="icon-remove"></i></button>';
			echo '</td>';
		echo '</tr>';
	}

?>
	</tbody>
</table>


<?php
require_once('footer.php');

?>