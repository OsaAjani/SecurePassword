<?php
/**
 * page ajax d'inscription
 */
class inscription extends Controller
{
	/**
	 * Retourne la page d'inscription
	 */
	public function byDefault ()
	{
		return $this->render('inscription');
	}

	/**
	 * Permet de valider l'inscription d'un utilisateur
	 * @param string $userId : Id de l'utilisateur à valider
	 * @param string $md5Key : md5() de la secret key de l'utilisateur
	 */
	public function validate ($userId, $md5Key)
	{
		global $db;
		
		if (!$users = $db->getFromTableWhere('users', ['id' => $userId]))
		{
			$router = new Router();
			$router->return404();
		}

		if ($md5Key != md5($users[0]['secret_key']))
		{
			$router = new Router();
			$router->return404();
		}

		$db->updateTableWhere('users', ['valid' => true], ['id' => $userId]);
		return header('Location: ' . $this->generateUrl());
	}

	/**
	 * Permet de renvoyer un email d'inscription
	 * @param string $userId : Id de l'utilisateur auquel renvoyer l'email
	 */
	public function resend ($userId)
	{
		$this->sendVerificationEmail($userId);
		return header('Location: ' . $this->generateUrl() . '?emailsend=1');
	}


	/**
	 * Cette fonction permet d'ajouter un utilisateur
	 * @param $csrf : Le jeton CSRF
	 * @param string $_POST['email'] : L'email de l'utilisateur
	 * @param string $_POST['verif_email'] : La vérification de l'email de l'utilisateur
	 * @param string $_POST['password'] : Le password de l'utilisateur
	 * @param string $_POST['verif_password'] : La vérification du nouveau mot de passe
	 */
	public function create ($csrf)
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

		if (empty($_POST['email']) || empty($_POST['verif_email']) || empty($_POST['password']) || empty($_POST['verif_password']))
		{
			$result['success'] = 0;
			$result['error'] = 'Remplissez tous les champs.';
			echo json_encode($result);
			return false;
		}

		if ($_POST['email'] != $_POST['verif_email'])
		{
			$result['success'] = 0;
			$result['error'] = 'Les adresses e-mails ne correspondent pas !';
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

		$secretKey = bin2hex(openssl_random_pseudo_bytes(1000));
		if (!$db->insertIntoTable('users', ['email' => $_POST['email'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 'secret_key' => $secretKey, 'valid' => 0]))
		{
			$result['success'] = 0;
			$result['error'] = 'Une erreur inconnue est survenue.';
			echo json_encode($result);
			return false;
		}

		if (!$this->sendVerificationEmail ($db->lastId()))
		{
			$result['success'] = 0;
			$result['error'] = 'Impossible d\'envoyer l\'email d\'inscription.';
			echo json_encode($result);
			return false;
		}

		echo json_encode($result);
		return true;
	}	

	private function sendVerificationEmail ($userId)
	{
		global $db;

		if (!$users = $db->getFromTableWhere('users', ['id' => $userId]))
		{
			return false;
		}

		//On forge le mail d'inscription
		$to = $_POST['email'];
		$subject = "Inscription SecurePassword";
		$message = 	'Bonjour ' . $_POST['email'] . ',' . "\r\n" .
				'C\'est un bonheur de vous voir utiliser SecurePassword, nous espérons que ce service vous plaira !' . "\r\n" .
				'Avant de pouvoir utiliser notre service, veuillez valider ce compte en vous rendant à l\'adresse suivante : ' . $this->generateUrl('inscription', 'validate', [$userId, md5($users[0]['secret_key'])]) . "\r\n" .
				"\r\n" .
				"Pour toutes questions, suggestions, etc., envoyez un message à l'adresse securepassword@gmail.com";
	
		$headers = 	'From: securepassword@gmail.com' . "\r\n" .
				'Reply-To: securepassword@gmail.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

		return mail($to, $subject, $message, $headers);
	}
}
