<?php
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Database.php';
require_once APP_ROOT . '/app/models/Patient.php';
require_once APP_ROOT . '/app/models/Medication.php';
require_once APP_ROOT . '/app/models/ActivityLog.php';

class MedicationsController extends Controller {
    private function requireLogin(): bool {
        if (empty($_SESSION['doctor_id']) && empty($_SESSION['nurse_id'])) {
            header('Location: index.php?r=auth/account');
            return false;
        }
        return true;
    }

    private function requireDoctor(): bool {
        if (empty($_SESSION['doctor_id'])) {
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
        
        $medications = Medication::getAll();
        
        $this->render('medications/index', [
            'medications' => $medications,
            'isNurse' => $this->isNurse(),
            'isDoctor' => $this->isDoctor(),
            'hideLandingLinks' => true
        ]);
    }

    public function add(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireDoctor()) return;
        
        $patientId = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : 0;
        if ($patientId <= 0) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $patient = Patient::findById($patientId);
        if (!$patient) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $patientId,
                'name' => trim($_POST['name'] ?? ''),
                'dosage' => trim($_POST['dosage'] ?? ''),
                'frequency' => trim($_POST['frequency'] ?? ''),
                'route' => trim($_POST['route'] ?? 'Oral'),
                'start_date' => $_POST['start_date'] ?? date('Y-m-d'),
                'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
                'status' => 'Active',
                'instructions' => trim($_POST['instructions'] ?? ''),
                'created_by' => $_SESSION['doctor_id']
            ];
            
            if (empty($data['name'])) {
                $error = 'Medication name is required.';
            } elseif (empty($data['dosage'])) {
                $error = 'Dosage is required.';
            } elseif (empty($data['frequency'])) {
                $error = 'Frequency is required.';
            } else {
                try {
                    $id = Medication::create($data);
                    ActivityLog::create('doctor', $_SESSION['doctor_id'], 'Added Medication', "Added {$data['name']} {$data['dosage']} for {$patient['name']}", 'medication', $id);
                    header('Location: index.php?r=patients/info&id=' . $patientId);
                    exit;
                } catch (Exception $e) {
                    $error = 'Failed to add medication: ' . $e->getMessage();
                }
            }
        }
        
        $this->render('medications/add', [
            'patient' => $patient,
            'error' => $error,
            'isDoctor' => true,
            'hideLandingLinks' => true
        ]);
    }

    public function update(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireDoctor()) return;
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?r=menu/index');
            return;
        }
        
        $medication = Medication::findById($id);
        if (!$medication) {
            header('Location: index.php?r=menu/index');
            return;
        }
        
        $patient = Patient::findById($medication['patient_id']);
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'dosage' => trim($_POST['dosage'] ?? ''),
                'frequency' => trim($_POST['frequency'] ?? ''),
                'route' => trim($_POST['route'] ?? 'Oral'),
                'start_date' => $_POST['start_date'] ?? $medication['start_date'],
                'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
                'status' => $_POST['status'] ?? 'Active',
                'instructions' => trim($_POST['instructions'] ?? ''),
                'updated_by' => $_SESSION['doctor_id']
            ];
            
            if (empty($data['name'])) {
                $error = 'Medication name is required.';
            } elseif (empty($data['dosage'])) {
                $error = 'Dosage is required.';
            } elseif (empty($data['frequency'])) {
                $error = 'Frequency is required.';
            } else {
                try {
                    Medication::update($id, $data);
                    ActivityLog::create('doctor', $_SESSION['doctor_id'], 'Updated Medication', "Updated {$data['name']} for {$patient['name']}", 'medication', $id);
                    header('Location: index.php?r=patients/info&id=' . $medication['patient_id']);
                    exit;
                } catch (Exception $e) {
                    $error = 'Failed to update medication: ' . $e->getMessage();
                }
            }
            
            // Update medication array with new data for display
            $medication = array_merge($medication, $data);
        }
        
        $this->render('medications/update', [
            'medication' => $medication,
            'patient' => $patient,
            'error' => $error,
            'isDoctor' => true,
            'hideLandingLinks' => true
        ]);
    }

    public function stop(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireDoctor()) return;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?r=menu/index');
            return;
        }
        
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?r=menu/index');
            return;
        }
        
        $medication = Medication::findById($id);
        if ($medication) {
            Medication::update($id, [
                'status' => 'Stopped',
                'end_date' => date('Y-m-d'),
                'updated_by' => $_SESSION['doctor_id']
            ]);
            
            $patient = Patient::findById($medication['patient_id']);
            ActivityLog::create('doctor', $_SESSION['doctor_id'], 'Stopped Medication', "Stopped {$medication['name']} for {$patient['name']}", 'medication', $id);
            
            header('Location: index.php?r=patients/info&id=' . $medication['patient_id']);
            exit;
        }
        
        header('Location: index.php?r=menu/index');
    }

    public function history(): void {
        if (!$this->requireLogin()) return;
        
        $patientId = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : 0;
        if ($patientId <= 0) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $patient = Patient::findById($patientId);
        if (!$patient) {
            header('Location: index.php?r=patients/index');
            return;
        }
        
        $medications = Medication::getHistory($patientId);
        
        $this->render('medications/history', [
            'patient' => $patient,
            'medications' => $medications,
            'isNurse' => $this->isNurse(),
            'isDoctor' => $this->isDoctor(),
            'hideLandingLinks' => true
        ]);
    }

    public function delete(): void {
        if (!$this->requireLogin()) return;
        if (!$this->requireDoctor()) return;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?r=menu/index');
            return;
        }
        
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?r=menu/index');
            return;
        }
        
        $medication = Medication::findById($id);
        if ($medication) {
            $patientId = $medication['patient_id'];
            $patient = Patient::findById($patientId);
            
            Medication::delete($id);
            ActivityLog::create('doctor', $_SESSION['doctor_id'], 'Deleted Medication', "Deleted {$medication['name']} for {$patient['name']}", 'medication', $id);
            
            header('Location: index.php?r=patients/info&id=' . $patientId);
            exit;
        }
        
        header('Location: index.php?r=menu/index');
    }
    private function requireDoctor(): bool {
        if (empty($_SESSION['doctor_id'])) {
            header('Location: index.php?r=error/error403');
            return false;
        }
        return true;
    }
}