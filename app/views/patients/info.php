<div class="container-fluid">
    <div class="content-wrapper">
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
                    <a href="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" class="btn btn-primary">
                        <i class="bi bi-capsule me-1"></i>Add Medication
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <!-- Patient Information -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted" width="40%">ID</td>
                                <td><strong>#<?php echo $patient['id']; ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Name</td>
                                <td><strong><?php echo htmlspecialchars($patient['name']); ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Age</td>
                                <td><?php echo $patient['age']; ?> years</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Gender</td>
                                <td><?php echo $patient['gender']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phone</td>
                                <td><?php echo htmlspecialchars($patient['phone'] ?? 'Not provided'); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Blood Type</td>
                                <td>
                                    <?php if ($patient['blood_type']): ?>
                                        <span class="badge bg-danger"><?php echo htmlspecialchars($patient['blood_type']); ?></span>
                                    <?php else: ?>
                                        Not specified
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Address</td>
                                <td><?php echo htmlspecialchars($patient['address'] ?? 'Not provided'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-heart-pulse me-2"></i>Medical Information</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-muted mb-2">Allergies</h6>
                        <?php if ($patient['allergies']): ?>
                            <div class="alert alert-warning py-2">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <?php echo htmlspecialchars($patient['allergies']); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No known allergies</p>
                        <?php endif; ?>

                        <h6 class="text-muted mb-2 mt-3">Notes</h6>
                        <?php if ($patient['notes']): ?>
                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($patient['notes'])); ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-0">No notes</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-telephone me-2"></i>Emergency Contact</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($patient['emergency_contact'] || $patient['emergency_phone']): ?>
                            <p class="mb-1">
                                <strong><?php echo htmlspecialchars($patient['emergency_contact'] ?? 'Not provided'); ?></strong>
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="bi bi-telephone me-1"></i>
                                <?php echo htmlspecialchars($patient['emergency_phone'] ?? 'No phone'); ?>
                            </p>
                        <?php else: ?>
                            <p class="text-muted mb-0">No emergency contact provided</p>
                        <?php endif; ?>

                        <hr>

                        <small class="text-muted">
                            <strong>Created:</strong> <?php echo date('M j, Y', strtotime($patient['created_at'])); ?>
                            <?php if ($patient['created_by_name']): ?>
                                by <?php echo htmlspecialchars($patient['created_by_name']); ?>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medications -->
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Medications</h5>
                <div>
                    <a href="index.php?r=medications/history&patient_id=<?php echo $patient['id']; ?>" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-clock-history me-1"></i>View History
                    </a>
                    <?php if ($isNurse): ?>
                        <a href="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus me-1"></i>Add Medication
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($medications)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-capsule" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">No medications prescribed</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Medication</th>
                                    <th>Dosage</th>
                                    <th>Frequency</th>
                                    <th>Route</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Instructions</th>
                                    <?php if ($isNurse): ?>
                                        <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($medications as $med): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($med['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($med['dosage']); ?></td>
                                        <td><?php echo htmlspecialchars($med['frequency']); ?></td>
                                        <td><?php echo htmlspecialchars($med['route']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($med['start_date'])); ?></td>
                                        <td>
                                            <?php echo $med['end_date'] ? date('M j, Y', strtotime($med['end_date'])) : '-'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = 'bg-success';
                                            if ($med['status'] === 'Stopped') $statusClass = 'bg-danger';
                                            elseif ($med['status'] === 'Completed') $statusClass = 'bg-secondary';
                                            ?>
                                            <span class="badge <?php echo $statusClass; ?>">
                                                <?php echo $med['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($med['instructions']): ?>
                                                <small title="<?php echo htmlspecialchars($med['instructions']); ?>">
                                                    <?php echo htmlspecialchars(substr($med['instructions'], 0, 30)); ?>
                                                    <?php echo strlen($med['instructions']) > 30 ? '...' : ''; ?>
                                                </small>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <?php if ($isNurse): ?>
                                            <td>
                                                <a href="index.php?r=medications/update&id=<?php echo $med['id']; ?>" 
                                                   class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <?php if ($med['status'] === 'Active'): ?>
                                                    <form method="POST" action="index.php?r=medications/stop" class="d-inline" 
                                                          onsubmit="return confirm('Stop this medication?');">
                                                        <input type="hidden" name="id" value="<?php echo $med['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Stop">
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

        <!-- Back Button -->
        <div class="mt-3">
            <a href="index.php?r=patients/index" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Patients
            </a>
        </div>
    </div>
</div>
