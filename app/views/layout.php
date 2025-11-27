<?php
// Define base URL for assets
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = rtrim($scriptDir, '/');

// If we're in /public/, go up one level for base, but assets are in public
if (basename($baseUrl) === 'public') {
    $baseUrl = dirname($baseUrl) . '/public/';
} else {
    // If not in public subdirectory, assets should be relative to current
    $baseUrl = $baseUrl . '/';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Actpretor Portal</title>
  <meta content="Medical staff portal for patient and medication management" name="description">
  <meta content="healthcare, medical, patients, medications" name="keywords">
  <link href="<?php echo $baseUrl; ?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo $baseUrl; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>assets/css/main.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #6c757d;
      --success-color: #198754;
      --danger-color: #dc3545;
      --warning-color: #ffc107;
      --info-color: #0dcaf0;
    }
    body {
      font-family: 'Inter', 'Open Sans', sans-serif;
      background-color: #f8f9fa;
    }
    .navbar-Actpretor {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .navbar-Actpretor .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }
    .stat-card {
      border-left: 4px solid;
    }
    .stat-card.patients { border-left-color: #0d6efd; }
    .stat-card.medications { border-left-color: #198754; }
    .stat-card.attention { border-left-color: #ffc107; }
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
    }
    .table th {
      font-weight: 600;
      background-color: #f8f9fa;
    }
    .badge-active { background-color: #198754; }
    .badge-stopped { background-color: #dc3545; }
    .badge-completed { background-color: #6c757d; }
    .sidebar {
      min-height: calc(100vh - 56px);
      background-color: #fff;
      border-right: 1px solid #dee2e6;
    }
    .sidebar .nav-link {
      color: #495057;
      padding: 0.75rem 1rem;
      border-radius: 5px;
      margin: 2px 0;
    }
    .sidebar .nav-link:hover {
      background-color: #e9ecef;
    }
    .sidebar .nav-link.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
      width: 20px;
    }
    .content-wrapper {
      min-height: calc(100vh - 56px);
      padding: 20px;
    }
    .user-badge {
      background-color: rgba(255,255,255,0.2);
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.85rem;
    }
    .activity-item {
      border-left: 3px solid #667eea;
      padding-left: 15px;
      margin-bottom: 15px;
    }
    .activity-item small {
      color: #6c757d;
    }
  </style>
</head>
<body>
  <?php if (empty($hideChrome)): ?>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-Actpretor sticky-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php?r=menu/index">
          <i class="bi bi-heart-pulse me-2"></i>Actpretor Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <?php if (!empty($_SESSION['doctor_id']) || !empty($_SESSION['nurse_id'])): ?>
              <li class="nav-item">
                <a class="nav-link" href="index.php?r=menu/index"><i class="bi bi-speedometer2"></i> Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php?r=patients/index"><i class="bi bi-people"></i> Patients</a>
              </li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav">
            <?php if (!empty($_SESSION['doctor_id'])): ?>
              <li class="nav-item">
                <span class="nav-link user-badge">
                  <i class="bi bi-person-badge"></i> Dr. <?php echo htmlspecialchars($_SESSION['doctor_name'] ?? 'Doctor'); ?>
                </span>
              </li>
            <?php elseif (!empty($_SESSION['nurse_id'])): ?>
              <li class="nav-item">
                <span class="nav-link user-badge">
                  <i class="bi bi-person-badge"></i> <?php echo htmlspecialchars($_SESSION['nurse_name'] ?? 'Nurse'); ?>
                </span>
              </li>
            <?php endif; ?>
            <?php if (!empty($_SESSION['doctor_id']) || !empty($_SESSION['nurse_id'])): ?>
              <li class="nav-item">
                <a class="nav-link" href="index.php?r=auth/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="index.php?r=auth/account"><i class="bi bi-box-arrow-in-right"></i> Login</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  <?php endif; ?>

  <main id="main">
    <?php echo $content; ?>
  </main>

  <?php if (empty($hideChrome) && empty($hideFooter)): ?>
    <footer class="bg-dark text-light py-3 mt-auto">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <small>&copy; <?php echo date('Y'); ?> Actpretor Portal. All rights reserved.</small>
          </div>
          <div class="col-md-6 text-md-end">
            <small>Healthcare Management System</small>
          </div>
        </div>
      </div>
    </footer>
  <?php endif; ?>

  <script src="<?php echo $baseUrl; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $baseUrl; ?>assets/vendor/aos/aos.js"></script>
  <script src="<?php echo $baseUrl; ?>assets/js/main.js"></script>
</body>
</html>
