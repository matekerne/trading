<?php

namespace controllers;

use components\Validator as Validator;
use components\Helper as Helper;

class Controller
{
	use Validator, Helper;

	public function __construct()
	{
		$this->check_cookie();
		$this->check_auth();
	}
}