<!DOCTYPE html>
<html>

<head>
    <title>Transaction Created</title>
</head>

<body>
    <h1>Hello {{ $student->name }},</h1>
    <p>Thank you for your transaction.</p>
    <p><strong>Transaction Details:</strong></p>
    <ul>
        <li>Course ID: {{ $transaction->course_id }}</li>
        <li>Amount: ${{ number_format($transaction->amount, 2) }}</li>
        <li>Payment Method: {{ ucfirst($transaction->payment_method) }}</li>
        <li>Status: {{ ucfirst($transaction->status) }}</li>
    </ul>

    @if ($transaction->payment_method === 'bank_transfer')
        <p>Please transfer the amount to the following bank account:</p>
        <p><strong>Account Number:</strong> {{ $bankAccountNumber }}</p>
    @endif

    <p>If you have any questions, please contact us.</p>
</body>

</html>
