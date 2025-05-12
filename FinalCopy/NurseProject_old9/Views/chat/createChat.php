<?php include_once "NurseProject/Views/chat/header.php"; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Start New Conversation</h3>
                    <a href="index.php?controller=chat&action=list" class="btn btn-sm btn-secondary mt-2">Back to Chats</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="index.php?controller=chat&action=startChat" method="post">
                        <?php if ($_SESSION['user_type'] === 'nurse'): ?>
                            <div class="mb-3">
                                <label for="clientId" class="form-label">Select Patient</label>
                                <select name="clientId" id="clientId" class="form-select" required>
                                    <option value="">-- Select Patient --</option>
                                    <?php foreach ($patients as $patient): ?>
                                        <option value="<?php echo $patient->patientID; ?>">
                                            <?php echo htmlspecialchars($patient->firstName . ' ' . $patient->lastName); ?> 
                                            - <?php echo htmlspecialchars($patient->problem ?? 'No problem specified'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <label for="nurseId" class="form-label">Select Nurse</label>
                                <select name="nurseId" id="nurseId" class="form-select" required>
                                    <option value="">-- Select Nurse --</option>
                                    <?php foreach ($nurses as $nurse): ?>
                                        <option value="<?php echo $nurse->NurseID; ?>">
                                            <?php echo htmlspecialchars($nurse->firstName . ' ' . $nurse->lastName); ?> 
                                            - <?php echo htmlspecialchars($nurse->specialitiesGoodAt ?? 'General Care'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="serviceCode" class="form-label">Service Code (Optional)</label>
                            <input type="text" name="serviceCode" id="serviceCode" class="form-control" 
                                   placeholder="Enter service code if applicable">
                            <div class="form-text">If you have a specific service code for this consultation, enter it here.</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Start Conversation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "NurseProject/Views/chat/footer.php"; ?>