<div class="container-fluid">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Medication History</h2>
                <p class="text-muted mb-0">
                    Complete medication history for <strong><?php echo htmlspecialchars($patient['name']); ?></strong>
                </p>
            </div>
            <?php if ($isNurse): ?>
                <a href="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" class="btn btn-primary">
                    <i class="bi bi-capsule me-1"></i>Add Medication
                </a>
            <?php endif; ?>
        </div>

        <!-- Medications Table -->
        <div class="card">
            <div class="card-body p-0">
                <?php if (empty($medications)): ?>
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-capsule" style="font-size: 3rem;"></i>
                        <p class="mb-0 mt-3">No medication history available</p>
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
                                    <th>Prescribed By</th>
                                    <th>Last Updated By</th>
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
                                            <?php echo htmlspecialchars($med['created_by_name'] ?? 'Unknown'); ?>
                                            <br>
                                            <small class="text-muted">
                                                <?php echo date('M j, Y', strtotime($med['created_at'])); ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if ($med['updated_by_name']): ?>
                                                <?php echo htmlspecialchars($med['updated_by_name']); ?>
                                                <br>
                                                <small class="text-muted">
                                                    <?php echo date('M j, Y', strtotime($med['updated_at'])); ?>
                                                </small>
                                            <?php else: ?>
                                                -
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

        <!-- Back Button -->
        <div class="mt-3">
            <a href="index.php?r=patients/info&id=<?php echo $patient['id']; ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Patient
            </a>
        </div>
    </div>
</div>
