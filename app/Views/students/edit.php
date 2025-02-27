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
            <h4 class="mb-0">Edit Student</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('students/' . $student->id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="<?= esc($student->name) ?>">
                </div>

                <div class="mb-3">
                    <label for="studentId" class="form-label">Student Id</label>
                    <input type="text" id="studentId" name="studentId" class="form-control" placeholder="Enter Student Id" value="<?= esc($student->student_id) ?>">
                </div>

                <div class="mb-3">
                    <label for="programStudy" class="form-label">Program Study</label>
                    <input type="text" id="programStudy" name="programStudy" class="form-control" placeholder="Enter Program Study" value="<?= esc($student->study_program) ?>">
                </div>

                <div class="mb-3">
                    <label for="currentSemester" class="form-label">Current Semester</label>
                    <input type="number" id="currentSemester" name="currentSemester" class="form-control" placeholder="Enter Current Semester" value="<?= esc($student->current_semester) ?>">
                </div>

                <div class="mb-3">
                    <label for="entryYear" class="form-label">Entry Year</label>
                    <input type="number" id="entryYear" name="entryYear" class="form-control" placeholder="Enter Entry Year" value="<?= esc($student->entry_year) ?>">
                </div>

                <div class="mb-3">
                    <label for="gpa" class="form-label">GPA</label>
                    <input type="number" id="gpa" name="gpa" class="form-control" placeholder="Enter GPA" step="0.01" value="<?= esc($student->gpa) ?>">
                </div>

                <div class="mb-3">
                    <label for="academicStatus" class="form-label">Academic Status</label>
                    <select id="academicStatus" name="academicStatus" class="form-select">
                        <option value="">-- Select Academic Status --</option>
                        <option value="Active" <?= ($student->academic_status == "Active") ? 'selected' : '' ?>>Active</option>
                        <option value="On Leave" <?= ($student->academic_status == "On Leave") ? 'selected' : '' ?>>On Leave</option>
                        <option value="Graduated" <?= ($student->academic_status == "Graduated") ? 'selected' : '' ?>>Graduated</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Edit Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>