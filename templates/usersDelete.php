<div id="users-delete" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('users')); ?>" target-id="users" animation="slideInLeft" ></span>
	<h1>Supprimer le compte <?php secho($user['email']) ?></h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('users', 'destroy', [$_SESSION['csrf']])); ?>">
		<div class="confirm-delete">Êtes-vous sûr de vouloir supprimer votre compte ?</div>

		<div class="button goto col-xs-5" target="<?php secho($this->generateUrl('users')); ?>" target-id="users" animation="slideInLeft">Annuler</div>
		<input class="button col-xs-5 col-xs-offset-2" type="submit" value="Supprimer" />
	</div>
</div>
