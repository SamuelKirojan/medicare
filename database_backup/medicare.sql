-- MediCare Portal Database Schema
-- Drop existing tables if they exist
DROP TABLE IF EXISTS medications;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS nurses;
DROP TABLE IF EXISTS doctors;

-- Doctors table
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    specialty VARCHAR(100) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Nurses table
CREATE TABLE nurses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    department VARCHAR(100) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Patients table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') DEFAULT 'Male',
    phone VARCHAR(20) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    allergies TEXT DEFAULT NULL,
    blood_type VARCHAR(5) DEFAULT NULL,
    emergency_contact VARCHAR(100) DEFAULT NULL,
    emergency_phone VARCHAR(20) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_by INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES nurses(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Medications table
CREATE TABLE medications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    dosage VARCHAR(50) NOT NULL,
    frequency VARCHAR(100) NOT NULL,
    route VARCHAR(50) DEFAULT 'Oral',
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    status ENUM('Active', 'Completed', 'Stopped') DEFAULT 'Active',
    instructions TEXT DEFAULT NULL,
    created_by INT DEFAULT NULL,
    updated_by INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES nurses(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES nurses(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Activity logs table
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('doctor', 'nurse') NOT NULL,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    entity_type VARCHAR(50) DEFAULT NULL,
    entity_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
-- Sample doctors (password: password123)
INSERT INTO doctors (name, email, password_hash, specialty, phone) VALUES
('Dr. John Smith', 'john.smith@medicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'General Medicine', '081234567890'),
('Dr. Sarah Johnson', 'sarah.johnson@medicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pediatrics', '081234567891'),
('Dr. Michael Chen', 'michael.chen@medicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Cardiology', '081234567892');

-- Sample nurses (password: password123)
INSERT INTO nurses (name, email, password_hash, department, phone) VALUES
('Nurse Emily Davis', 'emily.davis@medicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'General Ward', '081234567893'),
('Nurse Robert Wilson', 'robert.wilson@medicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ICU', '081234567894'),
('Nurse Lisa Anderson', 'lisa.anderson@medicare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pediatrics', '081234567895');

-- Sample patients
INSERT INTO patients (name, age, gender, phone, address, allergies, blood_type, emergency_contact, emergency_phone, notes, created_by) VALUES
('Alice Brown', 45, 'Female', '081111111111', '123 Main St, City', 'Penicillin, Sulfa drugs', 'A+', 'Bob Brown', '081111111112', 'Regular checkup patient', 1),
('Charlie Wilson', 32, 'Male', '082222222222', '456 Oak Ave, Town', 'None known', 'O+', 'Diana Wilson', '082222222223', 'Diabetes Type 2', 1),
('Eva Martinez', 28, 'Female', '083333333333', '789 Pine Rd, Village', 'Latex', 'B-', 'Frank Martinez', '083333333334', 'Pregnant - 2nd trimester', 2),
('George Lee', 67, 'Male', '084444444444', '321 Elm St, City', 'Aspirin, Ibuprofen', 'AB+', 'Helen Lee', '084444444445', 'Heart condition - monitor closely', 1),
('Hannah Kim', 8, 'Female', '085555555555', '654 Maple Dr, Town', 'Peanuts', 'A-', 'Ian Kim', '085555555556', 'Pediatric patient - asthma', 3);

-- Sample medications
INSERT INTO medications (patient_id, name, dosage, frequency, route, start_date, end_date, status, instructions, created_by) VALUES
(1, 'Lisinopril', '10mg', 'Once daily', 'Oral', '2024-01-15', NULL, 'Active', 'Take in the morning with food', 1),
(1, 'Metformin', '500mg', 'Twice daily', 'Oral', '2024-01-15', NULL, 'Active', 'Take with meals', 1),
(2, 'Metformin', '1000mg', 'Twice daily', 'Oral', '2023-06-01', NULL, 'Active', 'Take with breakfast and dinner', 1),
(2, 'Glipizide', '5mg', 'Once daily', 'Oral', '2023-08-15', NULL, 'Active', 'Take 30 minutes before breakfast', 1),
(3, 'Prenatal Vitamins', '1 tablet', 'Once daily', 'Oral', '2024-02-01', NULL, 'Active', 'Take with food', 2),
(3, 'Folic Acid', '400mcg', 'Once daily', 'Oral', '2024-02-01', NULL, 'Active', 'Take in the morning', 2),
(4, 'Atorvastatin', '20mg', 'Once daily', 'Oral', '2023-03-10', NULL, 'Active', 'Take at bedtime', 1),
(4, 'Aspirin', '81mg', 'Once daily', 'Oral', '2023-03-10', NULL, 'Active', 'Take with food - low dose for heart', 1),
(4, 'Metoprolol', '50mg', 'Twice daily', 'Oral', '2023-03-10', NULL, 'Active', 'Monitor heart rate', 1),
(5, 'Albuterol Inhaler', '2 puffs', 'As needed', 'Inhalation', '2024-01-20', NULL, 'Active', 'Use for asthma attacks, max 4 times daily', 3),
(5, 'Fluticasone Inhaler', '1 puff', 'Twice daily', 'Inhalation', '2024-01-20', NULL, 'Active', 'Preventive - rinse mouth after use', 3);

-- Sample activity logs
INSERT INTO activity_logs (user_type, user_id, action, description, entity_type, entity_id) VALUES
('nurse', 1, 'Created Patient', 'Created patient record for Alice Brown', 'patient', 1),
('nurse', 1, 'Added Medication', 'Added Lisinopril 10mg for Alice Brown', 'medication', 1),
('nurse', 1, 'Added Medication', 'Added Metformin 500mg for Alice Brown', 'medication', 2),
('nurse', 1, 'Created Patient', 'Created patient record for Charlie Wilson', 'patient', 2),
('nurse', 2, 'Created Patient', 'Created patient record for Eva Martinez', 'patient', 3),
('doctor', 1, 'Viewed Patient', 'Viewed patient record for George Lee', 'patient', 4),
('nurse', 3, 'Updated Medication', 'Updated dosage for Albuterol Inhaler', 'medication', 10);
