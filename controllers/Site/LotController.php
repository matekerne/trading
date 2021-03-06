<?php 

namespace Site;

use \controllers\Controller as Controller;

class LotController extends Controller
{
	private $lot;

	public function __construct()
	{
		// Чтобы отработала проверка авторизован пользователь или нет
		parent::__construct();
			
		$this->lot = new Lot();
	}

	public function show()
	{
		$id = \Router::get_id();
		$lots = $this->lot->show($id);
		// var_dump($lots); die();
		$this->check_data($lots);

		$bet = new Bet();
		$bets = $bet->get_all_by_each_lot($id);
		$this->check_data($bets);

		$names_mouths = [
			'Jan' => '01',
			'Feb' => '02',
			'Mar' => '03',
			'Apr' => '04',
			'May' => '05',
			'Jun' => '06',
			'Jul' => '07',
			'Aug' => '08',
			'Sep' => '09',
			'Oct' => '10',
			'Nov' => '11',
			'Dec' => '12',
		];

		$date_time_stop = str_replace(" ","-",$lots[0]['stop']);
		$date_time_stop_auction = explode('-', $date_time_stop);
		$year_stop = $date_time_stop_auction[0];
		$mounth_stop = array_search($date_time_stop_auction[1], $names_mouths);
		$day_stop = $date_time_stop_auction[2];
		$time_stop = $date_time_stop_auction[3];

		$date_time_start = str_replace(" ","-",$lots[0]['start']);
		$date_time_start_auction = explode('-', $date_time_start);
		$year_start = $date_time_start_auction[0];
		$mounth_start = array_search($date_time_start_auction[1], $names_mouths);
		$day_start= $date_time_start_auction[2];
		$time_start = $date_time_start_auction[3];
		// var_dump($date_time_start_auction); die();
		require_once(ROOT . '/views/site/lot/index.php');
		return true;
	}

	public function change_status()
	{
		$this->check_request($_POST);

		$status = 3;
		$lot_id = $_POST['lot_id'];
		$result = $this->lot->change_status($status, $lot_id);

		$this->check_data($result, 'ajax');
	}

	public function check_time_stop()
	{
		$this->check_request($_POST);
		
		$lot_id = $_POST['lot_id'];
		$lot = $this->lot->show($lot_id);

		$current_time = date("Y-m-d H:i:s");
		$stop_time =  $lot[0]['stop'];

		if ($current_time < $stop_time) {
			$response = [];
			$response['status'] = 'fail';
			echo json_encode($response);
		} else {
			$response = [];
			$response['status'] = 'success';
			echo json_encode($response);
		}
	}
}