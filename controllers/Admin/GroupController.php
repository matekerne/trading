<?php

namespace Admin;

use \controllers\Controller as Controller;

class GroupController extends Controller
{
	private $group;

	public function __construct()
	{
		parent::__construct();
		$this->check_access('admin');
		$this->group = new Group();
	}

	public function index()
	{
		$groups = $this->group->get_all();
		$this->check_data($groups);

		require_once(ROOT . '/views/admin/group/index.php');
		return true;
	}

	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['name'] = $_POST['name'];

		$group = $this->group->create($data);
		$this->check_data($group, 'ajax');
	}

	public function edit()
	{
        $id = $_POST['id'];
		$group = $this->group->show($id);

        $response = [];
        $response['id'] = $group['id'];
        $response['name'] = $group['name'];

        echo json_encode($response);
        return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['name'];
		// var_dump($data); die();
		$group = $this->group->update($data);
		$this->check_data($group, 'ajax');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = $_POST['id'];

		$group = $this->group->delete($id);
		$this->check_data($group, 'ajax');
	}
}