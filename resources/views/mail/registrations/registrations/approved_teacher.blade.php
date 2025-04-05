<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Student Added to Your Course</title>
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
            <h2>New Student Added to Your Course</h2>
        </div>
        
        <p>Hello {{ $registration->teacher->name }},</p>
        
        <p>A new student has been approved and added to your course.</p>
        
        <p><strong>Details:</strong></p>
        <ul>
            <li><strong>Student:</strong> {{ $registration->student->name }} ({{ $registration->student->email }})</li>
            <li><strong>Course:</strong> {{ $registration->course->title }}</li>
            <li><strong>Approval Date:</strong> {{ now()->format('F j, Y, g:i a') }}</li>
        </ul>
        
        <p>You can view the updated class roster by clicking the button below:</p>
        
        <p>
            <a href="{{ route('teacher.courses.students', $registration->course_id) }}" class="btn">View Class Roster</a>
        </p>
        
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>&copy; {{ date('Y') }} Your Elearning Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>