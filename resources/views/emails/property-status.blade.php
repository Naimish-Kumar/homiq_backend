<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HomiQ - Property Listing Status Update</title>
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
            .header-container { padding: 24px 20px !important; }
            .footer-container { padding: 24px 20px !important; }
        }
    </style>
</head>
<body style="background-color: #F8FAFC; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">
    <div class="wrapper" style="background-color: #F8FAFC; padding: 40px 12px; width: 100%; min-height: 100%;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.02);">
            
            <!-- Top Accent Bar -->
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
                            Owner &amp; Listing Verification
                        </span>
                    </div>
                </td>
            </tr>

            <!-- Main Content -->
            <tr>
                <td class="card-body" style="padding: 36px 40px; background-color: #FFFFFF; text-align: left;">
                    
                    <h1 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.25px;">
                        Hello {{ $ownerName }},
                    </h1>
                    
                    <p style="font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 24px 0;">
                        We have completed the quality review of your property listing on HomiQ. Here is the moderation summary for your space:
                    </p>

                    <!-- Details Card -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; margin-bottom: 24px;">
                        <tr>
                            <td style="padding: 14px 20px; background-color: #F1F5F9; border-bottom: 1px solid #E2E8F0;">
                                <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #475569;">
                                    Listing Review Details
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; color: #64748B; font-weight: 500; width: 35%;">Property Title</td>
                                        <td style="padding: 6px 0; font-size: 14px; color: #0F172A; font-weight: 700; text-align: right;">{{ $propertyTitle }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; color: #64748B; font-weight: 500;">Review Status</td>
                                        <td style="padding: 6px 0; text-align: right;">
                                            @if($status === 'approved')
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0;">Approved &amp; Live</span>
                                            @elseif($status === 'rejected')
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA;">Requires Updates</span>
                                            @else
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #FEF3C7; color: #B45309; border: 1px solid #FDE68A;">{{ ucfirst($status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Status Action Callout -->
                    @if($status === 'approved')
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 10px; margin-bottom: 24px;">
                            <tr>
                                <td style="padding: 16px 20px;">
                                    <div style="font-size: 14px; font-weight: 700; color: #065F46; margin-bottom: 4px;">
                                        Listing Approved &amp; Live
                                    </div>
                                    <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #047857;">
                                        Your property is now active in search results, tenant demand broadcasts, and ready to receive direct owner inquiries with 0% brokerage.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    @elseif($status === 'rejected')
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FEF2F2; border: 1px solid #FECDD3; border-radius: 10px; margin-bottom: 20px;">
                            <tr>
                                <td style="padding: 16px 20px;">
                                    <div style="font-size: 14px; font-weight: 700; color: #991B1B; margin-bottom: 4px;">
                                        Moderation Feedback
                                    </div>
                                    <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #B91C1C;">
                                        @if(!empty($reason))
                                            <strong>Reason:</strong> {{ $reason }}
                                        @else
                                            Your listing requires modifications to satisfy our authenticity and verification standards.
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </table>

                        @if(!empty($notes))
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #92400E; margin-bottom: 4px;">
                                            Moderator Notes &amp; Next Steps
                                        </div>
                                        <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #78350F;">
                                            {{ $notes }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        @endif

                        <p style="font-size: 13px; line-height: 1.6; color: #64748B; margin: 0 0 24px 0;">
                            You can easily update photos, pricing, or details by logging into your host dashboard and resubmitting for fast re-approval.
                        </p>
                    @endif

                    <!-- Action Button -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 28px 0 16px 0;">
                        <tr>
                            <td align="center">
                                <a href="{{ url('/dashboard') }}" target="_blank" style="display: inline-block; background-color: #0F172A; color: #FFFFFF !important; font-size: 14px; font-weight: 700; text-decoration: none; padding: 13px 32px; border-radius: 10px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);">
                                    Open Host Dashboard
                                </a>
                            </td>
                        </tr>
                    </table>

                    <p style="font-size: 12px; line-height: 1.5; color: #94A3B8; margin: 24px 0 0 0; text-align: center;">
                        Need help with your listing? Contact our support team at <a href="mailto:support@homiq.space" style="color: #0F172A; text-decoration: underline; font-weight: 600;">support@homiq.space</a>.
                    </p>

                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer-container" align="center" style="padding: 28px 40px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0; text-align: center;">
                    <p style="font-size: 12px; line-height: 1.6; color: #64748B; margin: 0 0 10px 0;">
                        This is an automated operational notification from HomiQ Space Rentals.<br>
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
