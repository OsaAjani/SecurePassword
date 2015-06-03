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
		return $this->render('indexEmail');
	}

	/**
	 * Page du formulaire de password
	 */
	public function password ()
	{
		return $this->render('indexPassword');
	}
}
