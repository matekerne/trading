<?php

namespace Site;

use \controllers\Controller as Controller;

class BetController extends Controller
{
	private $bet;

	public function __construct()
	{
		$this->bet = new Bet();
	}

	public function create()
	{
		$this->check_request($_POST);
		
		$data = [];
		$data['lot_id'] = $_POST['lot_id'];
		$data['user_id'] = $_SESSION['user'];
		$data['bet'] = $_POST['bet'];
		$data['last_bet'] = $_POST['last_bet'];

		$this->check($data['bet'], $data['last_bet']);
		
		$result = $this->bet->create($data);
		$this->check_data($result, 'ajax');
	}

	public function check(string $current_bet, string $last_bet)
	{
		$bets = $this->bet->get_all();

		$current_bet = (int) $current_bet;
		$last_bet = (int) $last_bet;

		if ($current_bet <= $last_bet) {
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, 'Ставка не может быть меньше или равной текущей');
		}

		return true;
	}
}