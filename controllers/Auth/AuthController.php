<?php

namespace Auth;

use \controllers\Controller as Controller;
use \Admin\User as User;
use \Auth\Auth as Auth;

class AuthController extends Controller
{
	private $auth;
	private $user;

	public function __construct()
	{
		$this->auth = new Auth();
		$this->user = new User();
	}

	public function index()
	{
		// var_dump(password_hash('MazuT1508IT', PASSWORD_DEFAULT)); die();
		
		if (isset($_SESSION['user'])) {
			$this->redirect('', '/');
		}

        require_once(ROOT . '/views/auth/login.php');
        return true;
	}

	public function login()
	{
    	$this->check_request($_POST);

    	$data = [];
        $data['login'] = $_POST['login'];
        $data['password'] = $_POST['password'];
        $data['remember_me'] = $this->get_checkbox_value('remember_me', $_POST);
        
		$user = $this->user->check_exists($data);
		
		if ($user) {
       		$auth = $this->auth->login($data, $user);

       		if ($auth) {	
				$_SESSION['user'] = $user['id'];
				$_SESSION['user_login'] = $user['login'];
				$_SESSION['user_name'] = $user['name'];
				$_SESSION['user_email'] = $user['email'];
				$_SESSION['role'] = $user['login'];
				
				if ($data['remember_me']) {
					setcookie('rml', $user['login'], time() + 60 * 60 * 24 * 30, '/');
					setcookie('rmp', $user['password'], time() + 60 * 60 * 24 * 30, '/');
				}

				$this->send_ajax_response('HTTP/1.0 200 OK', 200, 'Успешно');
       		} else {
       			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, 'Неправильные логин или пароль');

       		}
		} else {
			$this->send_ajax_response('HTTP/1.0 400 Bad Request', 400, 'Неправильные логин или пароль');
		}
	}

	public function auto_login(string $login, string $password)
	{
		$data = [];
        $data['login'] = $login;
        $data['password'] = $password;

		$user = $this->user->check_exists($data);

		if ($user) {
       		$auth = $this->auth->login($data, $user, 'remember_me');

       		if ($auth) {			
				$_SESSION['user'] = $user['id'];
				$_SESSION['user_login'] = $user['login'];
				$_SESSION['user_name'] = $user['name'];
				$_SESSION['user_email'] = $user['email'];
				$_SESSION['role'] = $user['login'];
				$_SESSION['remember_me'] = $user['id'];
				return true;
       		} else {
       			return false;
       		}
		} else {
			return false;
		}	
	}

    public function logout() {
    	unset($_SESSION['user_login']);
        unset($_SESSION['user']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['error_access']);
        unset($_SESSION['remember_me']);

		setcookie('rml', '', 1, '/');
		setcookie('rmp', '', 1, '/');

		$this->redirect('', '/login');
    }
}