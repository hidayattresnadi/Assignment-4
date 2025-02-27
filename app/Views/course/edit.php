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
            <h4 class="mb-0">Edit Course</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('academics/courses/edit/' . $course->id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="<?= esc($course->name) ?>">
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">Course Code</label>
                    <input type="text" id="code" name="code" class="form-control" placeholder="Enter Course Code" value="<?= esc($course->code) ?>">
                </div>

                <div class="mb-3">
                    <label for="credits" class="form-label">Credits</label>
                    <input type="number" id="credits" name="credits" class="form-control" placeholder="Enter Credits" value="<?= esc($course->credits) ?>">
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" id="semester" name="semester" class="form-control" placeholder="Enter Semester" value="<?= esc($course->semester) ?>">
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Edit Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>