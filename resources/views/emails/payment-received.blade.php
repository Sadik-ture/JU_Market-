<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Received</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #0f172a; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: #1e293b; border-radius: 16px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #059669, #10b981); padding: 30px; text-align: center; }
        .content { padding: 30px; color: #e2e8f0; }
        .payment-details { background: #0f172a; padding: 20px; border-radius: 12px; margin: 20px 0; }
        .button { background: #10b981; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; }
        .footer { padding: 20px; text-align: center; border-top: 1px solid #334155; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: white; margin: 0;">💰 Payment Received!</h1>
        </div>
        <div class="content">
            <h2 style="color: white;">Thank you for your purchase!</h2>
            <p>Your payment has been successfully processed.</p>
            
            <div class="payment-details">
                <p><strong>Item:</strong> {{ $payment->listing->title }}</p>
                <p><strong>Amount Paid:</strong> <span style="color: #10b981; font-size: 20px;">ETB {{ number_format($payment->amount, 2) }}</span></p>
                <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                <p><strong>Payment Date:</strong> {{ $payment->created_at->format('F j, Y g:i A') }}</p>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('payment.receipt', $payment) }}" class="button">View Receipt</a>
                <a href="{{ route('messages.start', $payment->listing) }}" class="button" style="background: #3b82f6; margin-left: 10px;">Contact Seller</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Campus Trade. All rights reserved.</p>
        </div>
    </div>
</body>
</html>