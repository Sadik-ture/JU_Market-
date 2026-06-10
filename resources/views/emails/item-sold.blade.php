<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Item Has Been Sold</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #0f172a; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: #1e293b; border-radius: 16px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #1e40af, #3b82f6); padding: 30px; text-align: center; }
        .content { padding: 30px; color: #e2e8f0; }
        .button { background: #3b82f6; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; }
        .footer { padding: 20px; text-align: center; border-top: 1px solid #334155; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: white; margin: 0;">🎉 Item Sold!</h1>
        </div>
        <div class="content">
            <h2 style="color: white;">Congratulations {{ $seller->name }}!</h2>
            <p>Your item <strong>"{{ $listing->title }}"</strong> has been sold to <strong>{{ $buyer->name }}</strong>.</p>
            
            <div style="background: #0f172a; padding: 20px; border-radius: 12px; margin: 20px 0;">
                <p style="margin: 0;"><strong>💰 Sale Amount:</strong> ETB {{ number_format($listing->price, 2) }}</p>
                <p><strong>👤 Buyer:</strong> {{ $buyer->name }} ({{ $buyer->email }})</p>
            </div>
            
            <p>Next steps:</p>
            <ul>
                <li>Contact the buyer to arrange delivery</li>
                <li>After delivery, confirm the transaction</li>
                <li>Receive your payout</li>
            </ul>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('messages.start', $listing) }}" class="button">Message Buyer</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Campus Trade. All rights reserved.</p>
        </div>
    </div>
</body>
</html>