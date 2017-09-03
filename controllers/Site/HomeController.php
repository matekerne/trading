<?php

namespace Site;

use \controllers\Controller as Controller;

class HomeController extends Controller
{
	private $lot;

	public function __construct()
	{
		// Чтобы отработала проверка авторизован пользователь или нет
		parent::__construct();
		$this->lot = new Lot();
	}

	public function index()
	{
		$lots = $this->lot->get_all();
	    require_once(ROOT . '/views/site/index.php');
	}
}