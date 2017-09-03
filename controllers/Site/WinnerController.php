<?php

namespace Site;

use \controllers\Controller as Controller;

class WinnerController extends Controller
{
	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['lot_id'] = $_POST['lot_id'];
		$data['user_id'] = $_POST['user_id'];
		
		if ($data['user_id']) {		
			$winner = new Winner();
			$result = $winner->create($data);
			$this->check_data($result, 'ajax');
		}
	}

	public function notify()
	{
		$emails = [
			0 => $_POST['email'],
		];

		$result = $this->send_mail($emails);
		$this->check_data($result, 'ajax');
	}
}