<div id="passwords-show" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups', 'show', [$password['group_id']])); ?>" target-id="groups-show" animation="slideInLeft" ></span>
	<h1><?php secho($password['name']); ?></h1>

	<div class="icons-top">
		<span class="control ion-ios-copy-outline" id="copy-password" ></span>
		<span class="control ion-ios-gear-outline" target="<?php secho($this->generateUrl('passwords', 'edit', [$password['id']])); ?>" target-id="passwords-edit"></span>
		<span class="control ion-ios-close-outline" target="<?php secho($this->generateUrl('passwords', 'delete', [$password['id']])); ?>" target-id="passwords-delete"></span>
	</div>
	
	<h2 id="decrypted-password" class="text-center"><?php secho($password['decrypted']); ?></h2>
</div>
