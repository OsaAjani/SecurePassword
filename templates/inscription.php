<div id="inscription" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('index', 'email')); ?>" target-id="index-email" animation="slideInLeft" ></span>
	<h1>Création de compte</h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('inscription', 'create', [$_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('index', 'email') . '?emailsend=1'); ?>" target-id="index-email">
		<input class="col-xs-12 textual-input" type="email" value="" name="email" placeholder="Adresse e-mail" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="email" value="" name="verif_email" placeholder="Vérification adresse e-mail" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="" name="password" placeholder="Mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="" name="verif_password" placeholder="Vérification du mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<br/>
		<input class="button" type="submit" value="Valider" />
	</div>
</div>
