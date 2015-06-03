<div id="groups-delete" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show" animation="slideInLeft" ></span>
	<h1><?php secho($group['name']) ?></h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('groups', 'destroy', [$group['id'], $_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups">
		<div class="confirm-delete">Êtes-vous sûr de vouloir supprimer ce groupe ?</div>

		<div class="button goto col-xs-5" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show" animation="slideInLeft">Annuler</div>
		<input class="button col-xs-5 col-xs-offset-2" type="submit" value="Supprimer" />
	</div>
</div>
