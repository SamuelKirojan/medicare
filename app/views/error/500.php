<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-page">
                <div class="error-icon mb-4">
                    <i class="bi bi-exclamation-octagon-fill" style="font-size: 6rem; color: #6c757d;"></i>
                </div>
                <h1 class="display-1 fw-bold text-secondary mb-3">500</h1>
                <h2 class="mb-3">Internal Server Error</h2>
                <p class="lead text-muted mb-4">
                    Oops! Something went wrong on our end.
                </p>
                
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-bug me-2"></i>
                    We're experiencing technical difficulties. Please try again later.
                </div>
                
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="javascript:location.reload()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Try Again
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
                        Error Code: 500 - Internal Server Error<br>
                        If this problem persists, please contact technical support.
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
    animation: rotate 2s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>