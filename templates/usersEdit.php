<div id="users-edit" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('users')); ?>" target-id="users" animation="slideInLeft" ></span>
	<h1>Modifier votre compte</h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('users', 'update', [$_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('users')); ?>" target-id="users">
		<input class="col-xs-12 textual-input" type="email" value="<?php secho($user['email']); ?>" name="email" placeholder="Adresse e-mail" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="" name="password" placeholder="Mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="" name="verif_password" placeholder="Vérification du mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<br/>
		<input class="button" type="submit" value="Modifier" />
	</div>
</div>
