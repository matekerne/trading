<?php

namespace components;

trait Helper
{
	public function send_response($string, $code, $message='')
	{
		switch ($code) {
			case 200:
				header($string, http_response_code($code));
				break;

			case 500:
				header($string, http_response_code($code));
				require_once(ROOT . '/views/errors/500.php');
				die();
				break;
		}
	}

	public function send_ajax_response($string, $code, $message='')
	{
		switch ($code) {
			case 200:
				header($string, http_response_code($code));

				$response = [];
				$response['message'] = $message;

				echo json_encode($response);
				break;		

			case 400:
				header($string, http_response_code($code));

				$response = [];
				$response['message'] = $message;

				echo json_encode($response);
				break;

			case 405:
				header($string, http_response_code($code));

				$response = [];
				$response['message'] = $message;

				echo json_encode($response);
				break;

			case 406:
				header($string, http_response_code($code));

				$response = [];
				$response['message'] = $message;

				echo json_encode($response);
				break;

			case 500:
				header($string, http_response_code($code));

				$response = [];
				$response['message'] = $message;
				
				echo json_encode($response);
				break;
		}
		
		die();
	}

	public function redirect(string $message='', string $url='')
	{
		if ($message) {
			$_SESSION['success'] = $message;
		}

		if ($url) {
			header('Location: ' . $url);
			exit();
		} else {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function get_checkbox_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
    		$data = $request["$field"];
    	} else {
    		$data = '';
    	}

    	return $data;
    }

	public function get_select2_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
			$data = $request["$field"];
		} else {
			$data = '';
		}

		return $data;
    }

    public function create_select2_data(string $field, $data=''): array
    {
    	$result = [];
    	
    	$i = 0;
    	switch ($field) {
			case 'groups':
				$arr = explode(',', $data);
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
    	}

		return $result;
    }

    public function send_mail(array $emails, $subject='Итоги аукциона', $message='Поздравляем с победой!')
    {
	    $headers = "From: info@trade.inpk-trading.ru \r\n"; 
        $headers .= "MIME-Version: 1.0 \r\n"; 
        $headers .= "Content-Type: text/html; charset=UTF-8 \r\n"; 
        $headers .= "X-Priority: 1 \r\n";

        $today = date('d.m.y', time() - 60 * 60 * 24);

        $result = 0;
        foreach ($emails as $to) {
        	if (mail($to, $subject . ' ' . $today, $message, $headers)) {
        		$result += 1;
        	} else {
        		$result = 0;
        	}
        }

    	if ($result) {
    		return true;
    	} else {
    		return false;
    	}
    }
}