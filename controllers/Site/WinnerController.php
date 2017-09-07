<?php

namespace Site;

use \controllers\Controller as Controller;
use \Admin\User as User;

class WinnerController extends Controller
{
	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['lot_id'] = $_POST['lot_id'];
		$data['user_id'] = $_POST['user_id'];
		$data['notify'] = 0;
		
		if ($data['user_id']) {		
			$winner = new Winner();
			$result = $winner->create($data);
			$this->check_data($result, 'ajax');
		}
	}

	public function notify()
	{
		$user_id = $_POST['user_id'];
		$lot_id = $_POST['lot_id'];

		$congratulation = "
			<li class='characteristics-list--item--title'>
				<h3 class='characteristics-list--item--title-text'>Вы выиграли лот №$lot_id</h3>
			</li>
		";
		$information = $_POST['information'];
		// $message = $congratulation . $information;

		$winner = new Winner();
		$new_winner = $winner->show($user_id);

		if ($new_winner[0]['notify'] == 0) {
			$result = $winner->change_notify($user_id, 1);
			$user = new User();
			$user = $user->show($user_id);
			
			$message = "
                <html>
                    <head>
                        <title>Итоги аукциона</title>
                    </head>
                    <body>
                    	$congratulation
                    	$information
                    </body>
                </html>
            ";
            // var_dump($message); die();
			$result = $this->send_mail($user['email'], 'Итоги аукциона', $message);
			$this->check_data($result, 'ajax');
		} else {
			$this->send_ajax_response('HTTP/1.0 200 OK', 200, 'Успешно');
		}
	}
}