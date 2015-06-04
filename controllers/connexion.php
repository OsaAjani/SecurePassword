<?php
/**
 * page ajax de connexion
 */
class connexion extends Controller
{
	/**
	 * Permet de déconnecter un utilisateur
	 */
	public static function logout()
	{
		session_unset();
		session_destroy();
		header('Location: ' . HTTP_PWD);
	}

	/**
	 * Permet de vérifier si une adresse mail existe
	 * @param string email : L'adresse mail à vérifier
	 */
	public function checkemail()
	{
		global $db;

		$result = array(
			'success' => 1,
			'error' => '',
		);

		$users = $db->getFromTableWhere('users', ['email' => $_POST['email']]);
		if (!count($users))
		{
			$result['success'] = 0;
			$result['error'] = 'Cette adresse e-mail n\'existe pas !';
			echo json_encode($result);
			return false;
		}

		if (!$users[0]['valid'])
		{
			$result['success'] = 0;
			$result['error'] = 'Cette adresse e-mail n\'est pas encore validée (<a href="' . $this->generateUrl('inscription', 'resend', [$users[0]['id']]) . '">Renvoyer un mail de validation</a>) !';
			echo json_encode($result);
			return false;
		}

		$_SESSION['tmp_email'] = $_POST['email'];
		echo json_encode($result);
		return true;
	}

	/**
	 * Permet de vérifie si un password existe pour l'email en cours
	 * @param $_POST['password'] : Le mot de passe a vérifier
	 */
	public function checkpassword ()
	{
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$email = isset($_SESSION['tmp_email']) ? $_SESSION['tmp_email'] : '';

		global $db;

		$result = array(
			'success' => 1,
			'error' => '',
		);

		$users = $db->getFromTableWhere('users', ['email' => $email]);
		if (!count($users))
		{
			$result['success'] = 0;
			$result['error'] = 'Cette adresse e-mail n\'existe pas !';
			echo json_encode($result);
			return false;
		}
		
		$user = $users[0];
		if (!password_verify($password, $user['password']))
		{
			$result['success'] = 0;
			$result['error'] = 'Mot de passe incorrect !';
			echo json_encode($result);
			return false;
		}
		
		$_SESSION['email'] = $email;
		$_SESSION['password'] = $password;
		$_SESSION['secret_key'] = $user['secret_key'];
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['connected'] = true;

		echo json_encode($result);
		return true;
	}
}
