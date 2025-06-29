<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333333;
            line-height: 1.7;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            padding: 0;
            height: 170px;
            position: relative;
            overflow: hidden;
        }

        .logo2{
            max-width: 100%;
            position: absolute;
            top: -55px;
            left: 0;
        }

        .content {
            padding: 30px 40px 40px;
            text-align: center;
            margin-top: -25px;
            margin-bottom: -35px;
            background-color: #fff;
        }


        h1 {
            font-size: 28px;
            margin-bottom: 25px;
            color: #1d58c6;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: #f98100;
            border-radius: 3px;
        }

        p {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555555;
        }

        .footer-text {
            margin-bottom: 20px;
            font-size: 16px;
            color: #fff;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(to right, #f98100, #ff9f30);
            color: #ffffff;
            padding: 14px 36px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin: 30px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(249, 129, 0, 0.3);
            letter-spacing: 0.5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(249, 129, 0, 0.4);
        }

        .token-container {
            margin: 25px 0;
            padding: 5px;
            border-radius: 8px;
            background: linear-gradient(to right, #e8e8e8, #f5f5f5);
        }

        .token {
            background-color: #f2f2f2;
            color: #333333;
            padding: 16px;
            border-radius: 6px;
            margin: 0;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            word-break: break-all;
            border: 1px dashed #cccccc;
            letter-spacing: 1px;
        }

        .footer {
            background: linear-gradient(to right, #1d58c6, #3a7be9);
            text-align: center;
            padding: 30px 20px;
            color: #ffffff;
            font-size: 14px;
            position: relative;
        }

        .logo3{
            max-width: 100%;
            position: absolute;
            top: -30px;
            left: 0;
        }

        .social-icons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px);
        }

        .divider {
            height: 4px;
            background: linear-gradient(to right, #f98100, #ff9f30);
            margin: 0;
        }

        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .highlight {
            font-weight: 500;
            color: #000;
        }

        .note {
            font-size: 14px;
            color: #777777;
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://i.postimg.cc/66ZNyDNW/Email-header-2.png" alt="ClarkNav Logo" class="logo2">
        </div>
        <div class="logo-container">
            <!-- <img src="https://i.postimg.cc/YqCjktvs/bg-nav-900.png" alt="ClarkNav Logo" class="logo"> -->
        </div>
        <div class="content">
            <h1>Verify Your Email Address</h1>
            <p>Thank you for signing up with ClarkNav. To complete your registration, please verify your email address.</p>
            <p>Click the button below to verify your email. This link will expire in 24 hours.</p>
            <a href="{{ url('/api/auth/verify-email/' . $token) }}" class="btn">Verify Email</a>
            <p>If you did not create an account with ClarkNav, please ignore this email or contact our support team.</p>
            <p>If the button above doesn't work, you can copy and paste the following verification code:</p>
            <div class="token-container">
                <div class="token">{{ $token }}</div>
            </div>
            <p class="note">For security reasons, this verification link will expire after 24 hours.</p>
        </div>
        <div class="divider"></div>
        <div class="footer">
            <p class="footer-text">&copy; 2025 ClarkNav. All rights reserved.</p>
            <div class="contact-info">
                <p class="footer-text">Need help? Contact our support team at <span class="highlight">support@clarknav.com</span></p>
            </div>
        </div>
    </div>
</body>

</html>