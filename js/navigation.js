/**
 * Ce script contient les fonctions permettant le chargement d'une page
 */

/**
 * Page formulaire password
 */
function showIndexPasswords ()
{
	jQuery('#spinner').show();
	jQuery.get(HTTP_PWD + 'index/password/', function (data)
	{
		jQuery('#first-container').append(data);
	}).success(function ()
	{
		changeTile(jQuery('#index-password'), 'slideInRight');
	}).done(function ()
	{
		jQuery('#spinner').hide();
	});
}

/**
 * Page groups
 */
function showGroups()
{
	jQuery('#spinner').show();
	jQuery.get(HTTP_PWD + 'groups/', function (data)
	{
		jQuery('#first-container').append(data);
	}).success(function ()
	{
		changeTile(jQuery('#groups'), 'slideInRight');
	}).done(function ()
	{
		jQuery('#spinner').hide();
	});
}

/**
 * Page Passwords of groups
 */
function showPasswordsOfGroup(target)
{
	jQuery('#spinner').show();
	jQuery.get(target.attr('href'), function (data)
	{
		jQuery('#first-container').append(data);
	}).success(function ()
	{
		changeTile(jQuery('#groups-show'), 'slideInRight');
	}).done(function ()
	{
		jQuery('#spinner').hide();
	});
}
