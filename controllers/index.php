<?php
/**
 * page d'index
 */
class index extends Controller
{
	//Pour ajouter du cache, ajouter un attribut :
	//public $cache_nomMethode = durée_cache_en_minute;

	/**
	 * Page d'index par défaut
	 */	
	public function byDefault ()
	{
		return $this->render("index");
	}

	/**
	 * Page du formulaire d'email
	 */
	public function email ()
	{
		$emailsend = !empty($_GET['emailsend']) ? $_GET['emailsend'] : false;

		return $this->render('indexEmail', array(
			'emailsend' => $emailsend
		));
	}

	/**
	 * Page du formulaire de password
	 */
	public function password ()
	{
		return $this->render('indexPassword');
	}
}
