<div class="container-fluid">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Patients</h2>
                <p class="text-muted mb-0">Manage patient records</p>
            </div>
            <?php if ($isNurse): ?>
                <a href="index.php?r=patients/create" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Add Patient
                </a>
            <?php endif; ?>
        </div>

        <!-- Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="index.php" method="GET" class="d-flex">
                    <input type="hidden" name="r" value="patients/index">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search" 
                               value="<?php echo htmlspecialchars($search ?? ''); ?>" 
                               placeholder="Search by name, phone, or allergies...">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <?php if ($search): ?>
                            <a href="index.php?r=patients/index" class="btn btn-outline-secondary">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="card">
            <div class="card-body p-0">
                <?php if (empty($patients)): ?>
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mb-0 mt-3">
                            <?php if ($search): ?>
                                No patients found matching "<?php echo htmlspecialchars($search); ?>"
                            <?php else: ?>
                                No patients yet. <?php if ($isNurse): ?>Click "Add Patient" to create one.<?php endif; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
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
                                        <td><?php echo $patient['id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($patient['name']); ?></strong>
                                        </td>
                                        <td><?php echo $patient['age']; ?></td>
                                        <td><?php echo $patient['gender']; ?></td>
                                        <td><?php echo htmlspecialchars($patient['phone'] ?? '-'); ?></td>
                                        <td>
                                            <?php if ($patient['blood_type']): ?>
                                                <span class="badge bg-danger"><?php echo htmlspecialchars($patient['blood_type']); ?></span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($patient['allergies']): ?>
                                                <span class="badge bg-warning text-dark" title="<?php echo htmlspecialchars($patient['allergies']); ?>">
                                                    <?php 
                                                    $allergies = $patient['allergies'];
                                                    echo htmlspecialchars(strlen($allergies) > 25 ? substr($allergies, 0, 25) . '...' : $allergies); 
                                                    ?>
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

        <!-- Back to Dashboard -->
        <div class="mt-3">
            <a href="index.php?r=menu/index" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
            </a>
        </div>
    </div>
</div>
