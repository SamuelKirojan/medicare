<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-1">Add Medication</h2>
                    <p class="text-muted mb-0">
                        Prescribe medication for <strong><?php echo htmlspecialchars($patient['name']); ?></strong>
                    </p>
                </div>

                <?php if ($patient['allergies']): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Patient Allergies:</strong> <?php echo htmlspecialchars($patient['allergies']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="index.php?r=medications/add&patient_id=<?php echo $patient['id']; ?>" method="POST">
                            <!-- Medication Details -->
                            <h5 class="mb-3"><i class="bi bi-capsule me-2"></i>Medication Details</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Medication Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                           placeholder="e.g., Amoxicillin"
                                           value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dosage" class="form-label">Dosage <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="dosage" name="dosage" required
                                           placeholder="e.g., 500mg"
                                           value="<?php echo htmlspecialchars($_POST['dosage'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="frequency" class="form-label">Frequency <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="frequency" name="frequency" required
                                           placeholder="e.g., Twice daily, Every 8 hours"
                                           value="<?php echo htmlspecialchars($_POST['frequency'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="route" class="form-label">Route</label>
                                    <select class="form-select" id="route" name="route">
                                        <option value="Oral" <?php echo ($_POST['route'] ?? '') === 'Oral' ? 'selected' : ''; ?>>Oral</option>
                                        <option value="Intravenous" <?php echo ($_POST['route'] ?? '') === 'Intravenous' ? 'selected' : ''; ?>>Intravenous (IV)</option>
                                        <option value="Intramuscular" <?php echo ($_POST['route'] ?? '') === 'Intramuscular' ? 'selected' : ''; ?>>Intramuscular (IM)</option>
                                        <option value="Subcutaneous" <?php echo ($_POST['route'] ?? '') === 'Subcutaneous' ? 'selected' : ''; ?>>Subcutaneous</option>
                                        <option value="Topical" <?php echo ($_POST['route'] ?? '') === 'Topical' ? 'selected' : ''; ?>>Topical</option>
                                        <option value="Inhalation" <?php echo ($_POST['route'] ?? '') === 'Inhalation' ? 'selected' : ''; ?>>Inhalation</option>
                                        <option value="Rectal" <?php echo ($_POST['route'] ?? '') === 'Rectal' ? 'selected' : ''; ?>>Rectal</option>
                                        <option value="Ophthalmic" <?php echo ($_POST['route'] ?? '') === 'Ophthalmic' ? 'selected' : ''; ?>>Ophthalmic (Eye)</option>
                                        <option value="Otic" <?php echo ($_POST['route'] ?? '') === 'Otic' ? 'selected' : ''; ?>>Otic (Ear)</option>
                                        <option value="Nasal" <?php echo ($_POST['route'] ?? '') === 'Nasal' ? 'selected' : ''; ?>>Nasal</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Schedule -->
                            <h5 class="mb-3"><i class="bi bi-calendar me-2"></i>Schedule</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required
                                           value="<?php echo htmlspecialchars($_POST['start_date'] ?? date('Y-m-d')); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date <small class="text-muted">(optional)</small></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>">
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Instructions -->
                            <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Additional Instructions</h5>

                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control" id="instructions" name="instructions" rows="3"
                                          placeholder="e.g., Take with food, Avoid alcohol, Take 30 minutes before meals"><?php echo htmlspecialchars($_POST['instructions'] ?? ''); ?></textarea>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="index.php?r=patients/info&id=<?php echo $patient['id']; ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Add Medication
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
