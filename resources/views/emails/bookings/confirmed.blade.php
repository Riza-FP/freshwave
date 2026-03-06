<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Confirmed</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #0f172a;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 40px 30px;
        }

        .content h2 {
            margin-top: 0;
            color: #0f172a;
            font-size: 20px;
        }

        .content p {
            line-height: 1.6;
            color: #475569;
            margin-bottom: 20px;
        }

        .details-card {
            background-color: #f1f5f9;
            border-left: 4px solid #34d399;
            padding: 20px;
            border-radius: 4px;
            margin: 30px 0;
        }

        .details-item {
            margin-bottom: 12px;
            font-size: 15px;
        }

        .details-item:last-child {
            margin-bottom: 0;
        }

        .details-item strong {
            color: #0f172a;
            display: inline-block;
            width: 80px;
        }

        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }

        .button {
            display: inline-block;
            background-color: #34d399;
            color: #0f172a !important;
            padding: 14px 28px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmed!</h1>
        </div>
        <div class="content">
            <h2>Hi {{ $booking->name }},</h2>
            <p>Your car wash time slot has been successfully reserved. We look forward to seeing you and making your car
                shine!</p>

            <div class="details-card">
                <div class="details-item">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, M jS, Y') }}
                </div>
                <div class="details-item">
                    <strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                </div>
                <div class="details-item">
                    <strong>Phone:</strong> {{ $booking->phone_number }}
                </div>
            </div>

        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Car Wash Booking') }}. All rights reserved.
        </div>
    </div>
</body>

</html>