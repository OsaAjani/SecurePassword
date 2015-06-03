<div id="passwords-add" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show" animation="slideInLeft" ></span>
	<h1>Ajouter un password à <?php secho($group['name']); ?></h1>
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('passwords', 'create', [$group['id'], $_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show">
		<input class="col-xs-12 textual-input" type="text" value="" name="name" placeholder="Nom du password" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="" name="password" placeholder="Mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<input class="col-xs-12 textual-input" type="password" value="" name="verif_password" placeholder="Vérification du mot de passe" />
		<div class="clearfix"></div>
		<br/>
		<br/>
		<input class="button" type="submit" value="Ajouter" />
	</div>
</div>
