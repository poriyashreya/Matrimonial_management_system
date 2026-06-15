<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Refund Processed</title>
</head>

<body style="font-family: Arial, sans-serif;">

    <h2>Hello {{ $user->name }},</h2>

    <p>Your subscription has been cancelled successfully.</p>

    <p>
        Refund Amount:
        <strong>${{ number_format($refundAmount, 2) }}</strong>
    </p>

    <p>
        The refund has been initiated and will be credited to your original
        payment method within 5-10 business days depending on your bank.
    </p>

    <p>
        Thank you for using our platform.
    </p>

    <br>

    <p>
        Regards,<br>
        Matrimony Management System Team
    </p>

</body>

</html>