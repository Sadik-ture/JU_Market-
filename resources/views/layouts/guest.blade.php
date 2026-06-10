{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html> --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Campus Trade') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --ju-navy:      #003087;
            --ju-navy-dark: #001f5e;
            --ju-navy-mid:  #0044b3;
            --ju-gold:      #C8960C;
            --ju-gold-lt:   #f0b429;
            --ju-white:     #ffffff;
            --ju-offwhite:  #f4f6fb;
            --ju-surface:   #eef1f8;
            --ju-border:    #c8d2e8;
            --ju-text:      #1a1f36;
            --ju-muted:     #5a6480;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--ju-offwhite);
            color: var(--ju-text);
            min-height: 100vh;
        }

        h1,h2,h3,h4,h5 {
            font-family: 'Crimson Pro', Georgia, serif;
            letter-spacing: -0.01em;
        }

        /* ── Auth page shell ── */
        .auth-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Gold top stripe ── */
        .auth-top-stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--ju-navy-dark) 0%, var(--ju-gold) 50%, var(--ju-navy-dark) 100%);
            flex-shrink: 0;
        }

        /* ── Thin header bar ── */
        .auth-header {
            background: var(--ju-white);
            border-bottom: 1px solid var(--ju-border);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            box-shadow: 0 1px 4px rgba(0,30,87,0.07);
        }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .auth-logo-shield {
            width: 34px; height: 34px;
            background: var(--ju-navy);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-logo-shield i { color: var(--ju-gold); font-size: 15px; }

        .auth-logo-text {
            font-family: 'Crimson Pro', serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--ju-navy-dark);
            letter-spacing: -0.02em;
        }
        .auth-logo-text span { color: var(--ju-gold); }

        .auth-logo-sub {
            display: block;
            font-size: 9.5px;
            color: var(--ju-muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: -2px;
        }

        .auth-header-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--ju-muted);
            background: var(--ju-surface);
            border: 1px solid var(--ju-border);
            border-radius: 50px;
            padding: 5px 12px;
        }
        .auth-header-badge i { color: var(--ju-gold); font-size: 11px; }

        /* ── Main body ── */
        .auth-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            background: var(--ju-offwhite);
            position: relative;
            overflow: hidden;
        }

        /* Subtle decorative background rings */
        .auth-body::before {
            content: '';
            position: absolute;
            top: -120px; left: -120px;
            width: 400px; height: 400px;
            border-radius: 50%;
            border: 60px solid rgba(0,48,135,0.04);
            pointer-events: none;
        }
        .auth-body::after {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 350px; height: 350px;
            border-radius: 50%;
            border: 50px solid rgba(200,150,12,0.05);
            pointer-events: none;
        }

        /* ── Auth card ── */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: var(--ju-white);
            border: 1px solid var(--ju-border);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,30,87,0.10);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        /* Navy top accent on card */
        .auth-card::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--ju-navy) 0%, var(--ju-gold) 100%);
        }

        .auth-card-inner {
            padding: 28px 28px 32px;
        }

        /* ── Footer ── */
        .auth-footer {
            flex-shrink: 0;
            text-align: center;
            padding: 14px;
            font-size: 12px;
            color: var(--ju-muted);
            background: var(--ju-white);
            border-top: 1px solid var(--ju-border);
        }
        .auth-footer a {
            color: var(--ju-navy);
            text-decoration: none;
            font-weight: 600;
        }
        .auth-footer a:hover { color: var(--ju-gold); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--ju-surface); }
        ::-webkit-scrollbar-thumb { background: var(--ju-navy); border-radius: 8px; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">

    <div class="auth-shell">

        <!-- Gold top stripe -->
        <div class="auth-top-stripe"></div>

        <!-- Header -->
        <div class="auth-header">
            <a href="{{ route('landing') }}" class="auth-logo">
                <div class="auth-logo-shield">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <div class="auth-logo-text">Campus<span>Trade</span></div>
                    <span class="auth-logo-sub">Jimma University</span>
                </div>
            </a>
            <div class="auth-header-badge hidden sm:flex">
                <i class="fas fa-shield-alt"></i>
                <span>Verified Students Only</span>
            </div>
        </div>

        <!-- Body -->
        <div class="auth-body">
            <div class="auth-card">
                <div class="auth-card-inner">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="auth-footer">
            &copy; {{ date('Y') }} Campus Trade &mdash; Jimma University Student Marketplace.
            <a href="{{ route('landing') }}">Back to home</a>
        </div>

    </div>

</body>
</html>
