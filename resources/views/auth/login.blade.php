@extends('layouts.app-new')

@section('content')

{{-- ============================================================
     CAMPUS TRADE — Login
     Jimma University Official Brand
     Colors: #003087 (JU Navy), #C8960C (JU Gold), #001f5e (Deep Navy)
     ============================================================ --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap');

    :root {
        --ju-navy:       #003087;
        --ju-navy-dark:  #001f5e;
        --ju-navy-mid:   #012575;
        --ju-navy-light: #0a4aad;
        --ju-gold:       #C8960C;
        --ju-gold-light: #e8b020;
        --ju-gold-pale:  #fdf3d8;
        --ju-gold-dark:  #a37a09;
        --ju-red:        #c0392b;
        --ju-green:      #1a7a3c;
        --ju-surface:    #f0f2f8;
        --ju-card:       #ffffff;
        --ju-border:     #dde3f0;
        --ju-muted:      #6b7494;
        --ju-text:       #111827;
        --shadow-lg: 0 20px 60px rgba(0,30,100,.18), 0 8px 24px rgba(0,0,0,.08);
    }

    * { box-sizing: border-box; }
    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        -webkit-font-smoothing: antialiased;
        margin: 0; padding: 0;
    }

    /* ── Full-screen split layout ── */
    .auth-shell {
        min-height: 100vh;
        display: flex;
        background: var(--ju-surface);
    }

    /* ── Left panel — JU brand pillar ── */
    .auth-brand {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        padding: 48px 52px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(160deg, #000d2e 0%, #001848 45%, #002678 80%, #003087 100%);
    }
    @media (min-width: 1024px) { .auth-brand { display: flex; width: 44%; } }

    /* Mesh grid */
    .auth-brand::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(200,150,12,.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(200,150,12,.045) 1px, transparent 1px);
        background-size: 52px 52px;
        pointer-events: none;
    }
    /* Glow orbs */
    .auth-brand::after {
        content: '';
        position: absolute;
        top: -80px; right: -60px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(200,150,12,.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .brand-orb-bottom {
        position: absolute;
        bottom: -100px; left: -60px;
        width: 360px; height: 360px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0,74,173,.2) 0%, transparent 70%);
        pointer-events: none;
    }
    /* Gold shimmer */
    .brand-shimmer {
        position: absolute;
        top: -50%; left: -60%;
        width: 40%; height: 200%;
        background: linear-gradient(105deg, transparent 40%, rgba(200,150,12,.06) 50%, transparent 60%);
        animation: shimmer 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes shimmer { 0% { left: -60%; } 100% { left: 130%; } }

    .brand-content { position: relative; z-index: 2; }

    .brand-shield {
        width: 68px; height: 68px;
        background: linear-gradient(145deg, rgba(200,150,12,.25), rgba(200,150,12,.08));
        border: 1px solid rgba(200,150,12,.4);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(200,150,12,.15), inset 0 1px 0 rgba(255,255,255,.1);
    }
    .brand-eyebrow {
        font-size: .68rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: #C8960C; margin-bottom: 10px; opacity: .9;
    }
    .brand-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.4rem; font-weight: 800;
        color: #ffffff; line-height: 1.2;
        letter-spacing: -.01em; margin-bottom: 16px;
    }
    .brand-title span { color: #C8960C; }
    .brand-desc {
        font-size: .95rem; color: rgba(255,255,255,.5);
        line-height: 1.75; max-width: 340px;
    }

    /* Feature list */
    .brand-features { position: relative; z-index: 2; }
    .brand-feature {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .brand-feature:last-child { border-bottom: none; }
    .feature-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.1);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: .9rem; color: #C8960C;
    }
    .feature-text { font-size: .83rem; color: rgba(255,255,255,.6); line-height: 1.4; }
    .feature-text strong { color: rgba(255,255,255,.88); font-weight: 600; }

    /* Brand footer stamp */
    .brand-footer { position: relative; z-index: 2; }
    .brand-stamp {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(200,150,12,.1);
        border: 1px solid rgba(200,150,12,.25);
        border-radius: 99px; padding: 6px 14px;
    }
    .stamp-dot { width: 7px; height: 7px; border-radius: 50%; background: #C8960C; }
    .stamp-text { font-size: .72rem; font-weight: 700; color: rgba(200,150,12,.9); letter-spacing: .06em; }

    /* ── Right panel — form ── */
    .auth-form-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 24px;
    }

    .auth-form-wrap {
        width: 100%;
        max-width: 420px;
    }

    /* Mobile header (shown only without left panel) */
    .mobile-header {
        text-align: center;
        margin-bottom: 32px;
    }
    @media (min-width: 1024px) { .mobile-header { display: none; } }

    .mobile-shield {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, var(--ju-navy), var(--ju-navy-light));
        border-radius: 16px;
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
        box-shadow: 0 6px 20px rgba(0,48,135,.25);
    }
    .form-heading {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.9rem; font-weight: 800;
        color: var(--ju-text); letter-spacing: -.01em;
        margin-bottom: 4px;
    }
    .form-subheading {
        font-size: .875rem; color: var(--ju-muted);
    }

    /* Card */
    .auth-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 22px;
        padding: 36px 36px 32px;
        box-shadow: var(--shadow-lg);
    }

    .auth-card-eyebrow {
        font-size: .65rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 6px;
    }
    .auth-card-title {
        font-size: 1.4rem; font-weight: 800;
        color: var(--ju-text); margin-bottom: 24px;
        letter-spacing: -.01em;
    }

    /* Form fields */
    .field-group { margin-bottom: 18px; }
    .field-label {
        display: block;
        font-size: .78rem; font-weight: 700;
        letter-spacing: .04em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 8px;
    }
    .field-label i { font-size: .8rem; margin-right: 5px; color: var(--ju-navy); }

    .field-input {
        width: 100%;
        padding: 12px 16px;
        background: var(--ju-surface);
        border: 1.5px solid var(--ju-border);
        border-radius: 12px;
        font-size: .9rem;
        color: var(--ju-text);
        font-family: 'Inter', sans-serif;
        transition: border-color .2s, box-shadow .2s, background .2s;
        outline: none;
        appearance: none;
    }
    .field-input:focus {
        background: #fff;
        border-color: var(--ju-navy);
        box-shadow: 0 0 0 3px rgba(0,48,135,.1);
    }
    .field-input::placeholder { color: var(--ju-muted); opacity: .5; }
    .field-error {
        font-size: .78rem; color: var(--ju-red); margin-top: 5px;
        display: flex; align-items: center; gap: 4px;
    }

    /* Remember / Forgot row */
    .auth-meta {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 22px;
    }
    .remember-label {
        display: flex; align-items: center; gap: 8px;
        font-size: .83rem; color: var(--ju-muted); cursor: pointer;
    }
    .remember-check {
        width: 16px; height: 16px;
        accent-color: var(--ju-navy);
        cursor: pointer;
    }
    .forgot-link {
        font-size: .83rem; font-weight: 600;
        color: var(--ju-navy); text-decoration: none;
        transition: color .15s;
    }
    .forgot-link:hover { color: var(--ju-gold-dark); text-decoration: underline; }

    /* Submit button */
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, var(--ju-navy-mid), var(--ju-navy-light));
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: .95rem; font-weight: 800;
        font-family: 'Inter', sans-serif;
        letter-spacing: .02em;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s, opacity .2s;
        box-shadow: 0 6px 20px rgba(0,48,135,.3);
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-bottom: 20px;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(0,48,135,.38);
    }
    .btn-submit:active { transform: translateY(0); }

    /* Divider */
    .auth-divider {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 18px;
    }
    .auth-divider::before, .auth-divider::after {
        content: ''; flex: 1; height: 1px; background: var(--ju-border);
    }
    .auth-divider span { font-size: .75rem; color: var(--ju-muted); font-weight: 600; white-space: nowrap; }

    /* Register link */
    .auth-switch {
        text-align: center;
        font-size: .875rem; color: var(--ju-muted);
    }
    .auth-switch a {
        color: var(--ju-navy); font-weight: 700;
        text-decoration: none; transition: color .15s;
    }
    .auth-switch a:hover { color: var(--ju-gold-dark); text-decoration: underline; }

    /* Session status */
    .status-banner {
        background: rgba(26,122,60,.08);
        border: 1px solid rgba(26,122,60,.25);
        border-left: 3px solid var(--ju-green);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: .83rem;
        color: var(--ju-green);
        margin-bottom: 18px;
        display: flex; align-items: center; gap: 8px;
    }

    /* Gold accent bar at top of card */
    .card-accent {
        height: 4px;
        background: linear-gradient(90deg, var(--ju-navy), var(--ju-gold), var(--ju-navy));
        border-radius: 4px 4px 0 0;
        margin: -36px -36px 28px;
        border-radius: 22px 22px 0 0;
    }
