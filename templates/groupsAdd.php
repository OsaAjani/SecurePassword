<div id="groups-add" class="tile">
	<span class="go-back-arrow control ion-ios-arrow-thin-left" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups" animation="slideInLeft" ></span>
	<h1>Ajouter un groupe</h1>
	
	<form class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 add-form ajax-form" method="POST" action="<?php secho($this->generateUrl('groups', 'create')); ?>" target="<?php secho($this->generateUrl('groups')); ?>" target-id="groups">
		<input class="col-xs-12 textual-input" type="text" value="" name="name" placeholder="Nom du groupe" />
		<div class="clearfix"></div>
		<br/>
		<br/>
		<input class="button" type="submit" value="Ajouter" />
	</div>
</div>
