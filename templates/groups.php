<div id="groups" class="tile">
	<a class="go-back-arrow ion-ios-close-outline hover-color" href="<?php secho($this->generateUrl('connexion', 'logout')); ?>"></a>
	<h1>Mes groupes de passwords</h1>

	<div class="icons-top">
		<span class="control ion-ios-plus-outline" target="<?php secho($this->generateUrl('groups', 'add')); ?>" target-id="groups-add"></span>
		<span id="icon-user" class="control ion-ios-person-outline" target="<?php secho($this->generateUrl('users')); ?>" target-id="users"></span>
	</div>
	
	<?php if (!count($groups)) { ?>
		<div class="no-data">Pas de données</div>
	<?php } else { ?>
		<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 infos-container">
			<span class="ion-ios-circle-filled infos-container-round" ></span>
			<span class="ion-ios-eye" id="infos-container-groups-eye" ></span>
			<?php foreach ($groups as $group) { ?>
				<div class="info">
					<span class="control col-xs-12" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show"><?php secho($group['name']); ?></span>
				</div>
				<div class="clearfix"></div>
			<?php } ?>
		</div>
		<div class="infos-container-dotted-end col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
			<span class="ion-ios-arrow-thin-down infos-container-arrow-end" ></span>
		</div>
	<?php } ?>
</div>