</style>

<div class="auth-shell">

    {{-- ── Left Brand Panel ── --}}
    <div class="auth-brand">
        <div class="brand-shimmer"></div>
        <div class="brand-orb-bottom"></div>

        <div class="brand-content">
            <div class="brand-shield">
                <svg viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9">
                    <path d="M20 2L3 9V24C3 33.6 10.5 42.4 20 44C29.5 42.4 37 33.6 37 24V9L20 2Z"
                          fill="#C8960C" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                    <path d="M20 7L8 12.5V24C8 31.2 13.3 37.8 20 39.5C26.7 37.8 32 31.2 32 24V12.5L20 7Z"
                          fill="#001848"/>
                    <text x="20" y="29" text-anchor="middle" fill="#C8960C"
                          font-size="11" font-weight="700" font-family="Georgia,serif">JU</text>
                </svg>
            </div>
            <p class="brand-eyebrow">Jimma University</p>
            <h1 class="brand-title">Campus<br><span>Trade</span></h1>
            <p class="brand-desc">The official peer-to-peer marketplace for Jimma University students. Buy, sell, and connect safely within campus.</p>
        </div>

        <div class="brand-features">
            @foreach([
                ['fas fa-shield-alt',     'Verified Students Only',   'Only @ju.edu.et accounts can join'],
                ['fas fa-tag',            'List Items for Free',       'Post textbooks, electronics & more'],
                ['fas fa-comments',       'Secure In-App Messaging',  'Chat directly with buyers & sellers'],
                ['fas fa-university',     'Campus-Only Deliveries',   'Meet safely on-campus for handoffs'],
            ] as $f)
            <div class="brand-feature">
                <div class="feature-icon"><i class="{{ $f[0] }}"></i></div>
                <div class="feature-text"><strong>{{ $f[1] }}</strong> — {{ $f[2] }}</div>
            </div>
            @endforeach
        </div>

        <div class="brand-footer">
            <div class="brand-stamp">
                <span class="stamp-dot"></span>
                <span class="stamp-text">Official Jimma University Platform · Est. 2024</span>
            </div>
        </div>
    </div>

    {{-- ── Right Form Panel ── --}}
    <div class="auth-form-panel">
        <div class="auth-form-wrap">

            {{-- Mobile-only header --}}
            <div class="mobile-header">
                <div class="mobile-shield">
                    <svg viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px">
                        <path d="M20 2L3 9V24C3 33.6 10.5 42.4 20 44C29.5 42.4 37 33.6 37 24V9L20 2Z" fill="#C8960C"/>
                        <path d="M20 7L8 12.5V24C8 31.2 13.3 37.8 20 39.5C26.7 37.8 32 31.2 32 24V12.5L20 7Z" fill="#001848"/>
                        <text x="20" y="29" text-anchor="middle" fill="#C8960C" font-size="11" font-weight="700" font-family="Georgia,serif">JU</text>
                    </svg>
                </div>
                <h2 class="form-heading">Campus Trade</h2>
                <p class="form-subheading">Jimma University Marketplace</p>
            </div>

            {{-- Auth Card --}}
            <div class="auth-card">
                <div class="card-accent"></div>

                <p class="auth-card-eyebrow">Welcome back</p>
                <h2 class="auth-card-title">Sign in to your account</h2>

                @if(session('status'))
                <div class="status-banner">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-envelope"></i>University Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="email"
                               class="field-input"
                               placeholder="student@ju.edu.et">
                        @error('email')
                        <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field-group" style="margin-bottom:20px">
                        <label class="field-label">
                            <i class="fas fa-lock"></i>Password
                        </label>
                        <input type="password" name="password" required autocomplete="current-password"
                               class="field-input"
                               placeholder="••••••••">
                        @error('password')
                        <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember / Forgot --}}
                    <div class="auth-meta">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" class="remember-check">
                            Remember me
                        </label>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>

                    <div class="auth-divider"><span>New to Campus Trade?</span></div>

                    <div class="auth-switch">
                        Don't have an account?
                        <a href="{{ route('register') }}">Create one free</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

@endsection