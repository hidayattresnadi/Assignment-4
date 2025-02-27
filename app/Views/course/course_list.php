<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="mb-4 mt-4">Course List</h1>
<a href="<?= site_url('academics/courses/new') ?>" class="btn btn-success mb-3">Add Course</a>

<?= $content ?? '' ?>

<?= $this->endSection() ?>