<?php
require_once APP_ROOT . '/app/core/Controller.php';

class ErrorController extends Controller {
    
    public function error404(): void {
        http_response_code(404);
        $this->render('error/404', [
            'hideChrome' => false
        ]);
    }
    
    public function error403(): void {
        http_response_code(403);
        $this->render('error/403', [
            'hideChrome' => false
        ]);
    }
    
    public function error500(): void {
        http_response_code(500);
        $this->render('error/500', [
            'hideChrome' => false
        ]);
    }
}