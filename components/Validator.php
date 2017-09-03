<?php

namespace components;

use \Auth\AuthController as AuthController;

trait Validator
{
	public function check_auth()
    {
    	if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        } else {
        	return true;
        }
    }

	public function check_cookie()
	{
		if (isset($_COOKIE['rml']) && isset($_COOKIE['rmp']) && !isset($_SESSION['remember_me'])) {
			$auth = new AuthController();
			$auth->auto_login($_COOKIE['rml'], $_COOKIE['rmp']);
		} else {
			return true;
		}
	}

	public function check_request($request)
	{
		if (!$request) {
			$this->send_ajax_response('HTTP/1.0 405 Method Not Allowed', 405, 'Неправильный метод отправки формы');
			die();
		} else {
			return true;
		}
	}

	public function check_data($data, $flag='')
	{
		if ($data && $flag == 'ajax') {
			$this->send_ajax_response('HTTP/1.0 200 OK', 200, 'Готово');
		} else if ($data) {
			$this->send_response('HTTP/1.0 200 OK', 200);
		} else if (!$data && $flag == 'ajax') {
			$this->send_ajax_response('HTTP/1.0 500 Internal Server Error', 500, 'Что то пошло не так, попробуйте позже');
		} else if (is_array($data) && count($data) >= 0) {
			$this->send_response('HTTP/1.0 200 OK', 200);
		} else {
			$this->send_response('HTTP/1.0 500 Internal Server Error', 500);
		}
	}

	public function check_empty($value, string $field)
	{
		if (!$value) {
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, 'Заполните все обязательные поля');
		} else {
			return true;
		}
	}

	public function check_length(string $value, string $field)
	{
		if (strlen($value) > 255) {
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, "Значение поля $field должно быть меньшей длинны");
		} else {
			return true;
		}
	}

	public function check_length_integer(string $value, string $field)
	{
		if (strlen($value) > 11) {
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, "Значение поля $field должно быть меньшей длинны");
		} else {
			return true;
		}
	}

	public function check_email(string $value, string $field)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, "Неправильный формат email адреса");		
		} else {
			return true;
		}
	}

    public function check_access($role)
    {
    	switch ($role) {
    		case 'admin':
    			return true;
    			break;
  
    		default:
    			header('Location: /');
	    		exit();
    			break;
    	}
    }

	public function validate(array $request, array $rules): array
	{
		$fields_names = [
			'login' => 'Логин',
			'name' => 'Имя',
			'price' => 'Цена',
			'price_type' => 'Тип цены',
			'count' => 'Колличество',
			'count_type' => 'Тип колличества',
			'characteristics' => 'Характеристики',
			'conditions_payment' => 'Условия оплаты',
			'conditions_shipment' => 'Условия отгрузки',
			'terms_shipment' => 'Сроки отгрузки',
			'start' => 'Начало',
			'stop' => 'Конец',
			'status' => 'Статус',
			'surname' => 'Фамилия',
			'patronymic' => 'Отчество',
			'role' => 'Роль',
			'group' => 'Группа',
			'password' => 'Пароль',
			'email' => 'Почта',
			'bet' => 'Ставка',
			'step_bet' => 'Шаг ставки',
			'groups' => 'Группы',
		];

		$data = [];
		foreach ($request as $field => $value) {
			$arr = [];
			
			$arr['field'] = $field;
			$arr['value'] = $value;

			if (array_key_exists($arr['field'], $rules)) {
				$actions = explode('|', $rules[$arr['field']]);
				
				foreach ($actions as $action) {
					$prefix = 'check_';
					$function = $prefix . $action;
					$this->$function($arr['value'], $fields_names[$arr['field']]);
					$сlean_value = $this->clean($arr['value']);
				}

				$data[$field] = $сlean_value;
			} else {
				$data[$field] = $value;
			}
		}

		return $data;
	}

	public function clean($value='')
	{
		if (is_array($value)) {
			$result = [];

			$i = 0;
			foreach ($value as $val) {
				$element = trim($val);
				$element = strip_tags($element);
				$element = stripslashes($element);
				$result[$i] = $element;

				$i++;
			}
		} else {		
			$result = trim($value);
			$result = strip_tags($result);
			$result = stripslashes($result);
		}

		return $result;
	}

	// public function check_empty_file($value, string $field)
	// {
	// 	if (count($value) < 1) {
	// 		$_SESSION['errors'] = 'Файл не может быть пустым';
	// 		header('Location: ' . $_SERVER['HTTP_REFERER']);
	// 		exit();
	// 	} else {
	// 		return true;
	// 	}
	// }
}