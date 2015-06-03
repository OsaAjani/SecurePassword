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

		if (!$passwords = $db->getFromTableWhere('passwords', ['id' => $passwordId]))
		{
			$router = new Router();
			$router->return404();
		}

		$password = $passwords[0];

		//Si on ne trouve pas de groupe qui corresponde à cet utilisateur et le groupe du password -----> Le password n'appartient pas à l'utilisateur en cours
		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $password['group_id']]))
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
	 * Cette fonction permet d'afficher la page d'ajout d'un password
	 * @param int $groupId : Le numéro du groupe dans lequel ajouter un password
	 */
	public function add ($groupId)
	{
		global $db;

		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId]))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render('passwordsAdd', array(
			'group' => $groups[0]
		));
	}

	/**
	 * Cette fonction permet d'enregistrer un nouveau password
	 * @param string $groupId : L'id du groupe dans lequel ajouter le password
	 * @param $csrf : Le jeton CSRF
	 * @param $_POST['name'] : Le nom du password à ajouter
	 * @param $_POST['password'] : Le contenu du password à ajouter
	 * @param $_POST['verif_password'] : La vérification du contenu du password
	 */
	public function create ($groupId, $csrf)
	{
		global $db;
		$result = array(
			'success' => 1,
			'error' => '',
		);

		if (!internalTools::verifyCSRF($csrf))
		{
			$result['success'] = 0;
			$result['error'] = 'Jeton CSRF invalide !';
			echo json_encode($result);
			return false;
		}

		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Le groupe dans lequel vous souhaitez ajouter un password n\'existe pas !';
			echo json_encode($result);
			return false;
		}

		if (empty($_POST['name']) || empty($_POST['password']) || empty($_POST['verif_password']))
		{
			$result['success'] = 0;
			$result['error'] = 'Remplissez tous les champs.';
			echo json_encode($result);
			return false;
		}

		if ($_POST['password'] != $_POST['verif_password'])
		{
			$result['success'] = 0;
			$result['error'] = 'Les mots de passe ne correspondent pas !';
			echo json_encode($result);
			return false;
		}

		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Le groupe dans lequel vous souhaitez ajouter un password n\'existe pas !';
			echo json_encode($result);
			return false;
		}

		if (!$db->insertIntoTable('passwords', ['name' => $_POST['name'], 'content' => self::_cryptPassword($_POST['password']), 'group_id' => $groupId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Une erreur inconnue est survenue.';
			echo json_encode($result);
			return false;
		}

		echo json_encode($result);
		return true;
	}	

	/**
	 * Cette fonction retourne la page d'edition d'un password
	 * @param int $passwordId : L'id du password à éditer
	 */
	public function edit ($passwordId)
	{
		global $db;

		if (!$passwords = $db->getFromTableWhere('passwords', ['id' => $passwordId]))
		{
			$router = new Router();
			$router->return404();
		}

		$password = $passwords[0];
		$password['decrypted'] = self::_decryptPassword($password['content']);

		//Si on ne trouve pas de groupe qui corresponde à cet utilisateur et le groupe du password -----> Le password n'appartient pas à l'utilisateur en cours
		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $password['group_id']]))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render('passwordsEdit', array(
			'password' => $password
		));
	}
	
	/**
	 * Cette fonction permet de modifier un password
	 * @param string $passwordId : L'id du password à modifier
	 * @param $csrf : Le jeton CSRF
	 * @param $_POST['name'] : Le nom du password à ajouter
	 * @param $_POST['password'] : Le contenu du password à ajouter
	 * @param $_POST['verif_password'] : La vérification du contenu du password
	 */
	public function update ($passwordId, $csrf)
	{
		global $db;
		$result = array(
			'success' => 1,
			'error' => '',
		);

		if (!internalTools::verifyCSRF($csrf))
		{
			$result['success'] = 0;
			$result['error'] = 'Jeton CSRF invalide !';
			echo json_encode($result);
			return false;
		}

		if (!$passwords = $db->getFromTableWhere('passwords', ['id' => $passwordId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Le password que vous voulez modifier n\'existe pas !';
			echo json_encode($result);
			return false;
		}

		$password = $passwords[0];

		//Si on ne trouve pas de groupe qui corresponde à cet utilisateur et le groupe du password -----> Le password n'appartient pas à l'utilisateur en cours
		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $password['group_id']]))
		{
			$result['success'] = 0;
			$result['error'] = 'Le password que vous voulez modifier ne vous appartient pas !';
			echo json_encode($result);
			return false;
		}

		if (empty($_POST['name']) || empty($_POST['password']) || empty($_POST['verif_password']))
		{
			$result['success'] = 0;
			$result['error'] = 'Remplissez tous les champs.';
			echo json_encode($result);
			return false;
		}

		if ($_POST['password'] != $_POST['verif_password'])
		{
			$result['success'] = 0;
			$result['error'] = 'Les mots de passe ne correspondent pas !';
			echo json_encode($result);
			return false;
		}

		if (!$db->updateTableWhere('passwords', ['name' => $_POST['name'], 'content' => self::_cryptPassword($_POST['password'])], ['id' => $passwordId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Une erreur inconnue est survenue.';
			echo json_encode($result);
			return false;
		}

		echo json_encode($result);
		return true;
	}	

	/**
	 * Cette fonction retourne la page de validation de suppresion d'un password
	 * @param int $passwordId : L'id du password à supprimer
	 */
	public function delete ($passwordId)
	{
		global $db;

		if (!$passwords = $db->getFromTableWhere('passwords', ['id' => $passwordId]))
		{
			$router = new Router();
			$router->return404();
		}

		$password = $passwords[0];

		//Si on ne trouve pas de groupe qui corresponde à cet utilisateur et le groupe du password -----> Le password n'appartient pas à l'utilisateur en cours
		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $password['group_id']]))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render('passwordsDelete', array(
			'password' => $password,
		));
	}	

	/**
	 * Cette fonction permet de supprimer un password
	 * @param int $passwordId : L'id du password à supprimer
	 * @param string $csrf : Jeton CSRF
	 */
	public function destroy ($passwordId, $csrf)
	{
		global $db;
		
		$result = array(
			'success' => 1,
			'error' => '',
		);

		if (!internalTools::verifyCSRF($csrf))
		{
			$result['success'] = 0;
			$result['error'] = 'Jeton CSRF invalide !';
			echo json_encode($result);
			return false;
		}

		if (!$passwords = $db->getFromTableWhere('passwords', ['id' => $passwordId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Le password que vous voulez supprimer n\'existe pas !';
			echo json_encode($result);
			return false;
		}

		$password = $passwords[0];

		//Si on ne trouve pas de groupe qui corresponde à cet utilisateur et le groupe du password -----> Le password n'appartient pas à l'utilisateur en cours
		if (!$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $password['group_id']]))
		{
			$result['success'] = 0;
			$result['error'] = 'Le password que vous voulez supprimer ne vous appartient pas !';
			echo json_encode($result);
			return false;
		}
	
		if (!$db->deleteFromTableWhere('passwords', ['id' => $passwordId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Impossible de supprimer ce password';
			echo json_encode($result);
			return false;
		}

		echo json_encode($result);
		return true;
	}

	/**
	 * Cette fonction permet de chiffrer un mot de passe à sauvegarder
	 * @param string $password : Le mot de passe à chiffrer
	 * @param string $userPassword : Le mot de passe de l'utilisateur à utiliser pour chiffrer (par défaut $_SESSION['password'])
	 * @param string $userKey : La clef de chiffrement à utiliser (par défaut $_SESSION['secret_key'])
	 * @return string : Le mot de passe chiffré en base64
	 */
	public static function _cryptPassword($password, $userPassword = false, $userKey = false)
	{
		$userPassword = !$userPassword ? $_SESSION['password'] : $userPassword;
		$userKey = !$userKey ? $_SESSION['secret_key'] : $userKey;
		$key = internalTools::aesCrypt($userKey, $userPassword);
		return internalTools::aesCrypt($password, $key);
	}

	/**
	 * Cette fonction permet de dechiffrer un mot de passe à sauvegarder
	 * @param string $password : Le mot de passe à dechiffrer
	 * @param string $userPassword : Le mot de passe de l'utilisateur à utiliser pour chiffrer (par défaut $_SESSION['password'])
	 * @param string $userKey : La clef de chiffrement à utiliser (par défaut $_SESSION['secret_key'])
	 * @return string : Le mot de passe chiffré en base64
	 */
	public static function _decryptPassword($password, $userPassword = false, $userKey = false)
	{
		$userPassword = !$userPassword ? $_SESSION['password'] : $userPassword;
		$userKey = !$userKey ? $_SESSION['secret_key'] : $userKey;
		$key = internalTools::aesCrypt($userKey, $userPassword);
		return internalTools::aesDecrypt($password, $key);
	}
}
