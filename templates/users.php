<div id="users" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups" animation="slideInLeft" ></span>
	<h1>Mon compte</h1>

	<div class="icons-top">
		<span class="control ion-ios-gear-outline" target="<?php secho($this->generateUrl('users', 'edit')); ?>" target-id="users-edit"></span>
		<span class="control ion-ios-close-outline" target="<?php secho($this->generateUrl('users', 'delete')); ?>" target-id="users-delete"></span>
	</div>
	<h2 id="user-email" class="text-center"><?php secho($user['email']); ?></h2>
</div>
