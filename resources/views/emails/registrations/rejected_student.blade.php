<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Course Registration Status Update</title>
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
            background-color: #EA4335;
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
            background-color: #4285F4;
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
        <h1>Course Registration Status Update</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $registrationData->student->fullname_c ?? 'Student' }},</p>
        
        <p>We regret to inform you that your registration for the following course has been <strong>declined</strong>.</p>
        
        <div class="info">
            <p><span class="info-label">Course:</span> {{ $registrationData->course->name_p ?? 'N/A' }}</p>
            <p><span class="info-label">Status:</span> Rejected</p>
            <p><span class="info-label">Registration Date:</span> {{ date('F j, Y', strtotime($registrationData->created_at)) }}</p>
        </div>
        
        <p>This may be due to one of the following reasons:</p>
        <ul>
            <li>The course has reached its maximum capacity</li>
            <li>Prerequisite requirements have not been met</li>
            <li>Scheduling conflicts</li>
            <li>Administrative reasons</li>
        </ul>
        
        <p>For more information or to explore alternative courses, please contact our support team.</p>
        
        <a href="{{ route('learning_materials.curriculum') }}" class="btn">Explore Other Courses</a>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html> 