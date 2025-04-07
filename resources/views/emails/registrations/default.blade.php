<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Registration Update</title>
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
            background-color: #FBBC05;
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
        <h1>Course Registration Update</h1>
    </div>
    
    <div class="content">
        <p>Hello,</p>
        
        <p>There has been an update regarding a course registration.</p>
        
        <div class="info">
            <p><span class="info-label">Registration ID:</span> {{ $registrationData->id }}</p>
            @if(isset($registrationData->student))
            <p><span class="info-label">Student:</span> {{ $registrationData->student->fullname_c ?? 'N/A' }}</p>
            @endif
            @if(isset($registrationData->course))
            <p><span class="info-label">Course:</span> {{ $registrationData->course->name_p ?? 'N/A' }}</p>
            @endif
            @if(isset($registrationData->status))
            <p><span class="info-label">Status:</span> {{ ucfirst($registrationData->status) }}</p>
            @endif
            @if(isset($registrationData->created_at))
            <p><span class="info-label">Date:</span> {{ date('F j, Y', strtotime($registrationData->created_at)) }}</p>
            @endif
        </div>
        
        <p>Please log in to the system for more details.</p>
        
        <a href="{{ url('/') }}" class="btn">Go to Website</a>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html> 