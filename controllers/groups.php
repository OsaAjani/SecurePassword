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
	 */
	public function create ()
	{
		global $db;
		$result = array(
			'success' => 1,
			'error' => '',
		);

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
		return false;
	}	
}
