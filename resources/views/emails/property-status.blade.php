<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Status Update</title>
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
        .container { max-width: 600px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02); }
        .top-bar { height: 6px; background: linear-gradient(90deg, #5C33CF 0%, #8A5CF5 100%); }
        .header { padding: 32px 40px 24px 40px; border-bottom: 1px solid #F1F5F9; text-align: left; }
        .logo { font-size: 26px; font-weight: 800; color: #5C33CF; text-decoration: none; letter-spacing: -0.5px; }
        .content { padding: 40px; }
        .greeting { font-size: 20px; font-weight: 700; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.25px; }
        .text { font-size: 16px; line-height: 1.6; color: #475569; margin: 0 0 24px 0; }
        
        /* Details Card */
        .details-card { background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 24px; margin-bottom: 28px; }
        .detail-row { margin-bottom: 16px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748B; margin-bottom: 4px; }
        .detail-value { font-size: 16px; font-weight: 700; color: #0F172A; }
        
        /* Status Badges */
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-approved { background-color: #DCFCE7; color: #15803D; }
        .status-rejected { background-color: #FEE2E2; color: #B91C1C; }
        .status-pending { background-color: #FEF3C7; color: #B45309; }

        /* Action box */
        .action-box { background-color: #EEF2FF; border-left: 4px solid #5C33CF; border-radius: 4px 8px 8px 4px; padding: 20px; margin-bottom: 28px; }
        .action-text { font-size: 15px; line-height: 1.5; color: #3730A3; margin: 0; }

        /* Button */
        .btn-container { text-align: center; margin: 32px 0 16px 0; }
        .btn { display: inline-block; padding: 14px 32px; background-color: #5C33CF; color: #FFFFFF !important; text-decoration: none; font-weight: 700; font-size: 16px; border-radius: 8px; box-shadow: 0 4px 10px rgba(92, 51, 207, 0.2); transition: all 0.2s ease; }
        
        /* Footer */
        .footer { padding: 32px 40px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0; text-align: center; }
        .footer-text { font-size: 13px; line-height: 1.5; color: #64748B; margin: 0 0 12px 0; }
        .footer-links { font-size: 13px; font-weight: 600; color: #5C33CF; text-decoration: none; margin: 0 8px; }
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
                <h1 class="greeting">Hello {{ $ownerName }},</h1>
                <p class="text">We've completed the review of your property listing. Here is the updated status of your listing on our platform.</p>
                
                <div class="details-card">
                    <div class="detail-row">
                        <div class="detail-label">Property Title</div>
                        <div class="detail-value">{{ $propertyTitle }}</div>
                    </div>
                    <div style="height: 16px;"></div>
                    <div class="detail-row">
                        <div class="detail-label">Listing Status</div>
                        <div style="margin-top: 4px;">
                            @if($status === 'approved')
                                <span class="status-badge status-approved">Approved</span>
                            @elseif($status === 'rejected')
                                <span class="status-badge status-rejected">Rejected</span>
                            @else
                                <span class="status-badge status-pending">{{ ucfirst($status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($status === 'approved')
                    <div class="action-box">
                        <p class="action-text">🎉 <strong>Congratulations!</strong> Your property is now live and can be searched and booked by users on HomiQ worldwide.</p>
                    </div>
                @elseif($status === 'rejected')
                    <div class="action-box" style="background-color: #FEF2F2; border-left-color: #EF4444;">
                        <p class="action-text" style="color: #991B1B;">⚠️ <strong>Review Required:</strong> Your listing did not meet our community guidelines. Please inspect the property details, images, and descriptions, then update and resubmit.</p>
                    </div>
                @endif

                <div class="btn-container">
                    <a href="{{ url('/dashboard') }}" class="btn">Manage Listings</a>
                </div>

                <p class="text" style="margin-top: 32px; font-size: 15px; color: #64748B;">If you have any questions or need assistance, feel free to visit our support center.</p>
            </div>
            <div class="footer">
                <p class="footer-text">This is an automated operational email from HomiQ. Please do not reply directly to this message.</p>
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
