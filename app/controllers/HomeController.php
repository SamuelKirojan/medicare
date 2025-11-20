<?php
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Database.php';

class HomeController extends Controller {
    public function index(): void {
        // If already logged in, redirect to dashboard
        if (!empty($_SESSION['doctor_id']) || !empty($_SESSION['nurse_id'])) {
            header('Location: index.php?r=menu/index');
            exit;
        }
        $this->render('home/landing', ['hideChrome' => true]);
    }
}
