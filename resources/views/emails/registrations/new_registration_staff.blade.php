
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Course Registration Request</title>
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
            background-color: #1a73e8;
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
            background-color: #1a73e8;
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
        <h1>New Course Registration Request</h1>
    </div>
    
    <div class="content">
        <p>Hello Staff,</p>
        
        <p>A new registration request has been received and requires your review.</p>
        
        <div class="info">
            <p><span class="info-label">Registration ID:</span> {{ $registrationData->id }}</p>
            <p><span class="info-label">Student:</span> {{ $registrationData->student->fullname_c ?? 'N/A' }} ({{ $registrationData->student->email ?? 'No email' }})</p>
            <p><span class="info-label">Course:</span> {{ $registrationData->course->name_p ?? 'N/A' }}</p>
            <p><span class="info-label">Teacher:</span> {{ isset($registrationData->teacher->fullname_t) ? $registrationData->teacher->fullname_t : 'N/A' }}</p>
            <p><span class="info-label">Status:</span> Pending</p>
            <p><span class="info-label">Submitted on:</span> {{ date('F j, Y, g:i a', strtotime($registrationData->created_at)) }}</p>
        </div>
        
        <p>Please review this registration and take appropriate action.</p>
        
        <a href="{{ route('staff.registrations') }}" class="btn">Review Registration</a>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html> 
