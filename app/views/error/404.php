<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-page">
                <div class="error-icon mb-4">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 6rem; color: #ffc107;"></i>
                </div>
                <h1 class="display-1 fw-bold text-primary mb-3">404</h1>
                <h2 class="mb-3">Page Not Found</h2>
                <p class="lead text-muted mb-4">
                    Sorry, the page you're looking for doesn't exist or has been moved.
                </p>
                
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
                    <p class="text-muted small">
                        If you believe this is an error, please contact the system administrator.
                    </p>
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
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}
</style>