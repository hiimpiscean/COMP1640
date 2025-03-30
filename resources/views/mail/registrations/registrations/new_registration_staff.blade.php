<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Course Registration</title>
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
            <h2>New Course Registration Request</h2>
        </div>
        
        <p>Hello,</p>
        
        <p>A new student has requested to register for a course.</p>
        
        <p><strong>Details:</strong></p>
        <ul>
            <li><strong>Student:</strong> {{ $registration->student->name }} ({{ $registration->student->email }})</li>
            <li><strong>Course:</strong> {{ $registration->course->title }}</li>
            <li><strong>Teacher:</strong> {{ $registration->teacher->name }}</li>
            <li><strong>Registration Date:</strong> {{ $registration->created_at->format('F j, Y, g:i a') }}</li>
        </ul>
        
        <p>Please review and take appropriate action.</p>
        
        <p>
            <a href="{{ route('staff.registrations.show', $registration->id) }}" class="btn">Review Registration</a>
        </p>
        
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>&copy; {{ date('Y') }} Your Elearning Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>