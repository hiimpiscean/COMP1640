<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Student Added to Your Course</title>
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
            background-color: #4285F4;
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
        <h1>New Student Added to Your Course</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ isset($registrationData->teacher->fullname_t) ? $registrationData->teacher->fullname_t : 'Teacher' }},</p>
        
        <p>A new student has been added to your course.</p>
        
        <div class="info">
            <p><span class="info-label">Course:</span> {{ $registrationData->course->name_p ?? 'N/A' }}</p>
            <p><span class="info-label">Student:</span> {{ $registrationData->student->fullname_c ?? 'N/A' }} ({{ $registrationData->student->email ?? 'No email' }})</p>
            <p><span class="info-label">Registration Date:</span> {{ date('F j, Y', strtotime($registrationData->created_at)) }}</p>
        </div>
        
        <p>Please prepare any necessary materials for the new student and update your class roster.</p>
        
        <p>If you have any questions or concerns, please contact the administration.</p>
        
        <a href="{{ route('timetable.index') }}" class="btn">View Class Schedule</a>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html> 