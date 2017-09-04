<?php

namespace Admin;

use \controllers\Controller as Controller;

class UserController extends Controller
{
	private $user;
	private $group;

	public function __construct()
	{
		// Чтобы отработала проверка авторизован пользователь или нет
		parent::__construct();
		$this->check_access('admin');
		$this->user = new User();
		$this->group = new Group();
 	}

	public function index()
	{		
		$users = $this->user->get_all();
		$this->check_data($users);

		$groups = $this->group->get_all();
		$this->check_data($groups);

		require_once(ROOT . '/views/admin/user/index.php');
		return true;
	}

	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['login'] = $_POST['login'];
		$data['name'] = $_POST['name'];
		$data['groups'] = $this->get_select2_value('groups', $_POST);
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		$this->check_exists($data);

		$user = $this->user->create($data);
		$this->check_data($user, 'ajax');
	}

	public function edit()
	{
		$this->check_request($_POST);

		$id = $_POST['user_id'];
		$user = $this->user->show($id);

		$response = [];
		$response['id'] = $user['id'];
		$response['login'] = $user['login'];
		$response['name'] = $user['name'];
		$response['email'] = $user['email'];
		$response['groups'] = $user['groups'];

		echo json_encode($response);
		return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['user_id'] = $_POST['user_id'];
		$data['login'] = $_POST['login'];
		$data['groups'] = $this->get_select2_value('groups', $_POST);
		$data['name'] = $_POST['name'];
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];

		$this->check_exists($data);

		$user = $this->user->update($data);
		$this->check_data($user, 'ajax');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = $_POST['user_id'];

		$user = $this->user->delete($id);
		$this->check_data($user, 'ajax');
	}

	public function check_exists($data)
	{
		$result = $this->user->check_exists($data);

		if ($result) {
			// Здесь использовать напрямую send_ajax_response
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, 'Пользователь с таким именем уже существует');
			die();
		} else {
			return true;
		}
	}

	public function notify()
	{
		var_dump($_POST);
		// $this->send_mail($emails, $subject, $message);
	}
}