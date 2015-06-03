<?php
	$incs = new internalIncs();
	$incs->head('Accueil');
?>
<div id="first-container" class="fluid-container full-page">
	<?php $this->email(); ?>
	<div id="spinner">
		<img src="<?php echo HTTP_PWD_IMG; ?>spinner.gif" alt="Chargement en cours"/>
	</div>
</div>
<?php
	$incs->footer();
