<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-center">Student Profile</h4>
        </div>
        <div class="card-body">
            <!-- Personal Information -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Student ID:</strong> {student_id}</p>
                    <p><strong>Name:</strong> {name}</p>
                    <p><strong>Entry Year:</strong> {entry_year}</p>
                </div>
            </div>

            <!-- Academic Status -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Academic Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Program Study:</strong> {study_program}</p>
                    <p><strong>Current Semester:</strong> {current_semester}</p>
                    <p><strong>GPA:</strong> {gpa}</p>
                    {!status_cell!}
                </div>
            </div>
        </div>
    </div>
</div>