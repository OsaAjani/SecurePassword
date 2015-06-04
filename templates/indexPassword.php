<div id="index-password" class="landing-page tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('index', 'email')); ?>" target-id="index-email" animation="slideInLeft" ></span>
	<h1>Secure Password</h1>
	<h2>Un stockage centralisé et sécurisé en AES</h2>
	
	<div class="col-xs-12 col-md-6 col-md-offset-3">	
		<form action="<?php secho($this->generateUrl('connexion', 'checkPassword')); ?>" method="POST" class="col-xs-10 col-xs-offset-1 ajax-form" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups">

			<div class="input-group">
				<input name="password" id="password" class="form-control input-lg" placeholder="Votre mot de passe" type="password">
				<span class="input-group-btn"><button id="button-login-email" class="btn btn-lg btn-primary">Connexion</button></span>
			</div>
		</form>
	</div>
</div>
