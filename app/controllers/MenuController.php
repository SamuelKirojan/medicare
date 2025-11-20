<?php
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Database.php';
require_once APP_ROOT . '/app/models/Patient.php';
require_once APP_ROOT . '/app/models/Medication.php';
require_once APP_ROOT . '/app/models/ActivityLog.php';

class MenuController extends Controller {
    private function requireLogin(): bool {
        if (empty($_SESSION['doctor_id']) && empty($_SESSION['nurse_id'])) {
            header('Location: index.php?r=auth/account');
            return false;
        }
        return true;
    }

    public function index(): void {
        if (!$this->requireLogin()) return;
        
        // Get dashboard data
        $totalPatients = Patient::count();
        $activeMedications = Medication::countActive();
        $patientsNeedingAttention = Patient::getPatientsNeedingAttention();
        $recentPatients = Patient::getRecent(5);
        $recentMedications = Medication::getRecent(5);
        $recentActivity = ActivityLog::getRecent(10);
        
        // Determine user role and name
        $isNurse = !empty($_SESSION['nurse_id']);
        $isDoctor = !empty($_SESSION['doctor_id']);
        $userName = $isNurse ? ($_SESSION['nurse_name'] ?? 'Nurse') : ($_SESSION['doctor_name'] ?? 'Doctor');
        $userRole = $isNurse ? 'nurse' : 'doctor';
        
        $this->render('menu/shop', [
            'totalPatients' => $totalPatients,
            'activeMedications' => $activeMedications,
            'patientsNeedingAttention' => $patientsNeedingAttention,
            'recentPatients' => $recentPatients,
            'recentMedications' => $recentMedications,
            'recentActivity' => $recentActivity,
            'isNurse' => $isNurse,
            'isDoctor' => $isDoctor,
            'userName' => $userName,
            'userRole' => $userRole,
            'hideLandingLinks' => true
        ]);
    }
}
