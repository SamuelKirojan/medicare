<?php
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Database.php';
require_once APP_ROOT . '/app/models/Patient.php';
require_once APP_ROOT . '/app/models/Medication.php';
require_once APP_ROOT . '/app/models/ActivityLog.php';
require_once APP_ROOT . '/app/models/Nurse.php';
require_once APP_ROOT . '/app/models/Doctor.php';

class PatientsController extends Controller {
    private function requireLogin(): bool {
        if (empty($_SESSION['doctor_id']) && empty($_SESSION['nurse_id'])) {
            header('Location: index.php?r=auth/account');
            return false;
        }
        return true;
    }

    private function requireNurse(): bool {
        if (empty($_SESSION['nurse_id'])) {
            header('Location: index.php?r=menu/index');
            return false;
        }
        return true;
    }

    private function isNurse(): bool {
        return !empty($_SESSION['nurse_id']);
    }

    private function isDoctor(): bool {
        return !empty($_SESSION['doctor_id']);
    }

    public function index(): void {
        if (!$this->requireLogin()) return;
        
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        if (!empty($search)) {
            $patients = Patient::search($search);
        } else {
            $patients = Patient::getAll();
        }
        
        $this->render('patients/index', [
            'patients' => $patients,
            'search' => $search,
            'isNurse' => $this->isNurse(),
            'isDoctor' => $this->isDoctor(),
            'hideLandingLinks' => true
        ]);
    }

    public function info(): void {
        if (!$this->requireLogin()) return;
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $patient = Patient::findById($id);
        if (!$patient) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $medications = Medication::getByPatientId($id);
        $activityLogs = ActivityLog::getByEntity('patient', $id);
        
        // Log doctor views
        if ($this->isDoctor()) {
            ActivityLog::create('doctor', $_SESSION['doctor_id'], 'Viewed Patient', "Viewed patient record for {$patient['name']}", 'patient', $id);
        }
        
        $this->render('patients/info', [
            'patient' => $patient,
            'medications' => $medications,
            'activityLogs' => $activityLogs,
            'isNurse' => $this->isNurse(),
            'isDoctor' => $this->isDoctor(),
            'hideLandingLinks' => true
        ]);
    }

    public function create(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireNurse()) return;
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'age' => (int)($_POST['age'] ?? 0),
                'gender' => $_POST['gender'] ?? 'Male',
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'allergies' => trim($_POST['allergies'] ?? ''),
                'blood_type' => trim($_POST['blood_type'] ?? ''),
                'emergency_contact' => trim($_POST['emergency_contact'] ?? ''),
                'emergency_phone' => trim($_POST['emergency_phone'] ?? ''),
                'notes' => trim($_POST['notes'] ?? ''),
                'created_by' => $_SESSION['nurse_id']
            ];
            
            if (empty($data['name'])) {
                $error = 'Patient name is required.';
            } elseif ($data['age'] <= 0) {
                $error = 'Valid age is required.';
            } else {
                try {
                    $id = Patient::create($data);
                    ActivityLog::create('nurse', $_SESSION['nurse_id'], 'Created Patient', "Created patient record for {$data['name']}", 'patient', $id);
                    header('Location: index.php?r=patients/info&id=' . $id);
                    exit;
                } catch (Exception $e) {
                    $error = 'Failed to create patient: ' . $e->getMessage();
                }
            }
        }
        
        $this->render('patients/create', [
            'error' => $error,
            'isNurse' => true,
            'hideLandingLinks' => true
        ]);
    }

    public function update(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireNurse()) return;
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $patient = Patient::findById($id);
        if (!$patient) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'age' => (int)($_POST['age'] ?? 0),
                'gender' => $_POST['gender'] ?? 'Male',
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'allergies' => trim($_POST['allergies'] ?? ''),
                'blood_type' => trim($_POST['blood_type'] ?? ''),
                'emergency_contact' => trim($_POST['emergency_contact'] ?? ''),
                'emergency_phone' => trim($_POST['emergency_phone'] ?? ''),
                'notes' => trim($_POST['notes'] ?? '')
            ];
            
            if (empty($data['name'])) {
                $error = 'Patient name is required.';
            } elseif ($data['age'] <= 0) {
                $error = 'Valid age is required.';
            } else {
                try {
                    Patient::update($id, $data);
                    ActivityLog::create('nurse', $_SESSION['nurse_id'], 'Updated Patient', "Updated patient record for {$data['name']}", 'patient', $id);
                    header('Location: index.php?r=patients/info&id=' . $id);
                    exit;
                } catch (Exception $e) {
                    $error = 'Failed to update patient: ' . $e->getMessage();
                }
            }
            
            // Update patient array with new data for display
            $patient = array_merge($patient, $data);
        }
        
        $this->render('patients/update', [
            'patient' => $patient,
            'error' => $error,
            'isNurse' => true,
            'hideLandingLinks' => true
        ]);
    }

    public function delete(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireNurse()) return;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $patient = Patient::findById($id);
        if (!$patient) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        // Check if patient has any medications
        $medications = Medication::getByPatientId($id);
        
        if (!empty($medications)) {
            // Patient has medications - cannot delete
            $_SESSION['delete_error'] = 'Cannot delete patient with medication history. Patient has ' . count($medications) . ' medication(s) on record.';
            header('Location: index.php?r=patients/info&id=' . $id);
            exit;
        }
        
        // No medications - safe to delete
        try {
            Patient::delete($id);
            ActivityLog::create('nurse', $_SESSION['nurse_id'], 'Deleted Patient', "Deleted patient record for {$patient['name']}", 'patient', $id);
            $_SESSION['delete_success'] = "Patient {$patient['name']} has been deleted successfully.";
            header('Location: index.php?r=patients/index');
            exit;
        } catch (Exception $e) {
            $_SESSION['delete_error'] = 'Failed to delete patient: ' . $e->getMessage();
            header('Location: index.php?r=patients/info&id=' . $id);
            exit;
        }
    }

    public function search(): void {
        if (!$this->requireLogin()) return;
        
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($query)) {
            echo json_encode([]);
            return;
        }
        
        $patients = Patient::search($query);
        
        $results = array_map(function($patient) {
            return [
                'id' => $patient['id'],
                'name' => $patient['name'],
                'age' => $patient['age'],
                'gender' => $patient['gender']
            ];
        }, $patients);
        
        header('Content-Type: application/json');
        echo json_encode($results);
    }
}