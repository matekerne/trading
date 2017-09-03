<?php

namespace Admin;

use \controllers\Controller as Controller;

class LotController extends Controller
{
	private $lot;
	private $group;

	public function __construct()
	{
		// Чтобы отработала проверка авторизован пользователь или нет
		parent::__construct();
		
		$this->check_access('admin');
		$this->lot = new Lot();
		$this->group = new Group();
 	}

	public function index()
	{
		$lots = $this->lot->get_all();
		$this->check_data($lots);

		$groups = $this->group->get_all();
		$this->check_data($groups);

		require_once(ROOT . '/views/admin/lot/index.php');
		return true;
	}

	public function get_datetime(string $data)
	{
		if ($data) {
			$datetime = explode('-', $data);

			$y = strstr($datetime[2], ' ', true);
			$d = $datetime[0];
			$m = $datetime[1];
			$hour_minute_second = explode(':', trim(substr($datetime[2], strpos($datetime[2], ' '))) . ':00');

			return date("$y.$m.$d $hour_minute_second[0]:$hour_minute_second[1]:$hour_minute_second[2]");
		} else {
			return false;
		}
	}

	public function create()
	{
		$this->check_request($_POST);
		
		$data = [];
		$data['name'] = $_POST['name'];
		$data['characteristics'] = implode(', ', array_filter($_POST['characteristics']));
		$data['price'] = $_POST['price'];
		$data['price_type'] = $_POST['price_type'];
		$data['groups'] = $this->get_select2_value('groups', $_POST);
		$data['count'] = $_POST['count'];
		$data['count_type'] = $_POST['count_type'];
		$data['conditions_payment'] = $_POST['conditions_payment'];
		$data['conditions_shipment'] = $_POST['conditions_shipment'];
		$data['terms_shipment'] = $_POST['terms_shipment'];
		$data['step_bet'] = $_POST['step_bet'];
		$data['start'] = $this->get_datetime($_POST['start']);
		$data['stop'] = $this->get_datetime($_POST['stop']);
		$data['status'] = $_POST['status'];


		$lot = $this->lot->create($data);
		// var_dump($lot); die();
		$this->check_data($lot, 'ajax');
	}

	public function edit()
	{
		// когда будет модальное окно написать так $this->check_data($user, 'ajax');
		// $id = \Router::get_id();

		$id = $_POST['lot_id'];
		$lot = $this->lot->show($id);

		$response = [];
		$response['id'] = $lot['id'];
		$response['name'] = $lot['name'];
		$response['characteristics'] = $lot['characteristics'];
        $response['price'] = $lot['price'];
        $response['price_type'] = $lot['price_type'];
        $response['groups'] = $lot['groups'];
        $response['count'] = $lot['count'];
        $response['count_type'] = $lot['count_type'];
        $response['conditions_payment'] = $lot['conditions_payment'];
        $response['conditions_shipment'] = $lot['conditions_shipment'];
        $response['terms_shipment'] = $lot['terms_shipment'];
        $response['step_bet'] = $lot['step_bet'];
        $response['start'] = $lot['start'];
        $response['stop'] = $lot['stop'];
        $response['status'] = $lot['status'];

		echo json_encode($response);
		return true;
		
		// $this->check_data($lot);

		// $groups = $this->group->get_all();
		// $this->check_data($groups);

		// $lot_groups = $this->create_select2_data('groups', $lot['groups']);
		// $this->check_data($lot_groups);

		// require_once(ROOT . '/views/admin/lot/edit.php');
		// return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['lot_id'] = $_POST['lot_id'];
		$data['name'] = $_POST['name'];
		$data['characteristics'] = implode(', ', array_filter($_POST['characteristics']));
		$data['price'] = $_POST['price'];
		$data['price_type'] = $_POST['price_type'];
		$data['groups'] = $this->get_select2_value('groups', $_POST);
		$data['count'] = $_POST['count'];
		$data['count_type'] = $_POST['count_type'];
		$data['conditions_payment'] = $_POST['conditions_payment'];
		$data['conditions_shipment'] = $_POST['conditions_shipment'];
		$data['terms_shipment'] = $_POST['terms_shipment'];
		$data['step_bet'] = $_POST['step_bet'];
		$data['start'] = $_POST['start'];
		$data['stop'] = $_POST['stop'];
		$data['status'] = $_POST['status'];

		$lot = $this->lot->update($data);
		$this->check_data($lot, 'ajax');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = $_POST['lot_id'];

		$lot = $this->lot->delete($id);
		$this->check_data($lot, 'ajax');
	}
}