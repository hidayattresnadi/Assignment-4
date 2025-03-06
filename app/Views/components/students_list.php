<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>{student_id_th|noescape}</th>
                <th>Student Name</th>
                <th>Study Program</th>
                <th>Entry Year</th>
                <th>Academic Status</th>
                <th>{current_semester_th|noescape}</th>
                <th>GPA</th>
                <th>Detail</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            {students}
            <tr>
                <td>{student_id}</td>
                <td>{name}</td>
                <td>{study_program}</td>
                <td>{entry_year}</td>
                <td>{academic_status}</td>
                <td>{current_semester}</td>
                <td>{gpa}</td>
                <td>
                    <a href="students/{id}" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </a>
                </td>
                <td>
                    {EditStudentButton|noescape}
                </td>
                <td>
                    {DeleteStudentButton|noescape}
                </td>
            </tr>
            {/students}
        </tbody>
    </table>
</div>