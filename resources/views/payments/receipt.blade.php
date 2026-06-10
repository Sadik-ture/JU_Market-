<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - Campus Trade</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 40px 20px;
        }
        
        .receipt-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        
        /* Header */
        .receipt-header {
            background: linear-gradient(135deg, #0D9488 0%, #0F766E 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .success-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        
        .success-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }
        
        .receipt-header h1 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .receipt-header p {
            font-size: 13px;
            opacity: 0.9;
        }
        
        /* Content */
        .receipt-content {
            padding: 24px;
        }
        
        /* Status Badge */
        .status-badge {
            background: #D1FAE5;
            color: #065F46;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        
        .status-badge svg {
            width: 16px;
            height: 16px;
        }
        
        /* Info Row */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .info-label {
            color: #6B7280;
            font-size: 13px;
        }
        
        .info-value {
            font-weight: 500;
            font-size: 13px;
            color: #111827;
        }
        
        .info-value.mono {
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        
        /* Amount Section */
        .amount-section {
            background: #F0FDF4;
            border-radius: 16px;
            padding: 16px;
            margin: 20px 0;
            text-align: center;
        }
        
        .amount-label {
            font-size: 12px;
            color: #166534;
            margin-bottom: 4px;
        }
        
        .amount-value {
            font-size: 32px;
            font-weight: 700;
            color: #166534;
        }
        
        .amount-currency {
            font-size: 16px;
            font-weight: 500;
        }
        
        /* Payment Method Box */
        .payment-method {
            background: #F9FAFB;
            border-radius: 12px;
            padding: 16px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .payment-icon {
            width: 48px;
            height: 48px;
            background: #E5E7EB;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .payment-icon span {
            font-size: 24px;
        }
        
        .payment-details h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .payment-details p {
            font-size: 12px;
            color: #6B7280;
        }
        
        /* QR Code Placeholder */
        .qr-section {
            background: #F9FAFB;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        
        .qr-placeholder {
            width: 120px;
            height: 120px;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .qr-placeholder svg {
            width: 60px;
            height: 60px;
            color: #9CA3AF;
        }
        
        .qr-section p {
            font-size: 12px;
            color: #6B7280;
        }
        
        /* Footer Buttons */
        .receipt-footer {
            padding: 20px 24px 24px;
            border-top: 1px solid #E5E7EB;
            background: #FAFAFA;
        }
        
        .btn-primary {
            width: 100%;
            background: #0D9488;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
            transition: background 0.2s;
        }
        
        .btn-primary:hover {
            background: #0F766E;
        }
        
        .btn-secondary {
            width: 100%;
            background: white;
            color: #374151;
            border: 1px solid #E5E7EB;
            padding: 14px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
            transition: background 0.2s;
        }
        
        .btn-secondary:hover {
            background: #F9FAFB;
        }
        
        .btn-outline {
            width: 100%;
            background: white;
            color: #6B7280;
            border: 1px solid #E5E7EB;
            padding: 12px;
            border-radius: 40px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .footer-note {
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1>Payment Successful!</h1>
            <p>Your transaction has been completed</p>
        </div>
        
        <div class="receipt-content">
            <!-- Status -->
            <div style="text-align: center;">
                <div class="status-badge" style="display: inline-flex;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Payment Completed
                </div>
            </div>
            
            <!-- Amount -->
            <div class="amount-section">
                <div class="amount-label">Total Amount Paid</div>
                <div class="amount-value">
                    <span class="amount-currency">ETB</span> {{ number_format($payment->amount, 2) }}
                </div>
            </div>
            
            <!-- Transaction Details -->
            <div class="info-row">
                <span class="info-label">Transaction ID</span>
                <span class="info-value mono">{{ $payment->transaction_id }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Reference Number</span>
                <span class="info-value mono">{{ $payment->tx_ref }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Payment Date</span>
                <span class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('F j, Y g:i A') : $payment->created_at->format('F j, Y g:i A') }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Payment Status</span>
                <span class="info-value" style="color: #059669;">Successful</span>
            </div>
            
            <!-- Item Details -->
            <div style="margin: 20px 0;">
                <div class="info-row" style="border-bottom: none; padding-bottom: 4px;">
                    <span class="info-label">Item Purchased</span>
                    <span class="info-value">{{ $payment->listing->title }}</span>
                </div>
                <div class="info-row" style="border-bottom: none; padding-top: 4px;">
                    <span class="info-label">Seller</span>
                    <span class="info-value">{{ $payment->seller->name }}</span>
                </div>
                <div class="info-row" style="border-bottom: none; padding-top: 4px;">
                    <span class="info-label">Buyer</span>
                    <span class="info-value">{{ $payment->buyer->name }}</span>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="payment-method">
                <div class="payment-icon">
                    <span>💳</span>
                </div>
                <div class="payment-details">
                    <h4>Chapa Payment Gateway</h4>
                    <p>Telebirr • CBEBirr • eBirr • Card</p>
                </div>
            </div>
            
            <!-- QR Code Section (like Chapa) -->
            <div class="qr-section">
                <div class="qr-placeholder">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <p>Scan to view transaction details</p>
                <p style="font-size: 10px; margin-top: 8px;">chapa.co/verify/{{ substr($payment->transaction_id, 0, 12) }}</p>
            </div>
            
            <!-- Email Notice -->
            <div style="background: #EFF6FF; border-radius: 12px; padding: 12px; margin-top: 16px; text-align: center;">
                <p style="font-size: 12px; color: #1E40AF;">
                    📧 Receipt sent to: {{ $payment->buyer->email }}
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="receipt-footer">
            <button class="btn-primary" onclick="window.print()">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Receipt
            </button>
            
            <a href="{{ route('messages.start', $payment->listing) }}" class="btn-secondary" style="text-decoration: none; display: block;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Message Seller
            </a>
            
            <a href="{{ route('listings.index') }}" class="btn-outline" style="text-decoration: none; display: block;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h2m10 0h2M5 12a7 7 0 1014 0 7 7 0 00-14 0zm7-7v2m0 3v2"></path>
                </svg>
                Continue Shopping
            </a>
            
            <div class="footer-note">
                This is an official receipt from Campus Trade x Chapa
            </div>
        </div>
    </div>
    
    <script>
        // Auto-print option (uncomment if you want auto-print)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // }
    </script>
</body>
</html>