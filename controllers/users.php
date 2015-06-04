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

		if (!$users = $db->getFromTableWhere('users', ['id' => $_SESSION['user_id']]))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render("users", array(
			'user' => $users[0],
		));
	}

	/**
	 * Cette fonction retourne la page d'edition de l'utilisateur
	 */
	public function edit ()
	{
		global $db;

		if (!$users = $db->getFromTableWhere('users', ['id' => $_SESSION['user_id']]))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render('usersEdit', array(
			'user' => $users[0],
		));
	}

	/**
	 * Cette fonction permet de modifier un utilisateur
	 * @param $csrf : Le jeton CSRF
	 * @param string $_POST['email'] : Le nouvel email de l'utilisateur
	 * @param string $_POST['password'] : Le nouveau password de l'utilisateur
	 * @param string $_POST['verif_password'] : La vérification du nouveau mot de passe
	 */
	public function update ($csrf)
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

		if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['verif_password']))
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

		if (!internalTools::checkPasswordStrength($_POST['password'], 10, true, true, true, true, 2))
		{
			$result['success'] = 0;
			$result['error'] = 'Le mot de passe est trop faible. Minimum 10 caractères, dont au moins deux types parmis les suivants, minuscule, majuscule, chiffre, caractères spéciaux.';
			echo json_encode($result);
			return false;
		}

		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$result['success'] = 0;
			$result['error'] = 'Vous devez fournir une adresse e-mail valide.';
			echo json_encode($result);
			return false;
		}

		if (!$db->updateTableWhere('users', ['email' => $_POST['email'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)], ['id' => $_SESSION['user_id']]))
		{
			$result['success'] = 0;
			$result['error'] = 'Une erreur inconnue est survenue.';
			echo json_encode($result);
			return false;
		}

		//On va déchiffrer tous les passwords et le rechiffrer avec le nouveau password
		$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id']]);
		foreach ($groups as $group)
		{
			$passwords = $db->getFromTableWhere('passwords', ['group_id' => $group['id']]);
			foreach ($passwords as $password)
			{
				$decryptedPassword = passwords::_decryptPassword($password['content']);
				$db->updateTableWhere('passwords', ['content' => passwords::_cryptPassword($decryptedPassword, $_POST['password'])], ['id' => $password['id']]); //On utilise $_POST['password'] dans le chiffrement parcequ'il faut chiffrer avec le nouveau pass, pas l'ancien
			}
		}
		
		$_SESSION['password'] = $_POST['password'];

		echo json_encode($result);
		return true;
	}	

	/**
	 * Cette fonction retourne la page de validation de suppresion d'un utilisateur
	 */
	public function delete ()
	{
		global $db;

		if (!$users = $db->getFromTableWhere('users', ['id' => $_SESSION['user_id']]))
		{
			$router = new Router();
			$router->return404();
		}
		
		return $this->render('usersDelete', array(
			'user' => $users[0],
		));
	}	

	/**
	 * Cette fonction permet de supprimer un compte
	 * @param string $csrf : Jeton CSRF
	 */
	public function destroy ($csrf)
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
	
		if (!$db->deleteFromTableWhere('users', ['id' => $_SESSION['user_id']]))
		{
			$result['success'] = 0;
			$result['error'] = 'Impossible de supprimer ce groupe.';
			echo json_encode($result);
			return false;
		}

		connexion::logout();

		$result['redirect'] = HTTP_PWD;
		echo json_encode($result);
		return true;
	}
}
