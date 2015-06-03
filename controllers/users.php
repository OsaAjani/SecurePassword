<?php
/**
 * page users
 */
class users extends Controller
{
	public function before ()
	{
		if (!isset($_SESSION['connected']) || !$_SESSION['connected'])
		{
			header('Location: ' . HTTP_PWD);
			die();
		}
	}

	/**
	 * Cette fonction permet d'afficher la page du compte utilisateur
	 */
	public function byDefault ()
	{
		global $db;

		if (!count($users = $db->getFromTableWhere('users', ['user_id' => $_SESSION['user_id']])))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render("users", array(
			'user' => $users[0],
		));
	}
}
