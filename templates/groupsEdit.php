<div id="groups-edit" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show" animation="slideInLeft" ></span>
	<h1>Modifier le groupe : <?php secho($group['name']); ?></h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('groups', 'update', [$group['id'], $_SESSION['csrf']])); ?>" target="<?php secho($this->generateUrl('groups', 'show', [$group['id']])); ?>" target-id="groups-show">
		<input class="col-xs-12 textual-input" type="text" value="<?php secho($group['name']); ?>" name="name" placeholder="Nom du groupe" />
		<div class="clearfix"></div>
		<br/>
		<br/>
		<input class="button" type="submit" value="Modifier" />
	</div>
</div>
