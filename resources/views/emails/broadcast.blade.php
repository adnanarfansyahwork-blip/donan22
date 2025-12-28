<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .email-body {
            padding: 30px;
        }
        .email-content {
            margin-bottom: 30px;
        }
        .email-content p {
            margin: 0 0 15px 0;
        }
        .email-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .email-content a {
            color: #4f46e5;
            text-decoration: none;
        }
        .email-content a:hover {
            text-decoration: underline;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #4338ca;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer a {
            color: #4f46e5;
            text-decoration: none;
        }
        .unsubscribe {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        
        <div class="email-body">
            <div class="email-content">
                {!! nl2br(e($content)) !!}
            </div>
            
            <p style="color: #6b7280; font-size: 14px;">
                Thank you for being a subscriber!
            </p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>
                <a href="{{ config('app.url') }}">Visit our website</a>
            </p>
            <div class="unsubscribe">
                <p>Don't want to receive these emails?</p>
                <p><a href="{{ $unsubscribeUrl }}">Unsubscribe here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
