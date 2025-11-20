<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare Portal - Healthcare Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .hero-content {
            color: white;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .hero-content p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        .btn-login {
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            margin: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-doctor {
            background-color: white;
            color: #667eea;
        }
        .btn-doctor:hover {
            background-color: #f8f9fa;
            color: #5a6fd6;
        }
        .btn-nurse {
            background-color: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        .btn-nurse:hover {
            background-color: white;
            color: #764ba2;
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .feature-icon i {
            font-size: 2rem;
            color: white;
        }
        .features-row {
            margin-top: 3rem;
        }
        .feature-item {
            text-align: center;
            color: white;
        }
        .feature-item h5 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .feature-item p {
            opacity: 0.8;
            font-size: 0.9rem;
        }
        .logo-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center hero-content">
                    <div class="logo-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h1>MediCare Portal</h1>
                    <p>A comprehensive healthcare management system for medical staff. <br>Manage patients, track medications, and streamline your workflow.</p>
                    
                    <div class="login-buttons">
                        <a href="index.php?r=auth/account&t=doctor" class="btn btn-login btn-doctor">
                            <i class="bi bi-person-badge me-2"></i>Doctor Login
                        </a>
                        <a href="index.php?r=auth/account&t=nurse" class="btn btn-login btn-nurse">
                            <i class="bi bi-clipboard2-pulse me-2"></i>Nurse Login
                        </a>
                    </div>

                    <div class="row features-row">
                        <div class="col-md-4">
                            <div class="feature-item">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h5>Patient Management</h5>
                                <p>Complete patient profiles with medical history and allergies</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-item">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-capsule"></i>
                                </div>
                                <h5>Medication Tracking</h5>
                                <p>Track dosages, frequencies, and medication schedules</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-item">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5>Role-Based Access</h5>
                                <p>Secure access with distinct Doctor and Nurse permissions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
