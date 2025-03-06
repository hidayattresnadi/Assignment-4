<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4 p-0">
    <h1 class="mb-4">Student List</h1>
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

            <!-- Filter by Academic Status -->
            <div class="col-md-2 ms-md-5">
                <label class="form-label mb-1">Filter by Academic Status</label>
                <select name="academic_status" class="form-control" onchange="this.form.submit()">
                    <option value="">All Academic Statuses</option>
                    <?php foreach ($academic_statuses as $status): ?>
                        <option value="<?= $status ?>" <?= ($params->academic_status == $status) ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Select Entry Year -->

            <div class="col-md-2">
                <label class="form-label mb-1">Select Entry Year</label>
                <select name="entry_year" class="form-control" onchange="this.form.submit()">
                    <option value="">All Entry Year</option>
                    <?php foreach ($entry_years as $year): ?>
                        <option value="<?= $year ?>" <?= ($params->entry_year == $year) ? 'selected' : '' ?>><?= ucfirst($year) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Select Study Program -->

            <div class="col-md-2">
                <label class="form-label mb-1">Select Study Program</label>
                <select name="study_program" class="form-control" onchange="this.form.submit()">
                    <option value="">All Study Program</option>
                    <?php foreach ($study_programs as $program): ?>
                        <option value="<?= $program ?>" <?= ($params->study_program == $program) ? 'selected' : '' ?>><?= ucfirst($program) ?></option>
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


<a href=<?= base_url('/students') ?> class="btn btn-success mb-3">Add Student</a>
<?= $content ?? '' ?>
<?= $pager->links('students', 'custom_pager') ?>


<?= $this->endSection() ?>