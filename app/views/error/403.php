<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-page">
                <div class="error-icon mb-4">
                    <i class="bi bi-shield-fill-x" style="font-size: 6rem; color: #dc3545;"></i>
                </div>
                <h1 class="display-1 fw-bold text-danger mb-3">403</h1>
                <h2 class="mb-3">Access Forbidden</h2>
                <p class="lead text-muted mb-4">
                    You don't have permission to access this resource.
                </p>
                
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    weh batas jalan weh
                </div>
                
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Go Back
                    </a>
                    <a href="index.php?r=home/index" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Go Home
                    </a>
                    <?php if (!empty($_SESSION['doctor_id']) || !empty($_SESSION['nurse_id'])): ?>
                        <a href="index.php?r=menu/index" class="btn btn-success">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="mt-5">
                    <h5>Common Reasons:</h5>
                    <ul class="list-unstyled text-muted">
                        <li><i class="bi bi-x-circle text-danger me-2"></i>You're not logged in</li>
                        <li><i class="bi bi-x-circle text-danger me-2"></i>Your role doesn't have permission</li>
                        <li><i class="bi bi-x-circle text-danger me-2"></i>The resource is protected</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 50px 0;
}

.error-icon {
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-10px);
    }
    20%, 40%, 60%, 80% {
        transform: translateX(10px);
    }
}
</style>