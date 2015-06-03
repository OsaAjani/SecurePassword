<div id="passwords-edit" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('passwords', 'show', [$password['id']])); ?>" target-id="passwords-show" animation="slideInLeft" ></span>
	<h1>Modifier le password : <?php secho($password['name']); ?></h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('passwords', 'update', [$password['id'], $_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('passwords', 'show', [$password['id']])); ?>" target-id="passwords-show">
		<input class="col-xs-12 textual-input" type="text" value="<?php secho($password['name']) ?>" name="name" placeholder="Nom du password" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="<?php secho($password['decrypted']) ?>" name="password" placeholder="Mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="<?php secho($password['decrypted']) ?>" name="verif_password" placeholder="Vérification du mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<br/>
		<input class="button" type="submit" value="Modifier" />
	</div>
</div>
