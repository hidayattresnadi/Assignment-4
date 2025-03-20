<!DOCTYPE html>
<html>

<head>
    <title>Course Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Hello, <?= $name ?>!</h2>
        <p>Congratulations! You have successfully registered for the course:</p>

        <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td><strong>Student Id:</strong></td>
                <td><?= $student_university_id ?></td>
            </tr>
            <tr>
                <td><strong>Course Name:</strong></td>
                <td><?= $course_name ?></td>
            </tr>
            <tr>
                <td><strong>Course Code:</strong></td>
                <td><?= $course_code ?></td>
            </tr>
            <tr>
                <td><strong>Credits:</strong></td>
                <td><?= $course_credits ?> </td>
            </tr>
            <tr>
                <td><strong>Registration Date:</strong></td>
                <td><?= $registration_date ?> </td>
            </tr>
            <tr>
                <td><strong>Registration Time:</strong></td>
                <td><?= $registration_time ?> </td>
            </tr>
        </table>

        <p>Thank you for registering! If you have any questions, feel free to contact us.</p>

        <div class="footer">
            <p>Best Regards, <br> Rain University </p>
        </div>
    </div>
</body>

</html>