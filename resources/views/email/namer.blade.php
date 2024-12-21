<!DOCTYPE html>
<html>
<head>
    <title>Email Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4caf50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
        }
        .email-body h1 {
            color: #4caf50;
            font-size: 24px;
            margin-top: 0;
        }
        .email-body p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .email-footer {
            background-color: #f1f1f1;
            color: #666;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .email-footer a {
            color: #4caf50;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
        <!-- Header -->
        <div class="email-header">
            <h1>plus vite il y a une place !</h1>
        </div>
        <div class="email-body">
            <h1>Hello, {{ $data['name'] }}</h1>
            <p>{{ $data['message'] }}</p>
            <p>We are excited to assist you with your plans. If you have any questions, feel free to reach out to us at any time.</p>
        </div>
    <div class="email-footer">
        <p>From, Your App Team</p>
    </div>
</body>
</html>