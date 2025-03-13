<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
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
            <form id="formData" method="post" action="<?= site_url('admin/students/store') ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name"
                        data-pristine-required
                        data-pristine-required-message="Name required"
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="Name minimal 3 characters">
                </div>

                <div class="mb-3">
                    <label for="studentId" class="form-label">Student Id</label>
                    <input type="text" id="studentId" name="studentId" class="form-control" placeholder="Enter Student Id"
                        data-pristine-required
                        data-pristine-required-message="Student Id required">
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Username</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="" disabled selected>-- Select Username --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user->id ?>"><?= ucfirst($user->username) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="programStudy" class="form-label">Program Study</label>
                    <input type="text" id="programStudy" name="programStudy" class="form-control" placeholder="Enter Program Study"
                        data-pristine-required
                        data-pristine-required-message="Program Study required"
                        data-pristine-minlength="4"
                        data-pristine-minlength-message="Program study minimal 3 characters">
                </div>

                <div class="mb-3">
                    <label for="currentSemester" class="form-label">Current Semester</label>
                    <input type="number" id="currentSemester" name="currentSemester" class="form-control" placeholder="Enter Current Semester"
                        data-pristine-required
                        data-pristine-required-message="Semester required"
                        data-pristine-min="1"
                        data-pristine-min-message="Minimal Semester should be 1"
                        data-pristine-max="14"
                        data-pristine-min-message="Maximal Semester should be 14">
                </div>

                <div class="mb-3">
                    <label for="entryYear" class="form-label">Entry Year</label>
                    <input type="number" id="entryYear" name="entryYear" class="form-control" placeholder="Enter Entry Year"
                        data-pristine-required
                        data-pristine-required-message="Entry year required">
                </div>

                <div class="mb-3">
                    <label for="gpa" class="form-label">GPA</label>
                    <input type="number" id="gpa" name="gpa" class="form-control" placeholder="Enter GPA" step="0.01"
                        data-pristine-required
                        data-pristine-required-message="GPA required"
                        data-pristine-min="1"
                        data-pristine-min-message="Minimal GPA should be 1"
                        data-pristine-max="4"
                        data-pristine-min-message="Maximal Semester should be 4">
                </div>

                <div class="mb-3">
                    <label for="academicStatus" class="form-label">Academic Status</label>
                    <select id="academicStatus" name="academicStatus" class="form-select"
                        data-pristine-required
                        data-pristine-required-message="Please select academic status">
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


<?= $this->section('script') ?>
<script>
    let pristine;
    window.onload = function() {
        let form = document.getElementById("formData");

        var pristine = new Pristine(form, {
            classTo: 'mb-3',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-3',
            errorTextTag: 'div',
            errorTextClass: 'text-danger'
        });

        var nameValidation = document.getElementById("studentId");

        pristine.addValidator(nameValidation, function(value) {
            // here `this` refers to the respective input element
            if (value.length === 5) {
                return true;
            }
            return false;
        }, "The student id minimal 5 characters", 2, false);


        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

    };
</script>
<?= $this->endSection() ?>