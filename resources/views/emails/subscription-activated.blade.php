<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif;">

    <h2>Hello {{ $user->name }},</h2>

    <p>Your subscription has been activated successfully.</p>

    <table cellpadding="8">
        <tr>
            <td><strong>Plan</strong></td>
            <td>{{ $user->plan }}</td>
        </tr>

        <tr>
            <td><strong>Amount Paid</strong></td>
            <td>${{ $payment->amount }}</td>
        </tr>

        <tr>
            <td><strong>Payment Date</strong></td>
            <td>{{ $payment->paid_at }}</td>
        </tr>
    </table>

    <p>
        Thank you for choosing our platform.
    </p>

    <p>
        Regards,<br>
        Matrimony Management System Team
    </p>

</body>

</html>