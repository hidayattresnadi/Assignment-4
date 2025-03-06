<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4 p-0">
    <h1 class="mb-4">Course List</h1>
    <form action="<?= $baseUrl ?>" method="get" class="form-inline">
        <div class="row g-3 mb-4">
            <!-- Search Input -->
            <div class="col-md-5">
                <label class="form-label mb-1">Search Course</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="<?= $params->search ?>" placeholder="Search here...">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </div>

            <!-- Filter by Credits -->
            <div class="col-md-2 ms-md-5">
                <label class="form-label mb-1">Filter by Credits</label>
                <select name="credits" class="form-control" onchange="this.form.submit()">
                    <option value="">All Credits</option>
                    <?php foreach ($credits as $credit): ?>
                        <option value="<?= $credit ?>" <?= ($params->credits == $credit) ? 'selected' : '' ?>><?= ucfirst($credit) ?> Credits</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Select Semester -->
            <div class="col-md-2">
                <label class="form-label mb-1">Select Semester</label>
                <select name="semester" class="form-control" onchange="this.form.submit()">
                    <option value="">All Semesters</option>
                    <?php foreach ($semesters as $semester): ?>
                        <option value="<?= $semester ?>" <?= ($params->semester == $semester) ? 'selected' : '' ?>>Semester <?= ucfirst($semester) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Results per Page -->
            <div class="col-md-2">
                <label class="form-label mb-1">Results per Page</label>
                <select name="perPage" class="form-control" onchange="this.form.submit()">
                    <option value="2" <?= ($params->perPage == 2) ? 'selected' : '' ?>>2 results per page</option>
                    <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>10 results per page</option>
                    <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>25 results per page</option>
                    <option value="50" <?= ($params->perPage == 50) ? 'selected' : '' ?>>50 results per page</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="sort" value="<?= $params->sort; ?>">
        <input type="hidden" name="order" value="<?= $params->order; ?>">
    </form>
</div>


<a href="<?= site_url('academics/courses/new') ?>" class="btn btn-success mb-3">Add Course</a>
<?= $content ?? '' ?>
<?= $pager->links('courses', 'custom_pager') ?>
<?= $this->endSection() ?>