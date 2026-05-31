<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Property Status Update</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 30px; }
        .header { border-bottom: 2px solid #5C33CF; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #5C33CF; text-decoration: none; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: bold; text-transform: uppercase; font-size: 14px; }
        .approved { background-color: #d4edda; color: #155724; }
        .rejected { background-color: #f8d7da; color: #721c24; }
        .pending { background-color: #fff3cd; color: #856404; }
        .footer { margin-top: 30px; border-top: 1px solid #e0e0e0; padding-top: 20px; font-size: 12px; color: #777777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="#" class="logo">HomiQ</a>
        </div>
        <p>Hello {{ $ownerName }},</p>
        <p>We are writing to inform you that the listing status of your property has been updated.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Property Title:</td>
                <td style="padding: 8px 0;">{{ $propertyTitle }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">New Status:</td>
                <td style="padding: 8px 0;">
                    <span class="status-badge {{ $status }}">
                        {{ $status }}
                    </span>
                </td>
            </tr>
        </table>

        @if($status === 'approved')
            <p>Your property is now live and can be booked by users on HomiQ!</p>
        @elseif($status === 'rejected')
            <p>Your property listing did not meet our guidelines. Please review the details and resubmit or contact support if you believe this was an error.</p>
        @endif

        <p>Thank you for choosing HomiQ.</p>
        
        <div class="footer">
            This is an automated message from HomiQ. Please do not reply directly to this email.
        </div>
    </div>
</body>
</html>
