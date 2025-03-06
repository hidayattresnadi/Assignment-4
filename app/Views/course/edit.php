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
            <h4 class="mb-0">Edit Course</h4>
        </div>
        <div class="card-body">
            <form id="formData" method="post" action="<?= site_url('academics/courses/edit/' . $course->id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="<?= esc($course->name) ?>"
                        data-pristine-required
                        data-pristine-required-message="Name required"
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="Name minimal 3 characters">
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">Course Code</label>
                    <input type="text" id="code" name="code" class="form-control" placeholder="Enter Course Code" value="<?= esc($course->code) ?>"
                        data-pristine-required
                        data-pristine-required-message="Code required">
                </div>

                <div class="mb-3">
                    <label for="credits" class="form-label">Credits</label>
                    <input type="number" id="credits" name="credits" class="form-control" placeholder="Enter Credits" value="<?= esc($course->credits) ?>"
                        data-pristine-required
                        data-pristine-required-message="Credits required">
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" id="semester" name="semester" class="form-control" placeholder="Enter Semester" value="<?= esc($course->semester) ?>"
                        data-pristine-required
                        data-pristine-required-message="Semester required">
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

        var nameValidation = document.getElementById("code");

        pristine.addValidator(nameValidation, function(value) {
            // here `this` refers to the respective input element
            if (value.length === 5) {
                return true;
            }
            return false;
        }, "The code minimal 8 characters", 2, false);


        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

    };
</script>
<?= $this->endSection() ?>