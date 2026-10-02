<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HomiQ - Verify Your Email</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td { font-family: Arial, Helvetica, sans-serif !important; }
    </style>
    <![endif]-->
    <style type="text/css">
        /* Client resets */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #F8FAFC; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }

        /* Mobile Responsive */
        @media screen and (max-width: 600px) {
            .wrapper { padding: 16px 8px !important; }
            .card-body { padding: 28px 20px !important; }
            .code-digits { font-size: 28px !important; letter-spacing: 8px !important; }
            .header-container { padding: 24px 20px !important; }
            .footer-container { padding: 24px 20px !important; }
        }
    </style>
</head>
<body style="background-color: #F8FAFC; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">
    <div class="wrapper" style="background-color: #F8FAFC; padding: 40px 12px; width: 100%; min-height: 100%;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 540px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.02);">
            
            <!-- Top Gradient Accent Bar -->
            <tr>
                <td style="height: 5px; background: linear-gradient(90deg, #0F172A 0%, #059669 50%, #0F172A 100%);"></td>
            </tr>

            <!-- Header with Official Logo -->
            <tr>
                <td class="header-container" align="center" style="padding: 32px 40px 24px 40px; border-bottom: 1px solid #F1F5F9; background-color: #FFFFFF;">
                    <a href="{{ url('/') }}" target="_blank" style="text-decoration: none; display: inline-block;">
                        <img src="{{ url('/logo.png') }}" alt="HomiQ" width="130" height="38" style="display: block; width: 130px; max-width: 140px; height: auto; margin: 0 auto; border: 0;" />
                    </a>
                    <div style="margin-top: 10px;">
                        <span style="display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #059669; background-color: #ECFDF5; border: 1px solid #A7F3D0; padding: 3px 10px; border-radius: 9999px;">
                            0% Brokerage &bull; Verified Spaces
                        </span>
                    </div>
                </td>
            </tr>

            <!-- Main Content Area -->
            <tr>
                <td class="card-body" style="padding: 36px 40px 32px 40px; text-align: center; background-color: #FFFFFF;">
                    
                    <!-- Icon Badge -->
                    <div style="margin: 0 auto 20px auto; width: 56px; height: 56px; background-color: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 50%; text-align: center; line-height: 56px;">
                        <span style="font-size: 26px; line-height: 56px;">🔐</span>
                    </div>

                    <h1 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 10px 0; letter-spacing: -0.3px; line-height: 1.3;">
                        Verify Your Email
                    </h1>
                    
                    <p style="font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 28px 0; font-weight: 400;">
                        Thank you for registering with <strong>HomiQ</strong>! Please use the 6-digit verification code below to verify your email address and activate your account.
                    </p>

                    <!-- Passcode Card Box -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0 auto 28px auto;">
                        <tr>
                            <td align="center">
                                <div style="display: inline-block; background-color: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 12px; padding: 18px 28px; text-align: center; box-shadow: inset 0 2px 4px rgba(0,0,0,0.03);">
                                    <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #64748B; margin-bottom: 6px;">
                                        Verification Code
                                    </div>
                                    <div class="code-digits" style="font-family: 'SF Mono', SFMono-Regular, Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 34px; font-weight: 800; color: #0F172A; letter-spacing: 10px; text-indent: 10px; line-height: 1.2;">
                                        {{ $code }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <!-- Security & Expiration Info Note Box -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 24px;">
                        <tr>
                            <td style="padding: 14px 18px; text-align: left;">
                                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #475569;">
                                    <strong style="color: #0F172A;">Note:</strong> This verification code is valid for the next <strong>15 minutes</strong>. If this code expires, you can request a new one from the app.
                                </p>
                            </td>
                        </tr>
                    </table>

                    <!-- Disclaimer -->
                    <p style="font-size: 12px; line-height: 1.5; color: #94A3B8; margin: 0;">
                        If you did not sign up for a HomiQ account, please disregard this email or contact our support team. Never share this code with anyone.
                    </p>

                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer-container" align="center" style="padding: 28px 40px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0; text-align: center;">
                    <p style="font-size: 12px; line-height: 1.6; color: #64748B; margin: 0 0 10px 0;">
                        This is an automated security email from HomiQ Space Rentals.<br>
                        Connecting verified owners and seekers with 0% brokerage.
                    </p>
                    
                    <div style="margin-bottom: 12px;">
                        <a href="{{ url('/') }}" style="font-size: 12px; font-weight: 600; color: #0F172A; text-decoration: none; margin: 0 8px;">Explore Homes</a>
                        <span style="color: #CBD5E1;">&bull;</span>
                        <a href="{{ url('/privacy') }}" style="font-size: 12px; font-weight: 600; color: #0F172A; text-decoration: none; margin: 0 8px;">Privacy Policy</a>
                        <span style="color: #CBD5E1;">&bull;</span>
                        <a href="{{ url('/terms') }}" style="font-size: 12px; font-weight: 600; color: #0F172A; text-decoration: none; margin: 0 8px;">Terms of Service</a>
                    </div>

                    <p style="font-size: 11px; color: #94A3B8; margin: 0;">
                        &copy; {{ date('Y') }} HomiQ Space Rentals Pvt. Ltd. All rights reserved.
                    </p>
                </td>
            </tr>

        </table>
    </div>
</body>
</html>
