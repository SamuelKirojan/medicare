<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-1">Edit Patient</h2>
                    <p class="text-muted mb-0">Update patient information for <?php echo htmlspecialchars($patient['name']); ?></p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="index.php?r=patients/update&id=<?php echo $patient['id']; ?>" method="POST">
                            <!-- Basic Information -->
                            <h5 class="mb-3"><i class="bi bi-person me-2"></i>Basic Information</h5>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                           value="<?php echo htmlspecialchars($patient['name']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="age" name="age" min="0" max="150" required
                                           value="<?php echo $patient['age']; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="Male" <?php echo $patient['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo $patient['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                                        <option value="Other" <?php echo $patient['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                           value="<?php echo htmlspecialchars($patient['phone'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <select class="form-select" id="blood_type" name="blood_type">
                                        <option value="">-- Select --</option>
                                        <option value="A+" <?php echo ($patient['blood_type'] ?? '') === 'A+' ? 'selected' : ''; ?>>A+</option>
                                        <option value="A-" <?php echo ($patient['blood_type'] ?? '') === 'A-' ? 'selected' : ''; ?>>A-</option>
                                        <option value="B+" <?php echo ($patient['blood_type'] ?? '') === 'B+' ? 'selected' : ''; ?>>B+</option>
                                        <option value="B-" <?php echo ($patient['blood_type'] ?? '') === 'B-' ? 'selected' : ''; ?>>B-</option>
                                        <option value="AB+" <?php echo ($patient['blood_type'] ?? '') === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                                        <option value="AB-" <?php echo ($patient['blood_type'] ?? '') === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                                        <option value="O+" <?php echo ($patient['blood_type'] ?? '') === 'O+' ? 'selected' : ''; ?>>O+</option>
                                        <option value="O-" <?php echo ($patient['blood_type'] ?? '') === 'O-' ? 'selected' : ''; ?>>O-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"><?php echo htmlspecialchars($patient['address'] ?? ''); ?></textarea>
                            </div>

                            <hr class="my-4">

                            <!-- Medical Information -->
                            <h5 class="mb-3"><i class="bi bi-heart-pulse me-2"></i>Medical Information</h5>

                            <div class="mb-3">
                                <label for="allergies" class="form-label">Allergies</label>
                                <textarea class="form-control" id="allergies" name="allergies" rows="2" 
                                          placeholder="List all known allergies (e.g., Penicillin, Sulfa drugs)"><?php echo htmlspecialchars($patient['allergies'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Medical Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"
                                          placeholder="Any additional medical information"><?php echo htmlspecialchars($patient['notes'] ?? ''); ?></textarea>
                            </div>

                            <hr class="my-4">

                            <!-- Emergency Contact -->
                            <h5 class="mb-3"><i class="bi bi-telephone me-2"></i>Emergency Contact</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="emergency_contact" class="form-label">Contact Name</label>
                                    <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"
                                           value="<?php echo htmlspecialchars($patient['emergency_contact'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="emergency_phone" class="form-label">Contact Phone</label>
                                    <input type="tel" class="form-control" id="emergency_phone" name="emergency_phone"
                                           value="<?php echo htmlspecialchars($patient['emergency_phone'] ?? ''); ?>">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="index.php?r=patients/info&id=<?php echo $patient['id']; ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Update Patient
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
