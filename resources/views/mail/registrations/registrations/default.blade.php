<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Registration Update</title>
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
            <h2>Course Registration Update</h2>
        </div>
        
        <p>Hello,</p>
        
        <p>There has been an update to a course registration in the system.</p>
        
        <p><strong>Registration Details:</strong></p>
        <ul>
            <li><strong>Student:</strong> {{ $registration->student->name }}</li>
            <li><strong>Course:</strong> {{ $registration->course->title }}</li>
            <li><strong>Status:</strong> {{ ucfirst($registration->status) }}</li>
            <li><strong>Date:</strong> {{ now()->format('F j, Y, g:i a') }}</li>
        </ul>
        
        <p>Please log into the system for more details.</p>
        
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>&copy; {{ date('Y') }} Your Elearning Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>