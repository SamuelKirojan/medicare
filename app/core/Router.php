<?php
class Router {
    private $controller = 'HomeController';
    private $method = 'index';
    
    public function __construct() {
        $route = $_GET['r'] ?? '';
        $this->parseRoute($route);
    }
    
    private function parseRoute(string $route): void {
        if (empty($route)) {
            return;
        }
        
        $parts = explode('/', $route);
        
        if (!empty($parts[0])) {
            $controllerName = ucfirst($parts[0]) . 'Controller';
            $controllerPath = APP_ROOT . '/app/controllers/' . $controllerName . '.php';
            
            if (file_exists($controllerPath)) {
                $this->controller = $controllerName;
                
                if (isset($parts[1]) && !empty($parts[1])) {
                    $this->method = $parts[1];
                }
            } else {
                // Controller not found - redirect to 404
                $this->controller = 'ErrorController';
                $this->method = 'error404';
            }
        }
    }
    
    public function dispatch(): void {
        require_once APP_ROOT . '/app/controllers/' . $this->controller . '.php';
        
        $controller = new $this->controller();
        
        // Check if method exists
        if (!method_exists($controller, $this->method)) {
            // Method not found - redirect to 404
            require_once APP_ROOT . '/app/controllers/ErrorController.php';
            $errorController = new ErrorController();
            $errorController->error404();
            return;
        }
        
        try {
            call_user_func([$controller, $this->method]);
        } catch (Exception $e) {
            // Internal error - redirect to 500
            require_once APP_ROOT . '/app/controllers/ErrorController.php';
            $errorController = new ErrorController();
            $errorController->error500();
        }
    }
}