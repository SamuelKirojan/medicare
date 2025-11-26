<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><?php echo htmlspecialchars($patient['name']); ?></h2>
        <p class="text-muted mb-0">Patient Details</p>
    </div>
    <div>
        <?php if ($isNurse): ?>
            <a href="index.php?r=patients/update&id=<?php echo $patient['id']; ?>" class="btn btn-outline-primary me-2">
                <i class="bi bi-pencil me-1"></i>Edit Patient
            </a>
            <?php if (empty($medications)): ?>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash me-1"></i>Delete Patient
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-outline-secondary" disabled title="Cannot delete patient with medication history">
                    <i class="bi bi-trash me-1"></i>Delete Patient
                </button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($isDoctor): ?>
            <a href="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" class="btn btn-primary">
                <i class="bi bi-capsule me-1"></i>Add Medication
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Success Message -->
<?php if (isset($_SESSION['delete_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['delete_success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['delete_success']); ?>
<?php endif; ?>

<!-- Error Message -->
<?php if (isset($_SESSION['delete_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($_SESSION['delete_error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['delete_error']); ?>
<?php endif; ?>

<!-- Patient Information Cards -->
<div class="row mb-4">
    <!-- Basic Information -->
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Patient Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Patient ID</small>
                    <p class="mb-0 fw-bold">#<?php echo $patient['id']; ?></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Name</small>
                    <p class="mb-0 fw-bold"><?php echo htmlspecialchars($patient['name']); ?></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Age</small>
                    <p class="mb-0"><?php echo $patient['age']; ?> years</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Gender</small>
                    <p class="mb-0"><?php echo htmlspecialchars($patient['gender']); ?></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Phone</small>
                    <p class="mb-0"><?php echo htmlspecialchars($patient['phone'] ?? 'N/A'); ?></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Blood Type</small>
                    <p class="mb-0">
                        <span class="badge bg-danger"><?php echo htmlspecialchars($patient['blood_type'] ?? 'Unknown'); ?></span>
                    </p>
                </div>
                <div>
                    <small class="text-muted">Address</small>
                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($patient['address'] ?? 'N/A')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Medical Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Allergies</small>
                    <?php if (!empty($patient['allergies'])): ?>
                        <div class="alert alert-warning mt-2 mb-0">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            <?php echo nl2br(htmlspecialchars($patient['allergies'])); ?>
                        </div>
                    <?php else: ?>
                        <p class="mb-0 text-success"><i class="bi bi-check-circle me-1"></i>No known allergies</p>
                    <?php endif; ?>
                </div>
                <div>
                    <small class="text-muted">Notes</small>
                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($patient['notes'] ?? 'No additional notes')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Contact -->
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-telephone-forward me-2"></i>Emergency Contact</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Contact Name</small>
                    <p class="mb-0 fw-bold"><?php echo htmlspecialchars($patient['emergency_contact'] ?? 'N/A'); ?></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Contact Phone</small>
                    <p class="mb-0">
                        <?php if (!empty($patient['emergency_phone'])): ?>
                            <a href="tel:<?php echo htmlspecialchars($patient['emergency_phone']); ?>">
                                <i class="bi bi-telephone me-1"></i><?php echo htmlspecialchars($patient['emergency_phone']); ?>
                            </a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </p>
                </div>
                <div>
                    <small class="text-muted">Created</small>
                    <p class="mb-0"><?php echo date('M j, Y', strtotime($patient['created_at'])); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Medications Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Current Medications</h5>
        <div>
            <?php if ($isDoctor): ?>
                <a href="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus me-1"></i>Add Medication
                </a>
            <?php endif; ?>
            <a href="index.php?r=medications/history&patient_id=<?php echo $patient['id']; ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-clock-history me-1"></i>View History
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($medications)): ?>
            <div class="text-center py-5">
                <i class="bi bi-capsule" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">No medications prescribed yet.</p>
                <?php if ($isDoctor): ?>
                    <a href="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" class="btn btn-primary">
                        <i class="bi bi-plus me-1"></i>Add First Medication
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Route</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <?php if ($isDoctor): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medications as $med): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($med['name']); ?></td>
                                <td><?php echo htmlspecialchars($med['dosage']); ?></td>
                                <td><?php echo htmlspecialchars($med['frequency']); ?></td>
                                <td><?php echo htmlspecialchars($med['route']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($med['start_date'])); ?></td>
                                <td>
                                    <?php
                                    $statusClass = $med['status'] === 'Active' ? 'badge-active' : ($med['status'] === 'Stopped' ? 'badge-stopped' : 'badge-completed');
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $med['status']; ?></span>
                                </td>
                                <?php if ($isDoctor): ?>
                                    <td>
                                        <a href="index.php?r=medications/update&id=<?php echo $med['id']; ?>" 
                                           class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($med['status'] === 'Active'): ?>
                                            <form method="POST" action="index.php?r=medications/stop" style="display: inline;">
                                                <input type="hidden" name="id" value="<?php echo $med['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Stop" 
                                                        onclick="return confirm('Stop this medication?');">
                                                    <i class="bi bi-stop-circle"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Activity Log Section -->
<?php if (!empty($activityLogs)): ?>
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Activity Log</h5>
    </div>
    <div class="card-body">
        <?php foreach ($activityLogs as $log): ?>
            <div class="activity-item">
                <div class="d-flex justify-content-between">
                    <strong><?php echo htmlspecialchars($log['action']); ?></strong>
                    <small class="text-muted"><?php echo date('M j, Y - g:i A', strtotime($log['created_at'])); ?></small>
                </div>
                <p class="mb-1"><?php echo htmlspecialchars($log['description']); ?></p>
                <small class="text-muted">
                    <i class="bi bi-person me-1"></i>
                    <?php echo htmlspecialchars($log['user_name'] ?? 'System'); ?>
                </small>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Back Button -->
<div class="mt-3">
    <a href="index.php?r=patients/index" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Patients
    </a>
</div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<?php if ($isNurse && empty($medications)): ?>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this patient?</p>
                <div class="alert alert-warning">
                    <strong>Patient:</strong> <?php echo htmlspecialchars($patient['name']); ?><br>
                    <strong>Age:</strong> <?php echo $patient['age']; ?><br>
                    <strong>ID:</strong> #<?php echo $patient['id']; ?>
                </div>
                <p class="text-danger mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <form method="POST" action="index.php?r=patients/delete" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $patient['id']; ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Yes, Delete Patient
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>