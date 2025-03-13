<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Course Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Code:</strong> <?= esc($code) ?></p>
            <p><strong>Name:</strong> <?= esc($name) ?></p>
            <p><strong>Credits:</strong> <?= esc($credits) ?></p>
            <p><strong>Semester:</strong> <?= esc($semester) ?></p>
        </div>
        <div class="card-footer">
            <a href="<?= site_url('lecturer/academics/courses') ?>" class="btn btn-secondary">Back</a>
            <a href="<?= site_url('lecturer/academics/courses/edit/' . $id) ?>" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>