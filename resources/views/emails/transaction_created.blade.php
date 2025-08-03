<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaction Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 40px 0;" align="center">
                <table cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="background-color: #e21e17; padding: 20px; text-align: center; color: white;">
                            <h1 style="margin: 0;">Transaction Confirmation</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 18px;">Hello <strong>{{ $student->name }}</strong>,</p>
                            <p style="font-size: 16px; color: #555;">Thank you for your transaction. Here are the details:</p>
                            
                            <table cellpadding="5" cellspacing="0" width="100%" style="margin-top: 15px;">
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Course:</td>
                                    <td style="color: #333;">{{ $transaction->course->name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Amount:</td>
                                    <td style="color: #333;">${{ number_format($transaction->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Payment Method:</td>
                                    <td style="color: #333;">{{ ucfirst($transaction->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #333;">Status:</td>
                                    <td style="color: #333;">{{ ucfirst($transaction->status) }}</td>
                                </tr>
                            </table>

                            @if ($transaction->payment_method === 'bank_transfer')
                                <div style="margin-top: 25px;">
                                    <p style="font-size: 16px; color: #555;">Please transfer the amount to the following bank account:</p>
                                    <p style="font-size: 16px; font-weight: bold; color: #333;">Bank Name:  KBZ Bank</p>
                                    <p style="font-size: 16px; font-weight: bold; color: #333;">Account Name: Y-Max University</p>
                                    <p style="font-size: 16px; font-weight: bold; color: #333;">Account Number: 9833 9384 8384 9384</p>
                                </div>
                            @endif

                            <p style="margin-top: 30px; font-size: 16px; color: #555;">
                                If you have any questions, please don't hesitate to contact us.
                            </p>

                            <p style="margin-top: 20px; font-size: 16px; color: #555;">
                                Best regards,<br>
                                <strong>Y-Max University</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 12px; color: #888;">
                            &copy; {{ date('Y') }} Your Company. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
