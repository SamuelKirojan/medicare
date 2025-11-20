<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <div class="content-wrapper">
                <!-- Welcome Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Welcome, <?php echo htmlspecialchars($userName); ?>!</h2>
                        <p class="text-muted mb-0">
                            <?php if ($isDoctor): ?>
                                <i class="bi bi-person-badge me-1"></i>Doctor Dashboard - View patient records and medications
                            <?php else: ?>
                                <i class="bi bi-clipboard2-pulse me-1"></i>Nurse Dashboard - Manage patients and medications
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if ($isNurse): ?>
                        <div>
                            <a href="index.php?r=patients/create" class="btn btn-primary me-2">
                                <i class="bi bi-person-plus me-1"></i>Add Patient
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card patients">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-2">Total Patients</h6>
                                        <h2 class="mb-0"><?php echo $totalPatients; ?></h2>
                                    </div>
                                    <div class="text-primary">
                                        <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <a href="index.php?r=patients/index" class="text-primary text-decoration-none small">
                                    View all patients <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card medications">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-2">Active Medications</h6>
                                        <h2 class="mb-0"><?php echo $activeMedications; ?></h2>
                                    </div>
                                    <div class="text-success">
                                        <i class="bi bi-capsule" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <span class="text-muted small">Currently prescribed</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card attention">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-2">Need Attention</h6>
                                        <h2 class="mb-0"><?php echo count($patientsNeedingAttention); ?></h2>
                                    </div>
                                    <div class="text-warning">
                                        <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <span class="text-muted small">Medications ending soon</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="index.php" method="GET" class="d-flex">
                            <input type="hidden" name="r" value="patients/index">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" name="search" placeholder="Search patients by name, phone, or allergies...">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <!-- Recent Patients -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Recently Updated Patients</h5>
                                <a href="index.php?r=patients/index" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body p-0">
                                <?php if (empty($recentPatients)): ?>
                                    <div class="p-4 text-center text-muted">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">No patients yet</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Age</th>
                                                    <th>Allergies</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recentPatients as $patient): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($patient['name']); ?></strong>
                                                        </td>
                                                        <td><?php echo $patient['age']; ?></td>
                                                        <td>
                                                            <?php if ($patient['allergies']): ?>
                                                                <span class="badge bg-warning text-dark">
                                                                    <?php echo htmlspecialchars(substr($patient['allergies'], 0, 20)); ?>
                                                                    <?php echo strlen($patient['allergies']) > 20 ? '...' : ''; ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-muted">None</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="index.php?r=patients/info&id=<?php echo $patient['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                                View
                                                            </a>
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

                    <!-- Recent Medications -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Recent Medication Activity</h5>
                            </div>
                            <div class="card-body p-0">
                                <?php if (empty($recentMedications)): ?>
                                    <div class="p-4 text-center text-muted">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">No medications yet</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Medication</th>
                                                    <th>Patient</th>
                                                    <th>Dosage</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recentMedications as $med): ?>
                                                    <tr>
                                                        <td><strong><?php echo htmlspecialchars($med['name']); ?></strong></td>
                                                        <td><?php echo htmlspecialchars($med['patient_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($med['dosage']); ?></td>
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

                <!-- Activity Log -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recentActivity)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No recent activity</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between">
                                        <strong><?php echo htmlspecialchars($activity['action']); ?></strong>
                                        <small><?php echo date('M j, g:i A', strtotime($activity['created_at'])); ?></small>
                                    </div>
                                    <p class="mb-1"><?php echo htmlspecialchars($activity['description'] ?? ''); ?></p>
                                    <small>
                                        <i class="bi bi-person me-1"></i>
                                        <?php echo htmlspecialchars($activity['user_name'] ?? ucfirst($activity['user_type'])); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
