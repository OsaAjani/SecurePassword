<?php
/**
 * page ajax d'inscription
 */
class inscription extends Controller
{
	/**
	 * Permet de vérifier si un mot de passe est valide
	 * @param string $_POST['password'] : Le password à vérifier
	 */
	public function checkpasswordstrength($email)
	{
		global $db;

		$result = array(
			'valid' => 0
		);

		$users = $db->getFromTableWhere('users', ['email' => $email]);
		if ($users)
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
		if ($users)
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

		echo json_encode($result);
		return true;
	}
}
