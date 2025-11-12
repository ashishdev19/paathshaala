<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $courseTitle }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .welcome-message {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .course-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .course-details h3 {
            color: #495057;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #6c757d;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .tips-section {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .tips-section h4 {
            color: #856404;
            margin-top: 0;
        }
        .tips-list {
            margin: 0;
            padding-left: 20px;
        }
        .tips-list li {
            margin: 8px 0;
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px;
            }
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎉 Welcome to Paathshaala!</h1>
            <p>Your learning journey starts now</p>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                <h2>Hello {{ $studentName }}!</h2>
                <p>Congratulations! You have successfully enrolled in <strong>{{ $courseTitle }}</strong>. We're excited to have you join our learning community!</p>
            </div>
            
            <div class="course-details">
                <h3>📚 Course Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Course Title:</span>
                    <span class="detail-value">{{ $courseTitle }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Instructor:</span>
                    <span class="detail-value">{{ $teacherName }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">{{ $courseDuration }} hours</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Enrollment Date:</span>
                    <span class="detail-value">{{ $enrollmentDate }}</span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="{{ $courseUrl }}" class="btn btn-primary">🚀 Start Learning</a>
                <a href="{{ $dashboardUrl }}" class="btn btn-secondary">📊 View Dashboard</a>
            </div>
            
            <div class="tips-section">
                <h4>💡 Tips for Success</h4>
                <ul class="tips-list">
                    <li>Set aside dedicated time for learning each day</li>
                    <li>Take notes and practice what you learn</li>
                    <li>Participate actively in online classes</li>
                    <li>Don't hesitate to ask questions in the discussion forums</li>
                    <li>Complete assignments and assessments on time</li>
                </ul>
            </div>
            
            <p>If you have any questions or need support, our team is here to help. You can reach us at <a href="mailto:support@paathshaala.com">support@paathshaala.com</a> or through your student dashboard.</p>
            
            <p>We wish you all the best in your learning journey!</p>
            
            <p>Happy Learning!<br>
            <strong>The Paathshaala Team</strong></p>
        </div>
        
        <div class="footer">
            <p><strong>Paathshaala Learning Platform</strong></p>
            <p>Empowering minds through quality education</p>
            
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">LinkedIn</a>
                <a href="#">Instagram</a>
            </div>
            
            <p>© {{ date('Y') }} Paathshaala. All rights reserved.</p>
            <p>If you no longer wish to receive these emails, you can <a href="#">unsubscribe here</a>.</p>
        </div>
    </div>
</body>
</html>