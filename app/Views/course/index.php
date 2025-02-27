<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Academic Statistics</h2>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-primary"><?php echo $academicStatistics["university"]; ?></h4>
            <p class="card-text"><strong>Academic Year:</strong> <?php echo $academicStatistics["academicYear"]; ?></p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text fs-3"><?php echo $academicStatistics["totalStudents"]; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Faculties</h5>
                    <p class="card-text fs-3"><?php echo $academicStatistics["totalFaculties"]; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Departments</h5>
                    <p class="card-text fs-3"><?php echo $academicStatistics["totalDepartments"]; ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-4">Student Statistics</h4>
    <table class="table table-bordered table-striped mt-2">
        <thead class="table-dark">
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($academicStatistics["studentStatistics"] as $status => $count) : ?>
                <tr>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $count; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>