<?php
/**
 * page groups
 */
class groups extends Controller
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
	 * Cette fonction permet d'afficher la page des groupes
	 */
	public function byDefault ()
	{
		global $db;

		$groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id']]);

		return $this->render("groups", array(
			'groups' => $groups,
		));
	}

	/**
	 * Cette fonction permet d'afficher la page d'un groupe
	 * @param int $groupId : Le numéro du groupe
	 */
	public function show ($groupId)
	{
		global $db;

		if (!count($groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId])))
		{
			$router = new Router();
			$router->return404();
		}

		$group = $groups[0];
		
		$passwords = $db->getFromTableWhere('passwords', ['group_id' => $group['id']]);
		
		return $this->render('groupsShow', array(
			'group' => $group,
			'passwords' => $passwords,
		));
	}

	/**
	 * Cette fonction permet d'afficher la page d'ajout d'un groupe
	 */
	public function add ()
	{
		return $this->render('groupsAdd');
	}

	/**
	 * Cette fonction permet d'enregistrer un nouveau password
	 * @param $csrf : Le jeton CSRF
	 * @param $_POST['name'] : Le nom du groupe à ajouter
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

		if (empty($_POST['name']))
		{
			$result['success'] = 0;
			$result['error'] = 'Remplissez tous les champs.';
			echo json_encode($result);
			return false;
		}

		if (!$db->insertIntoTable('groups', ['name' => $_POST['name'], 'user_id' => $_SESSION['user_id']]))
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
	 * Cette fonction retourne la page de validation de suppresion d'un groupe
	 * @param int $groupId : L'id du groupe à supprimer
	 */
	public function delete ($groupId)
	{
		global $db;

		if (!count($groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId])))
		{
			$router = new Router();
			$router->return404();
		}
		
		return $this->render('groupsDelete', array(
			'group' => $groups[0],
		));
	}	

	/**
	 * Cette fonction permet de supprimer un groupe
	 * @param int $groupId : L'id du groupe à supprimer
	 * @param string $csrf : Jeton CSRF
	 */
	public function destroy ($groupId, $csrf)
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
	
		if (!$db->deleteFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId]))
		{
			$result['success'] = 0;
			$result['error'] = 'Impossible de supprimer ce groupe.';
			echo json_encode($result);
			return false;
		}

		echo json_encode($result);
		return true;
	}

	/**
	 * Cette fonction retourne la page d'edition d'un groupe
	 * @param int $groupId : L'id du groupe à éditer
	 */
	public function edit ($groupId)
	{
		global $db;

		if (!count($groups = $db->getFromTableWhere('groups', ['user_id' => $_SESSION['user_id'], 'id' => $groupId])))
		{
			$router = new Router();
			$router->return404();
		}

		return $this->render('groupsEdit', array(
			'group' => $groups[0]
		));
	}

	/**
	 * Cette fonction permet de modifier un groupe
	 * @param $csrf : Le jeton CSRF
	 * @param $_POST['name'] : Le nom du groupe à ajouter
	 */
	public function update ($groupId, $csrf)
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

		if (empty($_POST['name']))
		{
			$result['success'] = 0;
			$result['error'] = 'Remplissez tous les champs.';
			echo json_encode($result);
			return false;
		}

		if (!$db->updateTableWhere('groups', ['name' => $_POST['name']], ['id' => $groupId, 'user_id' => $_SESSION['user_id']]))
		{
			$result['success'] = 0;
			$result['error'] = 'Une erreur inconnue est survenue.';
			echo json_encode($result);
			return false;
		}

		echo json_encode($result);
		return true;
	}	
}
