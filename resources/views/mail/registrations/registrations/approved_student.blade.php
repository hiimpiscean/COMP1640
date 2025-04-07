<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Registration Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Course Registration Approved</h2>
        </div>
        
        <p>Hello {{ $registration->student->name }},</p>
        
        <p>Great news! Your registration for the following course has been approved:</p>
        
        <p><strong>Course Details:</strong></p>
        <ul>
            <li><strong>Course:</strong> {{ $registration->course->title }}</li>
            <li><strong>Teacher:</strong> {{ $registration->teacher->name }}</li>
            <li><strong>Start Date:</strong> {{ $registration->course->start_date ?? 'Available now' }}</li>
        </ul>
        
        <p>You can now access all course materials and participate in class activities.</p>
        
        <p>
            <a href="{{ route('student.courses.show', $registration->course_id) }}" class="btn">Go to Course</a>
        </p>
        
        <p>If you have any questions, please contact your teacher or our support team.</p>
        
        <p>Happy learning!</p>
        
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>&copy; {{ date('Y') }} Your Elearning Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>