<?php
class Route {
	static function start() {
		$controller_name = 'Main';
		$action_name = 'index';
		$param = 0;
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if ( !empty($routes[1]) ) {	
			$controller_name = $routes[1];
		}
		
		if ( !empty($routes[2]) ) {
			$action_name = $routes[2];
		}

		if (!empty($routes[3])){
		    $param = $routes[3];
        }
        
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		// подцепляем файл с классом модели (файла модели может и не быть)
		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path)) {
			include "application/models/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path)) {
			include "application/controllers/".$controller_file;
		}
		else {
			Route::ErrorPage404();
		}

		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action)) {
			$controller->$action($param);
		}
		else {
			Route::ErrorPage404();
		}
	}

	public function ErrorPage404() {
		header('Location: ../404');
    }
}
