<?php

require_once(ROOT . '/components/Autoload.php');

class Router
{
	private $routes;

	/**
	 * Set connection with routes
	 *
	 */
	public function __construct()
	{
		$routes_path = ROOT . '/routes/routes.php';
		$this->routes = include($routes_path);
	}

	/**
	 * Return processed current url
	 *
	 * @return {string} processed current url
	 */
	private function get_url()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
            $get_params = explode('?', $_SERVER['REQUEST_URI'], 2);
            
            return trim($get_params[0], '/');
		}
	}

	/**
	 * Return id for any essence
	 *
	 * @return {string}
	*/
	public static function get_id()
	{
		$arr = explode('/', $_SERVER['REQUEST_URI']);
		return $id = end($arr);
	}

	public function activate_handlers($handlers)
	{
		// Для обработки контроллеров с именем типа TotalAreaController 
		if (count($handlers) > 2) {
			$parts_controller_name = array_slice($handlers, 0, count($handlers) - 1);
			$controller = '';
			$postfix = 'Controller';

			foreach ($parts_controller_name as $part_controller_name) {
				$controller .= ucfirst($part_controller_name);
			}

			$controller_name = $controller . $postfix;
			$method_name = end($handlers);
			$controller_object = new $controller_name;
		} else {						
			$controller_name = ucfirst(array_shift($handlers) . 'Controller');
			$method_name = array_shift($handlers);
			$controller_object = new $controller_name;
		}

		$result = call_user_func(
			array(
				$controller_object,
				$method_name
			)
		);
	}

	/**
	 * Start processing work with routes 
	 *
	 */
	public function run()
	{
		$url = $this->get_url();
		$arr_urls = explode('/', $url);
		$last_element = end($arr_urls);
		$id = (integer) $last_element;
		
		foreach ($this->routes as $route => $handlers_strings) {
			$match_by_id = preg_match('/^[1-9][0-9]*$/', $id);
			$match_by_name = array_key_exists($url, $this->routes);

			if ($match_by_id || $match_by_name) {
				$handler_string = preg_replace("~$route~", $handlers_strings, $url);
				
				if (in_array($handler_string, $this->routes)) {		
					$handlers = explode('/', $handler_string);
					$this->activate_handlers($handlers);
				}
			} else {
				header('HTTP/1.0 404 Not Found', http_response_code(404));
				require_once(ROOT . '/views/errors/404.php');
				return true;
			}
		} 
	}
}