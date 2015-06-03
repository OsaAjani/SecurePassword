<div id="passwords-delete" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups', 'show', [$password['group_id']])); ?>" target-id="groups-show" animation="slideInLeft" ></span>
	<h1><?php secho($password['name']) ?></h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('passwords', 'destroy', [$password['id'], $_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('groups', 'show', [$password['group_id']])); ?>" target-id="groups-show">
		<div class="confirm-delete">Êtes-vous sûr de vouloir supprimer ce password ?</div>

		<div class="button goto col-xs-5" target="<?php secho($this->generateUrl('passwords', 'show', [$password['id']])); ?>" target-id="passwords-show" animation="slideInLeft">Annuler</div>
		<input class="button col-xs-5 col-xs-offset-2" type="submit" value="Supprimer" />
	</div>
</div>
