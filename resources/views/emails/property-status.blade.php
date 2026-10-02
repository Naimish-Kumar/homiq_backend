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
        .container { max-width: 600px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .top-bar { height: 6px; background: linear-gradient(90deg, #10B981 0%, #0A2540 100%); }
        .header { padding: 32px 40px 24px 40px; border-bottom: 1px solid #F1F5F9; text-align: left; }
        .logo { font-size: 26px; font-weight: 900; color: #0A2540; text-decoration: none; letter-spacing: -0.5px; }
        .logo span { color: #10B981; }
        .content { padding: 40px; }
        .greeting { font-size: 20px; font-weight: 700; color: #0F172A; margin: 0 0 16px 0; }
        .text { font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 24px 0; }
        
        /* Details Card */
        .details-card { background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .detail-row { margin-bottom: 12px; }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748B; margin-bottom: 4px; }
        .detail-value { font-size: 16px; font-weight: 700; color: #0F172A; }
        
        /* Status Badges */
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-approved { background-color: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
        .status-rejected { background-color: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
        .status-pending { background-color: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }

        /* Action box */
        .action-box { border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .action-approved { background-color: #ECFDF5; border-left: 4px solid #10B981; }
        .action-rejected { background-color: #FEF2F2; border-left: 4px solid #EF4444; }
        .action-title { font-size: 14px; font-weight: 700; margin: 0 0 6px 0; }
        .action-text { font-size: 14px; line-height: 1.5; margin: 0; }

        /* Feedback note box */
        .feedback-box { background-color: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px; padding: 16px; margin-bottom: 24px; }
        .feedback-label { font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .feedback-text { font-size: 13px; color: #78350F; line-height: 1.5; margin: 0; }

        /* Button */
        .btn-container { text-align: center; margin: 32px 0 16px 0; }
        .btn { display: inline-block; padding: 14px 32px; background-color: #0A2540; color: #FFFFFF !important; text-decoration: none; font-weight: 700; font-size: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(10, 37, 64, 0.2); }
        
        /* Footer */
        .footer { padding: 32px 40px; background-color: #F8FAFC; border-top: 1px solid #E2E8F0; text-align: center; }
        .footer-text { font-size: 12px; line-height: 1.5; color: #64748B; margin: 0 0 12px 0; }
        .footer-links { font-size: 12px; font-weight: 600; color: #0A2540; text-decoration: none; margin: 0 8px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="top-bar"></div>
            <div class="header">
                <a href="{{ url('/') }}" class="logo">Homi<span>Q</span></a>
            </div>
            <div class="content">
                <h1 class="greeting">Hello {{ $ownerName }},</h1>
                <p class="text">We have completed the review of your property listing on HomiQ. Here is the moderation summary for your space.</p>
                
                <div class="details-card">
                    <div class="detail-row">
                        <div class="detail-label">Property Title</div>
                        <div class="detail-value">{{ $propertyTitle }}</div>
                    </div>
                    <div style="height: 12px;"></div>
                    <div class="detail-row">
                        <div class="detail-label">Moderation Result</div>
                        <div style="margin-top: 4px;">
                            @if($status === 'approved')
                                <span class="status-badge status-approved">Approved & Live</span>
                            @elseif($status === 'rejected')
                                <span class="status-badge status-rejected">Requires Updates / Rejected</span>
                            @else
                                <span class="status-badge status-pending">{{ ucfirst($status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($status === 'approved')
                    <div class="action-box action-approved">
                        <p class="action-title" style="color: #065F46;">Listing Approved & Live</p>
                        <p class="action-text" style="color: #047857;">Your property is now active in search results, tenant demand broadcasts, and ready to receive bookings and inquiries.</p>
                    </div>
                @elseif($status === 'rejected')
                    <div class="action-box action-rejected">
                        <p class="action-title" style="color: #991B1B;">Moderation Feedback</p>
                        <p class="action-text" style="color: #B91C1C;">
                            @if(!empty($reason))
                                <strong>Reason:</strong> {{ $reason }}
                            @else
                                Your listing did not satisfy our quality and verification standards.
                            @endif
                        </p>
                    </div>

                    @if(!empty($notes))
                        <div class="feedback-box">
                            <div class="feedback-label">Admin Notes & Next Steps:</div>
                            <p class="feedback-text">{{ $notes }}</p>
                        </div>
                    @endif

                    <p class="text" style="font-size: 14px; color: #64748B;">
                        You can easily update your photos, pricing, or description by logging into your host dashboard and resubmitting the listing for instant re-review.
                    </p>
                @endif

                <div class="btn-container">
                    <a href="{{ url('/dashboard') }}" class="btn">Open Host Dashboard</a>
                </div>

                <p class="text" style="margin-top: 32px; font-size: 13px; color: #94A3B8;">If you need assistance with your listing, reach out to our team at support@homiq.in.</p>
            </div>
            <div class="footer">
                <p class="footer-text">This is an automated operational notification from HomiQ. Verified listings with 0% brokerage.</p>
                <p class="footer-text" style="font-weight: 600;">&copy; {{ date('Y') }} HomiQ Inc. All rights reserved.</p>
                <div style="margin-top: 12px;">
                    <a href="{{ url('/privacy') }}" class="footer-links">Privacy Policy</a>
                    <span style="color: #CBD5E1;">&bull;</span>
                    <a href="{{ url('/terms') }}" class="footer-links">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
