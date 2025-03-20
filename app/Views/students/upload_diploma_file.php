<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php if (session()->has('errors')): ?>
    <ul class="text-danger">
        <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?= form_open_multipart('student/upload/diploma_file', ['id' => 'upload-form', 'class' => 'container mt-4']) ?>
<div class="card shadow-sm p-4">
    <h4 class="mb-3">Upload Diploma File</h4>

    <div class="form-group">
        <label for="userfile" class="form-label">Choose file (PDF - Max 5MB):</label>
        <input
            type="file"
            name="userfile"
            id="userfile"
            class="form-control"
            data-pristine-required-message="Please choose file to upload" />

        <div id="file-error" class="text-danger mt-2" style="display: none;">
        </div>
    </div>

    <div class="mt-3">
        <iframe
            id="file-preview"
            class="w-100 border rounded shadow-sm"
            height="500px"
            style="display: none;">
        </iframe>
    </div>

    <button type="submit" class="btn btn-primary mt-3 w-50 m-auto">Upload</button>
</div>
</form>
<?= $this->endSection() ?>



<?= $this->section('script') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("upload-form");

        var pristine = new Pristine(form, {
            classTo: 'mb-3',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-3',
            errorTextTag: 'div',
            errorTextClass: 'text-danger'
        });

        var fileInput = document.getElementById('userfile');
        var fileError = document.getElementById('file-error');
        var filePreview = document.getElementById('file-preview');

        var maxSize = 5 * 1024 * 1024;
        var allowedTypes = ['application/pdf'];
        var allowedExtensions = ['.pdf'];

        pristine.addValidator(fileInput, function(value) {
            filePreview.style.display = 'none';

            if (fileInput.files.length === 0) {
                fileError.textContent = "Please choose a file to upload";
                fileError.style.display = 'block';
                return false;
            }

            var file = fileInput.files[0];
            var validType = allowedTypes.includes(file.type);

            if (!validType) {
                var fileName = file.name.toLowerCase();
                validType = allowedExtensions.some(function(ext) {
                    return fileName.endsWith(ext);
                });
            }

            if (!validType) {
                fileError.textContent = "File should be only PDF";
                fileError.style.display = 'block';
                return false;
            }

            if (file.size > maxSize) {
                fileError.textContent = "File size should not be more than 5 MB";
                fileError.style.display = 'block';
                return false;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                filePreview.src = e.target.result;
                filePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);


            return true;
        }, "Validasi file gagal", 5, false);


        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });


        fileInput.addEventListener('change', function() {
            fileError.style.display = 'none';
            fileError.style.display = 'none';
            pristine.validate(fileInput);
        });
    });
</script>

<?= $this->endSection() ?>



<!-- 
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("upload-form");
        var errors = || {};
        var fileInput = document.getElementById('userfile');
        var fileTypeError = document.getElementById('file-type-error');
        var fileSizeError = document.getElementById('file-size-error');
        var filePreview = document.getElementById('file-preview');

        if (errors.max_size) {
            fileSizeError.style.display = 'block';
        }

        if (errors.mime_in) {
            fileTypeError.style.display = 'block';
        }

        fileInput.addEventListener('change', function() {
            fileTypeError.style.display = 'none';
            fileSizeError.style.display = 'none';
            errors = {};

            var file = fileInput.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.src = e.target.result;
                    filePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        form.addEventListener('submit', function(e) {
            if (Object.keys(errors).length > 0) {
                e.preventDefault();
            }
        });

    });
</script>

 -->