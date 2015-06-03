<div id="groups-show" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups" animation="slideInLeft" ></span>
	<h1><?php secho($group['name']); ?></h1>

	<div class="icons-top">
		<span class="control ion-ios-plus-outline" target="<?php secho($this->generateUrl('passwords', 'add')); ?>" target-id="passwords-add"></span>
		<span class="control ion-ios-gear-outline" target="<?php secho($this->generateUrl('groups', 'edit', [$group['id']])); ?>" target-id="groups-edit"></span>
		<span class="control ion-ios-close-outline" target="<?php secho($this->generateUrl('groups', 'delete', [$group['id']])); ?>" target-id="groups-delete"></span>
	</div>

	<?php if (!count($passwords)) { ?>
		<div class="no-data">Pas de données</div>
	<?php } else { ?>	
		<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 infos-container">
			<span class="ion-ios-circle-filled infos-container-round" ></span>
			<span class="ion-ios-locked" id="infos-container-passwords-lock" ></span>
			<?php if (!count($passwords)) { ?>
				<div class="info">
					<span>Vous n'avez pas encore de passwords !</span>
				</div>
			<?php } ?>
			<?php foreach ($passwords as $password) { ?>
				<div class="info">
					<span class="control col-xs-12" target="<?php secho($this->generateUrl('passwords', 'show', [$password['id']])); ?>" target-id="passwords-show"><?php secho($password['name']); ?></span>
				</div>
				<div class="clearfix"></div>
			<?php } ?>
		</div>
		<div class="infos-container-dotted-end col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
			<span class="ion-ios-arrow-thin-down infos-container-arrow-end" ></span>
		</div>
	<?php } ?>
</div>
