<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Course Registration</h4>
        </div>
        <div class="card-body">
            <form id="formData" method="post" action="<?= site_url('student/course_registration') ?>">
                <div class="mb-3">
                    <label for="course_id" class="form-label">Select Course</label>
                    <select id="course_id" name="course_id" class="form-select" required>
                        <option value="" disabled selected>-- Select Course --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course->id ?>"><?= ucfirst($course->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Course Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>