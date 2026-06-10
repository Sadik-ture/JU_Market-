<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ID Verification - Campus Trade</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f7fb;
            padding: 40px 20px;
        }
        
        .email-container {
            max-width: 580px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 20px;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
        }
        
        .status-approved {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }
        
        .status-rejected {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        
        /* Content */
        .email-content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 20px;
        }
        
        .greeting strong {
            color: #1e40af;
        }
        
        .message-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 24px;
            margin: 25px 0;
            border-left: 4px solid;
        }
        
        .message-approved {
            border-left-color: #10b981;
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 100%);
        }
        
        .message-rejected {
            border-left-color: #ef4444;
            background: linear-gradient(135deg, #fef2f2 0%, #f8fafc 100%);
        }
        
        .reason-box {
            background: #fef2f2;
            border-radius: 12px;
            padding: 16px;
            margin-top: 15px;
            border: 1px solid #fecaca;
        }
        
        .reason-label {
            font-size: 12px;
            font-weight: 600;
            color: #dc2626;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .reason-text {
            color: #991b1b;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin: 25px 0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 12px;
        }
        
        .feature-icon {
            width: 32px;
            height: 32px;
            background: #e0e7ff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
        }
        
        .feature-text {
            font-size: 13px;
            color: #334155;
        }
        
        /* Button */
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #3b82f6;
            color: #3b82f6;
        }
        
        .btn-outline:hover {
            background: #eff6ff;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        /* Footer */
        .email-footer {
            padding: 25px 30px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        
        .footer-text {
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.6;
        }
        
        .social-links {
            margin-top: 15px;
        }
        
        .social-links a {
            color: #94a3b8;
            margin: 0 10px;
            text-decoration: none;
            font-size: 18px;
        }
        
        .social-links a:hover {
            color: #3b82f6;
        }
        
        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        
        <!-- Header -->
        <div class="email-header">
            <div class="logo">
                <div class="logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <span>Campus Trade</span>
            </div>
            
            @if($status == 'approved')
                <div class="status-badge status-approved">
                    ✓ VERIFIED
                </div>
            @else
                <div class="status-badge status-rejected">
                    ✗ NOT VERIFIED
                </div>
            @endif
        </div>
        
        <!-- Content -->
        <div class="email-content">
            
            @if($status == 'approved')
                <!-- APPROVED EMAIL CONTENT -->
                <div class="greeting">
                    Dear <strong>{{ $user->name }}</strong>,
                </div>
                
                <div class="message-box message-approved">
                    <p style="font-size: 16px; color: #065f46; margin-bottom: 8px;">
                        🎉 <strong>Congratulations! Your student ID has been verified.</strong>
                    </p>
                    <p style="color: #047857; font-size: 14px; margin-top: 8px;">
                        You now have full access to all Campus Trade features.
                    </p>
                </div>
                
                <p style="color: #475569; margin-bottom: 15px;">Here's what you can do now:</p>
                
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">📦</div>
                        <span class="feature-text">Sell your items</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🛒</div>
                        <span class="feature-text">Buy great deals</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">💬</div>
                        <span class="feature-text">Message sellers</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">⭐</div>
                        <span class="feature-text">Rate & review</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">❤️</div>
                        <span class="feature-text">Save favorites</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🛡️</div>
                        <span class="feature-text">Trusted badge</span>
                    </div>
                </div>
                
                <div class="button-group">
                    <a href="{{ route('listings.create') }}" class="btn btn-primary">
                        Start Selling
                    </a>
                    <a href="{{ route('listings.index') }}" class="btn btn-outline">
                        Browse Items
                    </a>
                </div>
                
            @else
                <!-- REJECTED EMAIL CONTENT -->
                <div class="greeting">
                    Dear <strong>{{ $user->name }}</strong>,
                </div>
                
                <div class="message-box message-rejected">
                    <p style="font-size: 16px; color: #991b1b; margin-bottom: 8px;">
                        ⚠️ <strong>Your student ID verification was not approved.</strong>
                    </p>
                    <p style="color: #b91c1c; font-size: 14px; margin-top: 8px;">
                        Please review the reason below and submit a new ID.
                    </p>
                </div>
                
                <div class="reason-box">
                    <div class="reason-label">
                        <i>📋 REASON FOR REJECTION</i>
                    </div>
                    <div class="reason-text">
                        "{{ $reason ?? 'Please upload a clear image of your student ID card.' }}"
                    </div>
                </div>
                
                <p style="color: #475569; margin: 20px 0 15px 0;">
                    To get verified, please:
                </p>
                
                <ul style="color: #475569; margin-left: 20px; line-height: 1.8;">
                    <li>Take a clear, well-lit photo of your student ID</li>
                    <li>Make sure all text and photo are visible</li>
                    <li>Submit the image in JPG or PNG format (max 2MB)</li>
                </ul>
                
                <div class="button-group" style="margin-top: 30px;">
                    <a href="{{ route('id-verification.show') }}" class="btn btn-primary">
                        Upload New ID
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">
                        Contact Support
                    </a>
                </div>
                
                <hr>
                
                <p style="color: #64748b; font-size: 13px; text-align: center;">
                    Need help? Our support team is here for you.<br>
                    <a href="mailto:support@campustrade.com" style="color: #3b82f6;">support@campustrade.com</a>
                </p>
            @endif
            
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p class="footer-text">
                Campus Trade – The trusted marketplace for university students
            </p>
            <p class="footer-text" style="font-size: 11px;">
                This is an automated message, please do not reply directly to this email.
            </p>
            <div class="social-links">
                <a href="#">📘</a>
                <a href="#">🐦</a>
                <a href="#">📷</a>
                <a href="#">💬</a>
            </div>
            <p class="footer-text" style="margin-top: 15px;">
                &copy; {{ date('Y') }} Campus Trade. All rights reserved.
            </p>
        </div>
        
    </div>
</body>
</html>