<?php
/**
 * page passwords
 */
class passwords extends Controller
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
	 * Cette fonction permet d'afficher la page d'un password
	 * @param int $passwordId : Le numéro du password
	 */
	public function show ($passwordId)
	{
		global $db;

		if (!count($passwords = $db->getFromTableWhere('passwords', ['id' => $passwordId])))
		{
			$router = new Router();
			$router->return404();
		}

		$password = $passwords[0];

		//Si on ne trouve pas de groupe qui corresponde à cet utilisateur et le groupe du password -----> Le password n'appartient pas à l'utilisateur en cours
		if (!count($groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $password['group_id']])))
		{
			$router = new Router();
			$router->return404();
		}

		$password['decrypted'] = passwords::_decryptPassword($password['content']);
		
		return $this->render('passwordsShow', array(
			'password' => $password
		));
	}



	/**
	 * Cette fonction permet de chiffrer un mot de passe à sauvegarder
	 * @param string $password : Le mot de passe à chiffrer
	 * @return string : Le mot de passe chiffré en base64
	 */
	public static function _cryptPassword($password)
	{
		$key = internalTools::aesCrypt($_SESSION['secret_key'], $_SESSION['password']);
		return internalTools::aesCrypt($password, $key);
	}

	/**
	 * Cette fonction permet de dechiffrer un mot de passe à sauvegarder
	 * @param string $password : Le mot de passe à dechiffrer
	 * @return string : Le mot de passe chiffré en base64
	 */
	public static function _decryptPassword($password)
	{
		$key = internalTools::aesCrypt($_SESSION['secret_key'], $_SESSION['password']);
		return internalTools::aesDecrypt($password, $key);
	}
}
