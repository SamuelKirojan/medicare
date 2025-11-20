<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MediCare Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header i {
            font-size: 3rem;
            color: #667eea;
        }
        .login-header h2 {
            margin-top: 15px;
            font-weight: 700;
            color: #333;
        }
        .login-tabs {
            display: flex;
            margin-bottom: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 5px;
        }
        .login-tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.3s;
        }
        .login-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .login-tab:hover:not(.active) {
            background: #e9ecef;
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #6c757d;
            text-decoration: none;
        }
        .back-link a:hover {
            color: #667eea;
        }
        .alert {
            border-radius: 10px;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-heart-pulse"></i>
            <h2>MediCare Portal</h2>
        </div>

        <div class="login-tabs">
            <button class="login-tab <?php echo ($tab ?? 'doctor') === 'doctor' ? 'active' : ''; ?>" onclick="switchTab('doctor')">
                <i class="bi bi-person-badge me-2"></i>Doctor
            </button>
            <button class="login-tab <?php echo ($tab ?? '') === 'nurse' ? 'active' : ''; ?>" onclick="switchTab('nurse')">
                <i class="bi bi-clipboard2-pulse me-2"></i>Nurse
            </button>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?r=auth/login" method="POST">
            <input type="hidden" name="role" id="role" value="<?php echo htmlspecialchars($tab ?? 'doctor'); ?>">
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
        </form>

        <div class="back-link">
            <a href="index.php?r=home/index"><i class="bi bi-arrow-left me-1"></i>Back to Home</a>
        </div>

        <div class="mt-4 text-center">
            <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Contact your administrator if you don't have an account.
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchTab(role) {
            document.getElementById('role').value = role;
            
            // Update tab appearance
            document.querySelectorAll('.login-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.closest('.login-tab').classList.add('active');
            
            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('t', role);
            window.history.replaceState({}, '', url);
        }
    </script>
</body>
</html>
