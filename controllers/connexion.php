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
	public function checkemail($email)
	{
		global $db;

		$result = array(
			'valid' => 0
		);

		$users = $db->getFromTableWhere('users', ['email' => $email]);
		if (count($users))
		{
			$result['valid'] = 1;
			$_SESSION['tmp_email'] = $email;
		}

		echo json_encode($result);
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
			'valid' => 0
		);

		$users = $db->getFromTableWhere('users', ['email' => $email]);
		if (!count($users))
		{
			echo json_encode($result);
			return false;
		}
		
		$user = $users[0];
		if (!password_verify($password, $user['password']))
		{
			echo json_encode($result);
			return false;
		}
		
		$result['valid'] = 1;
		$_SESSION['email'] = $email;
		$_SESSION['password'] = $password;
		$_SESSION['secret_key'] = $user['secret_key'];
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['connected'] = true;

		echo json_encode($result);
		return true;
	}
}
