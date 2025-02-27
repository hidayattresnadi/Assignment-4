<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php if (isset($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li style="color: red;"><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Student</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('/students') ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name">
                </div>

                <div class="mb-3">
                    <label for="studentId" class="form-label">Student Id</label>
                    <input type="text" id="studentId" name="studentId" class="form-control" placeholder="Enter Student Id">
                </div>

                <div class="mb-3">
                    <label for="programStudy" class="form-label">Program Study</label>
                    <input type="text" id="programStudy" name="programStudy" class="form-control" placeholder="Enter Program Study">
                </div>

                <div class="mb-3">
                    <label for="currentSemester" class="form-label">Current Semester</label>
                    <input type="number" id="currentSemester" name="currentSemester" class="form-control" placeholder="Enter Current Semester">
                </div>

                <div class="mb-3">
                    <label for="entryYear" class="form-label">Entry Year</label>
                    <input type="number" id="entryYear" name="entryYear" class="form-control" placeholder="Enter Entry Year">
                </div>

                <div class="mb-3">
                    <label for="gpa" class="form-label">GPA</label>
                    <input type="number" id="gpa" name="gpa" class="form-control" placeholder="Enter GPA" step="0.01">
                </div>

                <div class="mb-3">
                    <label for="academicStatus" class="form-label">Academic Status</label>
                    <select id="academicStatus" name="academicStatus" class="form-select">
                        <option value="">-- Select Academic Status --</option>
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Graduated">Graduated</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Add Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>