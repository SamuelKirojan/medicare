<?php
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/models/Doctor.php';
require_once APP_ROOT . '/app/models/Nurse.php';
require_once APP_ROOT . '/app/models/ActivityLog.php';

class AuthController extends Controller {
    public function account(): void {
        $tab = $_GET['t'] ?? 'doctor';
        $this->render('auth/account', ['tab' => $tab, 'hideChrome' => true]);
    }
    
    public function login(): void {
        $error = null;
        $role = $_POST['role'] ?? 'doctor';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if ($role === 'doctor') {
                $user = Doctor::findByEmail($email);
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['doctor_id'] = (int)$user['id'];
                    $_SESSION['doctor_email'] = $user['email'];
                    $_SESSION['doctor_name'] = $user['name'];
                    $_SESSION['role'] = 'doctor';
                    
                    ActivityLog::create('doctor', $user['id'], 'Login', 'Doctor logged in');
                    
                    header('Location: index.php?r=menu/index');
                    exit;
                }
                $error = 'Invalid email or password.';
            } else {
                $user = Nurse::findByEmail($email);
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['nurse_id'] = (int)$user['id'];
                    $_SESSION['nurse_email'] = $user['email'];
                    $_SESSION['nurse_name'] = $user['name'];
                    $_SESSION['role'] = 'nurse';
                    
                    ActivityLog::create('nurse', $user['id'], 'Login', 'Nurse logged in');
                    
                    header('Location: index.php?r=menu/index');
                    exit;
                }
                $error = 'Invalid email or password.';
            }
        }
        
        $this->render('auth/account', ['tab' => $role, 'error' => $error, 'hideChrome' => true]);
    }

    public function logout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
        
        // Log the logout action
        if (!empty($_SESSION['doctor_id'])) {
            ActivityLog::create('doctor', $_SESSION['doctor_id'], 'Logout', 'Doctor logged out');
        } elseif (!empty($_SESSION['nurse_id'])) {
            ActivityLog::create('nurse', $_SESSION['nurse_id'], 'Logout', 'Nurse logged out');
        }
        
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: index.php?r=home/index');
        exit;
    }
}
