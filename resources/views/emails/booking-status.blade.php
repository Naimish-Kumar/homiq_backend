<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HomiQ - Booking Status Update</title>
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
    @php
        $currencySymbol = match($currency ?? 'INR') {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => '₹',
        };
    @endphp

    <div class="wrapper" style="background-color: #F8FAFC; padding: 40px 12px; width: 100%; min-height: 100%;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.02);">
            
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
                        <span style="display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #0F172A; background-color: #F1F5F9; border: 1px solid #E2E8F0; padding: 3px 10px; border-radius: 9999px;">
                            Booking Update
                        </span>
                    </div>
                </td>
            </tr>

            <!-- Main Content -->
            <tr>
                <td class="card-body" style="padding: 36px 40px; background-color: #FFFFFF; text-align: left;">
                    
                    <h1 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.25px;">
                        Hello {{ $userName }},
                    </h1>
                    
                    <p style="font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 24px 0;">
                        We are writing to update you on the status of your booking request. Here are the latest details for your reservation:
                    </p>

                    <!-- Receipt / Details Card -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; margin-bottom: 24px;">
                        <tr>
                            <td style="padding: 14px 20px; background-color: #F1F5F9; border-bottom: 1px solid #E2E8F0;">
                                <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #475569;">
                                    Booking Summary
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; color: #64748B; font-weight: 500; width: 35%;">Property</td>
                                        <td style="padding: 6px 0; font-size: 14px; color: #0F172A; font-weight: 700; text-align: right;">{{ $propertyTitle }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; color: #64748B; font-weight: 500;">Status</td>
                                        <td style="padding: 6px 0; text-align: right;">
                                            @if($status === 'approved')
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0;">Approved</span>
                                            @elseif($status === 'rejected')
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA;">Rejected</span>
                                            @elseif($status === 'cancelled')
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #F1F5F9; color: #475569; border: 1px solid #E2E8F0;">Cancelled</span>
                                            @else
                                                <span style="display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; background-color: #FEF3C7; color: #B45309; border: 1px solid #FDE68A;">{{ ucfirst($status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; color: #64748B; font-weight: 500;">Check-in</td>
                                        <td style="padding: 6px 0; font-size: 14px; color: #0F172A; font-weight: 600; text-align: right;">{{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; color: #64748B; font-weight: 500;">Check-out</td>
                                        <td style="padding: 6px 0; font-size: 14px; color: #0F172A; font-weight: 600; text-align: right;">{{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding-top: 10px; border-top: 1px solid #E2E8F0;"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; font-size: 14px; color: #0F172A; font-weight: 800;">Total Amount</td>
                                        <td style="padding: 4px 0; font-size: 17px; color: #059669; font-weight: 800; text-align: right;">{{ $currencySymbol }} {{ number_format((float)$totalPrice, 2) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Status Action Callout -->
                    @if($status === 'approved')
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 10px; margin-bottom: 28px;">
                            <tr>
                                <td style="padding: 16px 20px;">
                                    <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #065F46;">
                                        <strong>Booking Confirmed!</strong> Your request has been accepted by the host. You are all set for your stay.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    @elseif($status === 'rejected')
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FEF2F2; border: 1px solid #FECDD3; border-radius: 10px; margin-bottom: 28px;">
                            <tr>
                                <td style="padding: 16px 20px;">
                                    <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #991B1B;">
                                        <strong>Booking Declined:</strong> The host was unable to accept your request. Any payment hold has been released.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    @elseif($status === 'cancelled')
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 28px;">
                            <tr>
                                <td style="padding: 16px 20px;">
                                    <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #475569;">
                                        <strong>Booking Cancelled:</strong> This booking has been cancelled and is no longer active.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    @endif

                    <!-- Action Button -->
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 28px 0;">
                        <tr>
                            <td align="center">
                                <a href="{{ url('/dashboard') }}" target="_blank" style="display: inline-block; background-color: #0F172A; color: #FFFFFF !important; font-size: 14px; font-weight: 700; text-decoration: none; padding: 13px 32px; border-radius: 10px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);">
                                    View Booking Details
                                </a>
                            </td>
                        </tr>
                    </table>

                    <p style="font-size: 13px; line-height: 1.5; color: #64748B; margin: 24px 0 0 0; text-align: center;">
                        If you have questions or wish to contact your host directly, please open your HomiQ App or web dashboard.
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
