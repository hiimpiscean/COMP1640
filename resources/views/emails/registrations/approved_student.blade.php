<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Course Registration Has Been Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #34A853;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info-label {
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: #34A853;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Course Registration Approved</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $registrationData->student->fullname_c ?? 'Student' }},</p>
        
        <p>Congratulations! Your registration for the following course has been <strong>approved</strong>.</p>
        
        <div class="info">
            <p><span class="info-label">Course:</span> {{ $registrationData->course->name_p ?? 'N/A' }}</p>
            <p><span class="info-label">Teacher:</span> {{ isset($registrationData->teacher->fullname_t) ? $registrationData->teacher->fullname_t : 'N/A' }}</p>
            <p><span class="info-label">Status:</span> Approved</p>
            <p><span class="info-label">Registration Date:</span> {{ date('F j, Y', strtotime($registrationData->created_at)) }}</p>
        </div>
        
        <p>You can now access all course materials and attend scheduled classes. Please check the course schedule for upcoming sessions.</p>
        
        <p>If you have any questions, please contact your teacher or our support team.</p>
        
        <a href="{{ route('learning_materials.curriculum') }}" class="btn">Go to My Courses</a>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html> 