@extends('layouts.app-new')

@section('content')

{{-- ============================================================
     CAMPUS TRADE — Register
     Jimma University Official Brand
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

    .auth-shell {
        min-height: 100vh;
        display: flex;
        background: var(--ju-surface);
    }

    /* ── Left brand panel (register: reversed — panel on right) ── */
    .auth-brand {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        padding: 48px 52px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(160deg, #000d2e 0%, #001848 45%, #002678 80%, #003087 100%);
        order: 2;
    }
    @media (min-width: 1024px) { .auth-brand { display: flex; width: 40%; } }

    .auth-brand::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(200,150,12,.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(200,150,12,.045) 1px, transparent 1px);
        background-size: 52px 52px;
        pointer-events: none;
    }
    .auth-brand::after {
        content: '';
        position: absolute;
        bottom: -80px; right: -60px;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(200,150,12,.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .brand-orb-top {
        position: absolute; top: -80px; left: -60px;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(0,74,173,.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .brand-shimmer {
        position: absolute; top: -50%; left: -60%;
        width: 40%; height: 200%;
        background: linear-gradient(105deg, transparent 40%, rgba(200,150,12,.06) 50%, transparent 60%);
        animation: shimmer 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes shimmer { 0% { left: -60%; } 100% { left: 130%; } }

    .brand-content { position: relative; z-index: 2; }
    .brand-shield {
        width: 64px; height: 64px;
        background: linear-gradient(145deg, rgba(200,150,12,.25), rgba(200,150,12,.08));
        border: 1px solid rgba(200,150,12,.4);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(200,150,12,.15), inset 0 1px 0 rgba(255,255,255,.1);
    }
    .brand-eyebrow {
        font-size: .68rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: #C8960C; margin-bottom: 10px; opacity: .9;
    }
    .brand-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem; font-weight: 800;
        color: #ffffff; line-height: 1.2;
        letter-spacing: -.01em; margin-bottom: 14px;
    }
    .brand-title span { color: #C8960C; }
    .brand-desc {
        font-size: .875rem; color: rgba(255,255,255,.5);
        line-height: 1.75;
    }

    /* Steps */
    .brand-steps { position: relative; z-index: 2; }
    .steps-label {
        font-size: .68rem; font-weight: 800; letter-spacing: .12em;
        text-transform: uppercase; color: rgba(200,150,12,.7);
        margin-bottom: 16px;
    }
    .step-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .step-item:last-child { border-bottom: none; }
    .step-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: rgba(200,150,12,.15);
        border: 1px solid rgba(200,150,12,.3);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: .75rem; font-weight: 800; color: #C8960C;
        font-variant-numeric: tabular-nums;
    }
    .step-text { font-size: .83rem; color: rgba(255,255,255,.6); line-height: 1.5; padding-top: 4px; }
    .step-text strong { color: rgba(255,255,255,.88); font-weight: 600; display: block; margin-bottom: 2px; }

    .brand-footer { position: relative; z-index: 2; }
    .brand-stamp {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(200,150,12,.1);
        border: 1px solid rgba(200,150,12,.25);
        border-radius: 99px; padding: 6px 14px;
    }
    .stamp-dot { width: 7px; height: 7px; border-radius: 50%; background: #C8960C; }
    .stamp-text { font-size: .72rem; font-weight: 700; color: rgba(200,150,12,.9); letter-spacing: .06em; }

    /* ── Form panel ── */
    .auth-form-panel {
        flex: 1; order: 1;
        display: flex; flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 24px;
    }
    .auth-form-wrap { width: 100%; max-width: 460px; }

    /* Mobile header */
    .mobile-header { text-align: center; margin-bottom: 28px; }
    @media (min-width: 1024px) { .mobile-header { display: none; } }
    .mobile-shield {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, var(--ju-navy), var(--ju-navy-light));
        border-radius: 14px;
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 12px;
        box-shadow: 0 6px 20px rgba(0,48,135,.25);
    }
    .form-heading {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.7rem; font-weight: 800;
        color: var(--ju-text); letter-spacing: -.01em; margin-bottom: 3px;
    }
    .form-subheading { font-size: .875rem; color: var(--ju-muted); }

    /* Card */
    .auth-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 22px;
        padding: 36px 36px 32px;
        box-shadow: var(--shadow-lg);
    }

    /* Gold accent bar */
    .card-accent {
        height: 4px;
        background: linear-gradient(90deg, var(--ju-gold), var(--ju-navy), var(--ju-gold));
        margin: -36px -36px 28px;
        border-radius: 22px 22px 0 0;
    }

    .auth-card-eyebrow {
        font-size: .65rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 4px;
    }
    .auth-card-title {
        font-size: 1.3rem; font-weight: 800;
        color: var(--ju-text); margin-bottom: 22px;
        letter-spacing: -.01em;
    }

    /* Progress steps */
    .reg-progress {
        display: flex; align-items: center; gap: 0;
        margin-bottom: 26px;
    }
    .reg-step {
        flex: 1; text-align: center;
        font-size: .68rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .06em;
        padding-bottom: 8px;
        border-bottom: 2.5px solid var(--ju-border);
        color: var(--ju-muted);
        transition: all .2s;
    }
    .reg-step.active {
        color: var(--ju-navy);
        border-bottom-color: var(--ju-navy);
    }
    .reg-step.done {
        color: var(--ju-green);
        border-bottom-color: var(--ju-green);
    }

    /* Field */
    .field-group { margin-bottom: 16px; }
    .field-label {
        display: block;
        font-size: .75rem; font-weight: 700;
        letter-spacing: .05em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 7px;
    }
    .field-label i { font-size: .8rem; margin-right: 5px; color: var(--ju-navy); }

    .field-input {
        width: 100%;
        padding: 11px 15px;
        background: var(--ju-surface);
        border: 1.5px solid var(--ju-border);
        border-radius: 11px;
        font-size: .875rem;
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
    .field-input::placeholder { color: var(--ju-muted); opacity: .4; }
    .field-hint {
        font-size: .73rem; color: var(--ju-muted); margin-top: 4px;
        display: flex; align-items: flex-start; gap: 4px; line-height: 1.4;
    }
    .field-hint i { font-size: .7rem; margin-top: 2px; flex-shrink: 0; }
    .field-error {
        font-size: .78rem; color: var(--ju-red); margin-top: 5px;
        display: flex; align-items: center; gap: 4px;
    }

    /* 2-col grid for short fields */
    .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; }

    /* Divider */
    .field-section-label {
        font-size: .65rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: var(--ju-muted);
        display: flex; align-items: center; gap: 10px;
        margin: 20px 0 14px;
    }
    .field-section-label::after {
        content: ''; flex: 1; height: 1px; background: var(--ju-border);
    }

    /* Submit */
    .btn-submit {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, var(--ju-navy-mid), var(--ju-navy-light));
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: .9rem; font-weight: 800;
        font-family: 'Inter', sans-serif;
        letter-spacing: .02em;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 6px 20px rgba(0,48,135,.3);
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-top: 20px; margin-bottom: 18px;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(0,48,135,.38);
    }
    .btn-submit:active { transform: translateY(0); }

    /* Terms note */
    .terms-note {
        font-size: .76rem; color: var(--ju-muted);
        text-align: center; line-height: 1.5; margin-bottom: 16px;
    }
    .terms-note a { color: var(--ju-navy); font-weight: 600; text-decoration: none; }
    .terms-note a:hover { text-decoration: underline; }

    /* Divider + login link */
    .auth-divider {
        display: flex; align-items: center; gap: 12px; margin-bottom: 14px;
    }
    .auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: var(--ju-border); }
    .auth-divider span { font-size: .75rem; color: var(--ju-muted); font-weight: 600; white-space: nowrap; }

    .auth-switch {
        text-align: center; font-size: .875rem; color: var(--ju-muted);
    }
    .auth-switch a { color: var(--ju-navy); font-weight: 700; text-decoration: none; transition: color .15s; }
    .auth-switch a:hover { color: var(--ju-gold-dark); text-decoration: underline; }
</style>

<div class="auth-shell">

    {{-- ── Form Panel (left on register) ── --}}
    <div class="auth-form-panel">
        <div class="auth-form-wrap">

            {{-- Mobile header --}}
            <div class="mobile-header">
                <div class="mobile-shield">
                    <svg viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:30px;height:30px">
                        <path d="M20 2L3 9V24C3 33.6 10.5 42.4 20 44C29.5 42.4 37 33.6 37 24V9L20 2Z" fill="#C8960C"/>
                        <path d="M20 7L8 12.5V24C8 31.2 13.3 37.8 20 39.5C26.7 37.8 32 31.2 32 24V12.5L20 7Z" fill="#001848"/>
                        <text x="20" y="29" text-anchor="middle" fill="#C8960C" font-size="11" font-weight="700" font-family="Georgia,serif">JU</text>
                    </svg>
                </div>
                <h2 class="form-heading">Join Campus Trade</h2>
                <p class="form-subheading">Create your Jimma University account</p>
            </div>

            <div class="auth-card">
                <div class="card-accent"></div>

                <p class="auth-card-eyebrow">Get started — it's free</p>
                <h2 class="auth-card-title">Create your account</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- ── Personal Info ── --}}
                    <p class="field-section-label">Personal Info</p>

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-user"></i>Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               required autofocus autocomplete="name"
                               class="field-input" placeholder="e.g. Kebede Alemu">
                        @error('name')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="field-grid-2">
                        <div>
                            <label class="field-label"><i class="fas fa-id-card"></i>Student ID</label>
                            <input type="text" name="student_id" value="{{ old('student_id') }}"
                                   required class="field-input" placeholder="CS1234/24">
                            @error('student_id')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field-label"><i class="fas fa-calendar-alt"></i>Grad Year</label>
                            <select name="graduation_year" class="field-input">
                                <option value="">Select</option>
                                @for($year = date('Y'); $year <= date('Y') + 6; $year++)
                                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                            @error('graduation_year')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-graduation-cap"></i>Department</label>
                        <select name="department" class="field-input">
                            <option value="">Select your department</option>
                            @foreach(['Computer Science','Engineering','Business','Law','Medicine','Natural Sciences','Social Sciences','Other'] as $dept)
                            <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('department')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                    </div>

                    {{-- ── Account Info ── --}}
                    <p class="field-section-label">Account</p>

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-envelope"></i>University Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               required autocomplete="email"
                               class="field-input" placeholder="student@ju.edu.et">
                        <p class="field-hint">
                            <i class="fas fa-info-circle" style="color:var(--ju-navy)"></i>
                            Accepted: @ju.edu.et · @uonbi.ac.ke · @aau.edu.et · @mu.edu.et
                        </p>
                        @error('email')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="field-grid-2">
                        <div>
                            <label class="field-label"><i class="fas fa-lock"></i>Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                   class="field-input" placeholder="••••••••">
                            @error('password')<p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field-label"><i class="fas fa-check-circle"></i>Confirm</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="field-input" placeholder="••••••••">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>

                    <p class="terms-note">
                        By creating an account you agree to our
                        <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                        JU student ID required for full access.
                    </p>

                    <div class="auth-divider"><span>Already a member?</span></div>

                    <div class="auth-switch">
                        Already have an account?
                        <a href="{{ route('login') }}">Sign in instead</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- ── Right Brand Panel ── --}}
    <div class="auth-brand">
        <div class="brand-shimmer"></div>
        <div class="brand-orb-top"></div>

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
            <p class="brand-eyebrow">Join Jimma University</p>
            <h1 class="brand-title">Start Trading<br><span>on Campus</span></h1>
            <p class="brand-desc">Connect with thousands of JU students. Trade textbooks, electronics, furniture and more — all within campus.</p>
        </div>

        <div class="brand-steps">
            <p class="steps-label">How it works</p>
            @foreach([
                ['01', 'Create your account',      'Sign up with your official @ju.edu.et email address'],
                ['02', 'Verify your student ID',   'Upload your JU ID to unlock full selling & messaging'],
                ['03', 'List your first item',     'Post anything — textbooks, gadgets, dorm essentials'],
                ['04', 'Meet & trade on campus',   'Arrange safe handoffs at campus landmarks'],
            ] as $s)
            <div class="step-item">
                <div class="step-num">{{ $s[0] }}</div>
                <div class="step-text">
                    <strong>{{ $s[1] }}</strong>
                    {{ $s[2] }}
                </div>
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

</div>

@endsection