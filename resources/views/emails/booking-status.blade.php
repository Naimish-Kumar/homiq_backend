<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Status Update</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 30px; }
        .header { border-bottom: 2px solid #5C33CF; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #5C33CF; text-decoration: none; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: bold; text-transform: uppercase; font-size: 14px; }
        .approved { background-color: #d4edda; color: #155724; }
        .rejected { background-color: #f8d7da; color: #721c24; }
        .cancelled { background-color: #e2e3e5; color: #383d41; }
        .pending { background-color: #fff3cd; color: #856404; }
        .footer { margin-top: 30px; border-top: 1px solid #e0e0e0; padding-top: 20px; font-size: 12px; color: #777777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="#" class="logo">HomiQ</a>
        </div>
        <p>Hello {{ $userName }},</p>
        <p>We are writing to update you on the status of your booking.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0; border: 1px solid #e0e0e0;">
            <tr style="border-bottom: 1px solid #e0e0e0;">
                <td style="padding: 10px; font-weight: bold; background: #f9f9f9; width: 35%;">Property:</td>
                <td style="padding: 10px;">{{ $propertyTitle }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #e0e0e0;">
                <td style="padding: 10px; font-weight: bold; background: #f9f9f9;">Status:</td>
                <td style="padding: 10px;">
                    <span class="status-badge {{ $status }}">
                        {{ $status }}
                    </span>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #e0e0e0;">
                <td style="padding: 10px; font-weight: bold; background: #f9f9f9;">Check-in Date:</td>
                <td style="padding: 10px;">{{ $checkIn }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #e0e0e0;">
                <td style="padding: 10px; font-weight: bold; background: #f9f9f9;">Check-out Date:</td>
                <td style="padding: 10px;">{{ $checkOut }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; background: #f9f9f9;">Total Price:</td>
                <td style="padding: 10px; font-weight: bold; color: #5C33CF;">INR {{ $totalPrice }}</td>
            </tr>
        </table>

        @if($status === 'approved')
            <p>Congratulations! Your booking request has been approved. You are good to go!</p>
        @elseif($status === 'rejected')
            <p>Unfortunately, your booking request was rejected by the host. Any pre-authorized charges will be refunded shortly.</p>
        @elseif($status === 'cancelled')
            <p>Your booking has been cancelled.</p>
        @endif

        <p>Thank you for using HomiQ.</p>
        
        <div class="footer">
            This is an automated message from HomiQ. Please do not reply directly to this email.
        </div>
    </div>
</body>
</html>
