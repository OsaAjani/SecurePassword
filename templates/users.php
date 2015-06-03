<div id="users" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups" animation="slideInLeft" ></span>
	<h1>Mon compte</h1>

	<div class="icons-top">
		<span class="control ion-ios-gear-outline" target="<?php secho($this->generateUrl('users', 'edit')); ?>" target-id="users-edit"></span>
		<span class="control ion-ios-close-outline" target="<?php secho($this->generateUrl('users', 'delete')); ?>" target-id="users-delete"></span>
	</div>
	
	<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 infos-container">
		<span class="ion-ios-circle-filled infos-container-round" ></span>
		<span class="ion-ios-person" id="infos-container-users-user" ></span>
		<div class="info">
			<span class="control col-xs-12" target="<?php secho($this->generateUrl('passwords', 'show', [$password['id']])); ?>" target-id="passwords-show">Adresse e-mail</span>
		</div>
		<div class="clearfix"></div>
		<div class="info">
			<span class="control col-xs-12" target="<?php secho($this->generateUrl('passwords', 'show', [$password['id']])); ?>" target-id="passwords-show">Mot de passe</span>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="infos-container-dotted-end col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
		<span class="ion-ios-arrow-thin-down infos-container-arrow-end" ></span>
	</div>
</div>
