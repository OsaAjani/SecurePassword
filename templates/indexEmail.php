<div id="index-email" class="landing-page tile">
	<h1>Secure Password</h1>
	<h2>Un stockage centralisé et sécurisé en AES</h2>

	<div class="col-xs-12 col-md-6 col-md-offset-3">	
		<form action="<?php secho($this->generateUrl('connexion', 'checkEmail')); ?>" method="POST" id="landing_form_email" class="col-xs-10 col-xs-offset-1 ajax-form" target="<?php secho($this->generateUrl('index', 'password')); ?>" target-id="index-password">
			<?php if ($emailsend) { ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Un e-mail de validation de compte vous a été envoyé !
				</div>
			<?php } ?>

			<div class="input-group">
				<input name="email" id="email" class="form-control input-lg" placeholder="Votre adresse e-mail" type="text">
				<span class="input-group-btn"><button id="button-login-email" class="btn btn-lg btn-primary">OK</button></span>
			</div>
			<span class="no-account control" target="<?php secho('inscription'); ?>" target-id="inscription">Pas encore de compte ?</span>
		</form>
	</div>
</div>
