<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Email Verification</title>
    <style>
        /* Email client resets */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }

        /* General styles */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #F8FAFC; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }

        /* Custom Styles */
        .wrapper { width: 100%; table-layout: fixed; background-color: #F8FAFC; padding: 40px 0; }
        .container { max-width: 540px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02); }
        .top-bar { height: 6px; background: linear-gradient(90deg, #5C33CF 0%, #8A5CF5 100%); }
        .header { padding: 32px 40px 24px 40px; border-bottom: 1px solid #F1F5F9; text-align: center; }
        .logo { font-size: 26px; font-weight: 800; color: #5C33CF; text-decoration: none; letter-spacing: -0.5px; }
        .content { padding: 40px; text-align: center; }
        .title { font-size: 22px; font-weight: 700; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.25px; }
        .text { font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 32px 0; }
        
        /* Code Display Box */
        .code-box { background-color: #F8FAFC; border: 2px dashed #5C33CF; border-radius: 12px; padding: 18px; margin: 0 auto 32px auto; max-width: 280px; text-align: center; }
        .code-text { font-family: 'Courier New', Courier, monospace; font-size: 32px; font-weight: 800; color: #5C33CF; letter-spacing: 6px; margin: 0; }
        
        /* Note Box */
        .info-box { background-color: #F1F5F9; border-radius: 8px; padding: 16px; margin-bottom: 24px; text-align: left; }
        .info-text { font-size: 13px; line-height: 1.5; color: #475569; margin: 0; }

        /* Footer */
        .footer { padding: 32px 40px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0; text-align: center; }
        .footer-text { font-size: 12px; line-height: 1.5; color: #64748B; margin: 0 0 8px 0; }
        .footer-links { font-size: 12px; font-weight: 600; color: #5C33CF; text-decoration: none; margin: 0 8px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="top-bar"></div>
            <div class="header">
                <a href="#" class="logo">HomiQ</a>
            </div>
            <div class="content">
                <h1 class="title">Verify Your Email</h1>
                <p class="text">Thank you for registering with HomiQ! Please use the 6-digit verification code below to verify your email address and activate your account.</p>
                
                <div class="code-box">
                    <p class="code-text">{{ $code }}</p>
                </div>

                <div class="info-box">
                    <p class="info-text">💡 <strong>Note:</strong> This verification code is valid for the next <strong>15 minutes</strong>. If this code expires, you can request a new one from the app.</p>
                </div>

                <p class="text" style="font-size: 13px; color: #94A3B8; margin-top: 32px;">If you did not sign up for a HomiQ account, please disregard this email or contact our support team.</p>
            </div>
            <div class="footer">
                <p class="footer-text">This is an automated security email from HomiQ. Please do not reply directly to this message.</p>
                <p class="footer-text" style="font-weight: 600;">&copy; {{ date('Y') }} HomiQ Inc. All rights reserved.</p>
                <div style="margin-top: 16px;">
                    <a href="{{ url('/privacy') }}" class="footer-links">Privacy Policy</a>
                    <span style="color: #CBD5E1;">&bull;</span>
                    <a href="{{ url('/terms') }}" class="footer-links">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
