<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Patients</h2>
        <p class="text-muted mb-0">Manage patient records</p>
    </div>
    <?php if ($isNurse): ?>
        <div>
            <a href="index.php?r=patients/create" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Add Patient
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Success Message -->
<?php if (isset($_SESSION['delete_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['delete_success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['delete_success']); ?>
<?php endif; ?>

<!-- Search Bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="index.php" class="row g-3">
            <input type="hidden" name="r" value="patients/index">
            <div class="col-md-10">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search by name, allergies, or notes..." 
                       value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Search
                </button>
            </div>
        </form>
        <?php if (!empty($search)): ?>
            <div class="mt-2">
                <a href="index.php?r=patients/index" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>Clear Search
                </a>
                <span class="ms-2 text-muted">Found <?php echo count($patients); ?> result(s)</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Patients Table -->
<div class="card">
    <div class="card-body">
        <?php if (empty($patients)): ?>
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">
                    <?php if (!empty($search)): ?>
                        No patients found matching "<?php echo htmlspecialchars($search); ?>"
                    <?php else: ?>
                        No patients registered yet.
                    <?php endif; ?>
                </p>
                <?php if ($isNurse): ?>
                    <a href="index.php?r=patients/create" class="btn btn-primary">
                        <i class="bi bi-person-plus me-1"></i>Add First Patient
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Blood Type</th>
                            <th>Allergies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>#<?php echo $patient['id']; ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($patient['name']); ?></td>
                                <td><?php echo $patient['age']; ?></td>
                                <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                                <td><?php echo htmlspecialchars($patient['phone'] ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge bg-danger">
                                        <?php echo htmlspecialchars($patient['blood_type'] ?? 'N/A'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $allergies = $patient['allergies'] ?? '';
                                    if (!empty($allergies)):
                                        $shortAllergies = strlen($allergies) > 30 ? substr($allergies, 0, 30) . '...' : $allergies;
                                    ?>
                                        <span class="text-warning" title="<?php echo htmlspecialchars($allergies); ?>">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            <?php echo htmlspecialchars($shortAllergies); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">None</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?r=patients/info&id=<?php echo $patient['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($isNurse): ?>
                                        <a href="index.php?r=patients/update&id=<?php echo $patient['id']; ?>" 
                                           class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <?php
                                        // Check if patient has medications (simple count)
                                        require_once APP_ROOT . '/app/models/Medication.php';
                                        $patientMeds = Medication::getByPatientId($patient['id']);
                                        $hasMedications = !empty($patientMeds);
                                        ?>
                                        
                                        <?php if (!$hasMedications): ?>
                                            <form method="POST" action="index.php?r=patients/delete" style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete <?php echo htmlspecialchars($patient['name']); ?>? This action cannot be undone.');">
                                                <input type="hidden" name="id" value="<?php echo $patient['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled 
                                                    title="Cannot delete - patient has medication history">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

        </div>
    </div>
</div>