<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Campus Trade') }} - Jimma University Campus Marketplace</title>

    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ─── JIMMA UNIVERSITY OFFICIAL PALETTE ─── */
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
            --ju-red:       #c0392b;
            --ju-green:     #2e7d32;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 15px;
            background: var(--ju-offwhite);
            color: var(--ju-text);
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Crimson Pro', Georgia, serif;
            letter-spacing: -0.01em;
        }

        /* ─── TOP UTILITY BAR ─── */
        .top-bar {
            background: var(--ju-navy-dark);
            color: rgba(255,255,255,0.75);
            font-size: 12.5px;
            padding: 6px 0;
            border-bottom: 2px solid var(--ju-gold);
        }
        .top-bar a { color: rgba(255,255,255,0.75); text-decoration: none; }
        .top-bar a:hover { color: var(--ju-gold); }

        /* ─── ANNOUNCEMENT BAR ─── */
        .announce-bar {
            background: linear-gradient(90deg, var(--ju-gold) 0%, #e8a900 100%);
            color: var(--ju-navy-dark);
            font-weight: 700;
            font-size: 13px;
            padding: 7px 0;
            text-align: center;
            letter-spacing: 0.01em;
        }

        /* ─── NAVBAR ─── */
        .ju-nav {
            background: var(--ju-navy);
            border-bottom: 3px solid var(--ju-gold);
            position: sticky;
            top: 0;
            z-index: 50;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 16px rgba(0,30,87,0.25);
        }

        .ju-nav .logo-text {
            font-family: 'Crimson Pro', serif;
            font-weight: 700;
            font-size: 22px;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .ju-nav .logo-text span { color: var(--ju-gold); }
        .ju-nav .logo-sub {
            font-size: 10px;
            color: rgba(255,255,255,0.55);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            display: block;
            margin-top: -2px;
        }

        .logo-shield {
            width: 38px; height: 38px;
            background: var(--ju-gold);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            transition: transform 0.3s;
            flex-shrink: 0;
        }
        .logo-shield i { color: var(--ju-navy); font-size: 17px; }
        .logo-shield:hover { transform: scale(1.08) rotate(-3deg); }

        .nav-link {
            color: rgba(255,255,255,0.85);
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.01em;
            text-decoration: none;
            position: relative;
            padding-bottom: 2px;
            transition: color 0.2s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px; left: 0;
            width: 0; height: 2px;
            background: var(--ju-gold);
            border-radius: 2px;
            transition: width 0.25s;
        }
        .nav-link:hover { color: var(--ju-gold); }
        .nav-link:hover::after { width: 100%; }

        /* ─── SEARCH BAR ─── */
        .search-wrap {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            display: flex; align-items: center;
            padding: 5px 8px 5px 16px;
            transition: all 0.25s;
        }
        .search-wrap:focus-within {
            background: rgba(255,255,255,0.18);
            border-color: var(--ju-gold);
            box-shadow: 0 0 0 3px rgba(200,150,12,0.2);
        }
        .search-wrap input {
            background: transparent;
            border: none; outline: none;
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 14px;
            width: 100%;
        }
        .search-wrap input::placeholder { color: rgba(255,255,255,0.5); }
        .search-wrap .search-btn {
            background: var(--ju-gold);
            color: var(--ju-navy-dark);
            border: none; border-radius: 50px;
            padding: 5px 16px;
            font-weight: 700; font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .search-wrap .search-btn:hover {
            background: var(--ju-gold-lt);
            transform: translateY(-1px);
        }

        /* ─── BUTTONS ─── */
        .btn-primary {
            background: var(--ju-gold);
            color: var(--ju-navy-dark);
            font-weight: 700;
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 13.5px;
            border: none; cursor: pointer;
            transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(200,150,12,0.3);
        }
        .btn-primary:hover {
            background: var(--ju-gold-lt);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(200,150,12,0.4);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.4);
            color: rgba(255,255,255,0.85);
            border-radius: 50px;
            padding: 7px 18px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
        }
        .btn-outline:hover {
            border-color: var(--ju-gold);
            color: var(--ju-gold);
        }

        /* ─── USER AVATAR TRIGGER ─── */
        .user-avatar {
            width: 36px; height: 36px;
            background: var(--ju-gold);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--ju-navy-dark);
            font-weight: 800;
            font-size: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(200,150,12,0.35);
        }

        /* ─── PROFILE SLIDE PANEL ─── */
        .pp-overlay {
            position: fixed; inset: 0;
            background: rgba(0, 20, 60, 0.55);
            backdrop-filter: blur(4px);
            opacity: 0; pointer-events: none;
            transition: opacity .3s; z-index: 200;
        }
        .pp-overlay.show { opacity: 1; pointer-events: all; }

        .pp-panel {
            position: fixed; right: 0; top: 0; height: 100%;
            width: 320px; background: #fff; z-index: 300;
            transform: translateX(100%);
            transition: transform .35s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column; overflow: hidden;
            border-left: 1px solid var(--ju-border);
            box-shadow: -8px 0 40px rgba(0,20,87,0.18);
        }
        .pp-panel.open { transform: translateX(0); }

        .pp-head {
            background: var(--ju-navy-dark);
            position: relative; overflow: hidden; flex-shrink: 0;
        }
        .pp-head::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--ju-gold), var(--ju-gold-lt), var(--ju-gold));
        }
        .pp-head-inner { padding: 28px 20px 24px; }

        .pp-close {
            position: absolute; top: 12px; right: 12px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7); border-radius: 8px;
            width: 30px; height: 30px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; transition: all .2s;
        }
        .pp-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

        .pp-avatar-ring {
            width: 60px; height: 60px; border-radius: 50%;
            background: var(--ju-gold);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Crimson Pro', serif; font-weight: 700;
            font-size: 24px; color: var(--ju-navy-dark);
            border: 3px solid rgba(255,255,255,0.2);
            margin-bottom: 12px;
        }
        .pp-name {
            color: #fff; font-family: 'Crimson Pro', serif;
            font-weight: 700; font-size: 19px; line-height: 1.2;
        }
        .pp-email { color: rgba(255,255,255,0.5); font-size: 12px; margin-top: 3px; }
        .pp-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px; }
        .pp-badge {
            font-size: 10.5px; font-weight: 700; padding: 3px 10px; border-radius: 50px;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .pp-badge-gold {
            background: rgba(200,150,12,0.2); color: var(--ju-gold-lt);
            border: 1px solid rgba(200,150,12,0.3);
        }
        .pp-badge-green {
            background: rgba(74,222,128,0.15); color: #2e7d32;
            border: 1px solid rgba(74,222,128,0.25);
        }

        .pp-body { flex: 1; overflow-y: auto; padding: 10px 0; }
        .pp-body::-webkit-scrollbar { width: 4px; }
        .pp-body::-webkit-scrollbar-thumb { background: var(--ju-border); border-radius: 4px; }

        .pp-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: var(--ju-muted); padding: 12px 20px 4px;
        }

        .pp-item {
            display: flex; align-items: center; gap: 12px; padding: 11px 20px;
            color: var(--ju-text); font-size: 13.5px; text-decoration: none;
            transition: background .15s; position: relative;
            border: none; background: none; width: 100%; text-align: left; cursor: pointer;
        }
        .pp-item:hover { background: var(--ju-surface); color: var(--ju-navy); }

        .pp-icon {
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 14px; transition: transform .2s;
        }
        .pp-item:hover .pp-icon { transform: translateX(2px); }
        .pp-label { flex: 1; font-weight: 600; }
        .pp-meta {
            font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 50px;
        }
        .pp-divider { height: 1px; background: var(--ju-border); margin: 6px 0; }

        /* Icon colour presets */
        .ic-blue   { background: #eff6ff; color: #1d4ed8; }
        .ic-navy   { background: #eef2fb; color: var(--ju-navy); }
        .ic-purple { background: #faf5ff; color: #7c3aed; }
        .ic-green  { background: #f0fdf4; color: #166534; }

        .pp-item.admin-item .pp-icon { background: #eef2fb; color: var(--ju-navy-dark); }
        .pp-item.admin-item:hover     { background: #eef2fb; }
        .pp-item.admin-item:hover .pp-icon { background: var(--ju-navy); color: #fff; }

        .pp-foot {
            flex-shrink: 0; padding: 12px 20px 24px;
            border-top: 1px solid var(--ju-border);
        }
        .pp-logout {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px; border-radius: 10px;
            border: 1.5px solid #fecaca; background: #fff;
            color: var(--ju-red); font-size: 13.5px; font-weight: 700;
            cursor: pointer; transition: all .2s;
        }
        .pp-logout:hover { background: #fef2f2; border-color: #f87171; }

        /* ─── PRODUCT CARDS ─── */
        .product-card {
            background: #fff;
            border: 1px solid var(--ju-border);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0,30,87,0.14);
            border-color: var(--ju-navy);
        }
        .product-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 3px;
            background: linear-gradient(90deg, var(--ju-navy), var(--ju-gold));
            transition: width 0.4s;
        }
        .product-card:hover::after { width: 100%; }

        .product-image {
            width: 100%; height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
            background: var(--ju-surface);
        }
        .product-card:hover .product-image { transform: scale(1.05); }

        /* ─── CATEGORY CARD ─── */
        .category-card {
            background: #fff;
            border: 1px solid var(--ju-border);
            border-radius: 10px;
            transition: all 0.3s;
        }
        .category-card:hover {
            background: var(--ju-navy);
            border-color: var(--ju-navy);
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,30,87,0.2);
        }
        .category-card:hover * { color: #fff !important; }

        /* ─── BADGES ─── */
        .badge {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 3px 9px;
            border-radius: 50px;
        }
        .badge-hot      { background: var(--ju-red); color: #fff; }
        .badge-verified { background: var(--ju-navy); color: var(--ju-gold); }
        .badge-sold     { background: var(--ju-surface); color: var(--ju-muted); }
        .badge-new      { background: var(--ju-gold); color: var(--ju-navy-dark); }

        /* ─── CARDS (generic) ─── */
        .card-light {
            background: #fff;
            border: 1px solid var(--ju-border);
            border-radius: 10px;
            transition: all 0.3s;
        }
        .card-light:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,30,87,0.12);
            border-color: var(--ju-navy);
        }

        /* ─── SKELETON SHIMMER ─── */
        .image-skeleton {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, var(--ju-surface) 25%, #dce3f2 50%, var(--ju-surface) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .image-container { position: relative; overflow: hidden; background: var(--ju-surface); }

        /* ─── TOAST ─── */
        .toast-notification {
            position: fixed; bottom: 20px; right: 20px;
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(80px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ─── SCROLL BAR ─── */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--ju-surface); }
        ::-webkit-scrollbar-thumb { background: var(--ju-navy); border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--ju-navy-mid); }

        /* ─── FLOATING ANIMATION ─── */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-6px); }
        }
        .floating { animation: float 3s ease-in-out infinite; }

        /* ─── SPINNER ─── */
        .spinner {
            width: 36px; height: 36px;
            border: 3px solid var(--ju-border);
            border-top-color: var(--ju-navy);
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ─── MODAL ─── */
        .modal-overlay { background: rgba(0,20,60,0.75); backdrop-filter: blur(6px); }

        /* ─── FOOTER ─── */
        .ju-footer {
            background: var(--ju-navy-dark);
            color: rgba(255,255,255,0.75);
            border-top: 3px solid var(--ju-gold);
        }
        .ju-footer h4 {
            font-family: 'Crimson Pro', serif;
            color: #fff; font-size: 18px; margin-bottom: 16px;
        }
        .ju-footer a {
            color: rgba(255,255,255,0.65); text-decoration: none;
            font-size: 13.5px; transition: color 0.2s;
            display: flex; align-items: center; gap: 8px;
        }
        .ju-footer a:hover { color: var(--ju-gold); }
        .ju-footer a i { color: var(--ju-gold); font-size: 11px; }

        .social-btn {
            width: 34px; height: 34px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.7); text-decoration: none;
            transition: all 0.25s;
        }
        .social-btn:hover { background: var(--ju-gold); color: var(--ju-navy-dark); }

        /* ─── MOBILE MENU ─── */
        #mobileMenu a {
            color: rgba(255,255,255,0.8);
            display: block; padding: 10px 0;
            font-size: 14px; font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-decoration: none;
        }
        #mobileMenu a:hover { color: var(--ju-gold); }

        /* ─── HERO ─── */
        .hero-section { position: relative; overflow: hidden; }
        .hero-section::before {
            content: '';
            position: absolute; top: -40%; right: -15%;
            width: 70%; height: 200%;
            background: radial-gradient(circle, rgba(200,150,12,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ─── PROGRESS BAR ─── */
        .progress-bar { transition: width 1s ease-out; }

        [data-aos] { color: inherit !important; }
        
        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .pp-panel { width: 85%; }
            .search-wrap input { font-size: 12px; }
            .btn-primary, .btn-outline { padding: 5px 12px; font-size: 11px; }
        }
    </style>
</head>
<body>

    <!-- ══ ANNOUNCEMENT BAR ══ -->
    <div class="announce-bar">
        <i class="fas fa-graduation-cap mr-2"></i>
        Sell textbooks, electronics &amp; more — Join 1,500+ active JU students already trading!
        <i class="fas fa-long-arrow-alt-right ml-2"></i>
    </div>

    <!-- ══ TOP UTILITY BAR ══ -->
    <div class="top-bar">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="hidden md:flex items-center gap-6">
                <span><i class="fas fa-shield-alt mr-1.5" style="color:var(--ju-gold)"></i> Secure Payments</span>
                <span><i class="fas fa-truck mr-1.5" style="color:var(--ju-gold)"></i> Campus Delivery</span>
                <span><i class="fas fa-id-badge mr-1.5" style="color:var(--ju-gold)"></i> Verified Students Only</span>
            </div>
            <div class="flex items-center gap-5">
                <span><i class="fas fa-headset mr-1" style="color:var(--ju-gold)"></i> 24/7 Support</span>
                <span class="floating"><i class="fas fa-users mr-1" style="color:var(--ju-gold)"></i> 1,500+ Active</span>
                <span><i class="fas fa-star mr-1" style="color:var(--ju-gold)"></i> 4.9 Rating</span>
            </div>
        </div>
    </div>

    <!-- ══ NAVIGATION ══ -->
    <nav class="ju-nav" id="mainNav">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center" style="height:64px">

                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3" style="text-decoration:none">
                    <div class="logo-shield">
                        <i class="fas fa-university"></i>
                    </div>
                    <div>
                        <div class="logo-text">Campus<span>Trade</span></div>
                        <span class="logo-sub">Jimma University</span>
                    </div>
                </a>

                <!-- Desktop Search -->
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <div class="search-wrap w-full">
                        <i class="fas fa-search mr-3" style="color:rgba(255,255,255,0.45);font-size:13px"></i>
                        <input type="text" id="searchInput" placeholder="Search textbooks, electronics, furniture…">
                        <button class="search-btn ml-2">Search</button>
                    </div>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('landing') }}" class="nav-link">Home</a>
                    <a href="{{ route('listings.index') }}" class="nav-link">Marketplace</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        <a href="{{ route('messages.index') }}" class="nav-link" style="position:relative">
                            Messages
                            @php $unread = auth()->user()->unreadMessagesCount(); @endphp
                            @if($unread > 0)
                                <span style="position:absolute;top:-8px;right:-14px;background:var(--ju-red);color:#fff;font-size:10px;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-weight:800;animation:pulse 1.5s infinite">{{ $unread }}</span>
                            @endif
                        </a>
                        <a href="{{ route('favorites.index') }}" class="nav-link" style="position:relative">
                            <i class="fas fa-heart" style="color:#e74c3c"></i> Saved
                            @php $favCount = auth()->user()->favoriteListings()->count(); @endphp
                            @if($favCount > 0)
                                <span style="position:absolute;top:-8px;right:-14px;background:var(--ju-red);color:#fff;font-size:10px;border-radius:50%;width:16px;height:16px;display:flex;align-items:center;justify-content:center;font-weight:800">{{ $favCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('payment.history') }}" class="nav-link">Transactions</a>
                    @endauth
                </div>

                <!-- Auth Actions -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('listings.create') }}" class="btn-primary hidden sm:inline-flex" style="font-size:13px;padding:7px 16px">
                            <i class="fas fa-plus-circle"></i> Sell Item
                        </a>

                        <!-- Avatar — triggers slide panel -->
                        <button
                            onclick="openProfilePanel()"
                            style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px"
                            aria-label="Open profile menu">
                            <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            <i id="profileChevron" class="fas fa-chevron-down"
                               style="color:rgba(255,255,255,0.5);font-size:11px;transition:transform .25s"></i>
                        </button>
                    @else
                        <a href="{{ route('login') }}"    class="btn-outline"  style="font-size:13px;padding:6px 16px">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary"  style="font-size:13px;padding:7px 16px">Sign Up Free</a>
                    @endauth

                    <button id="mobileMenuBtn" class="lg:hidden"
                            style="background:none;border:none;color:rgba(255,255,255,0.75);font-size:20px;cursor:pointer;padding:4px">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="md:hidden pb-3" style="border-top:1px solid rgba(255,255,255,0.1);padding-top:10px">
                <div class="search-wrap w-full">
                    <i class="fas fa-search mr-2" style="color:rgba(255,255,255,0.4);font-size:13px"></i>
                    <input type="text" placeholder="Search products…">
                    <button class="search-btn ml-2">Go</button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden lg:hidden pb-4" style="border-top:1px solid rgba(255,255,255,0.1);margin-top:4px">
                <a href="{{ route('landing') }}">Home</a>
                <a href="{{ route('listings.index') }}">Marketplace</a>
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('messages.index') }}">Messages</a>
                    <a href="{{ route('favorites.index') }}">Saved Items</a>
                    <a href="{{ route('payment.history') }}">Transactions</a>
                    <a href="{{ route('listings.create') }}" style="color:var(--ju-gold)!important">+ Sell Item</a>
                    <a href="{{ route('id-verification.show') }}">Verify ID</a>
                    @if(Auth::user()->is_admin == 1)
                        <div style="padding:8px 0 4px;font-size:10px;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-top:6px;border-top:1px solid rgba(255,255,255,0.1)">
                            <i class="fas fa-shield-alt mr-1"></i> Admin
                        </div>
                        <a href="{{ route('admin.dashboard') }}"  style="color:#c084fc!important">Dashboard</a>
                        <a href="{{ route('admin.users') }}">Users</a>
                        <a href="{{ route('admin.listings') }}">Listings</a>
                        <a href="{{ route('admin.payments') }}">Payments</a>
                        <a href="{{ route('admin.ratings') }}">Ratings</a>
                        <a href="{{ route('admin.top-sellers') }}">Top Sellers</a>
                        <a href="{{ route('admin.pending-ids') }}">Pending IDs</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" style="color:var(--ju-gold)!important">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ══ MAIN CONTENT ══ -->
    <main>
        @yield('content')
    </main>

    <!-- ══ FOOTER ══ -->
    <footer class="ju-footer" style="margin-top:80px">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                <!-- Brand -->
                <div data-aos="fade-up">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="logo-shield" style="width:40px;height:40px">
                            <i class="fas fa-university" style="font-size:18px"></i>
                        </div>
                        <div class="logo-text" style="font-size:20px">Campus<span>Trade</span></div>
                    </div>
                    <p style="font-size:13.5px;line-height:1.7;color:rgba(255,255,255,0.6)">
                        The #1 marketplace for Ethiopian university students. Buy, sell, and trade with confidence on campus.
                    </p>
                    <div class="flex gap-2 mt-4">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"  style="font-size:13px"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"     style="font-size:13px"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"   style="font-size:13px"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-telegram"    style="font-size:13px"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <h4>Quick Links</h4>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:9px">
                        <li><a href="{{ route('landing') }}"><i class="fas fa-chevron-right"></i>Home</a></li>
                        <li><a href="{{ route('listings.index') }}"><i class="fas fa-chevron-right"></i>Marketplace</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i>How It Works</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i>Safety Tips</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <h4>Categories</h4>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:9px">
                        <li><a href="{{ route('listings.index', ['category'=>'Electronics']) }}"><i class="fas fa-chevron-right"></i>Electronics</a></li>
                        <li><a href="{{ route('listings.index', ['category'=>'Textbooks']) }}"><i class="fas fa-chevron-right"></i>Textbooks</a></li>
                        <li><a href="{{ route('listings.index', ['category'=>'Furniture']) }}"><i class="fas fa-chevron-right"></i>Furniture</a></li>
                        <li><a href="{{ route('listings.index', ['category'=>'Clothing']) }}"><i class="fas fa-chevron-right"></i>Clothing</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact</h4>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;font-size:13.5px">
                        <li style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.65)">
                            <i class="fas fa-envelope" style="color:var(--ju-gold);width:16px"></i> support@campustrade.com
                        </li>
                        <li style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.65)">
                            <i class="fas fa-phone" style="color:var(--ju-gold);width:16px"></i> +251-911-XXXXXX
                        </li>
                        <li style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.65)">
                            <i class="fas fa-map-marker-alt" style="color:var(--ju-gold);width:16px"></i> Ethiopian Universities
                        </li>
                    </ul>
                    <div style="margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,0.1);display:flex;flex-direction:column;gap:8px">
                        <div style="display:flex;align-items:center;gap:8px;font-size:12.5px;color:rgba(255,255,255,0.6)">
                            <i class="fas fa-check-circle" style="color:#4ade80"></i> 100% Secure Payments
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:12.5px;color:rgba(255,255,255,0.6)">
                            <i class="fas fa-shield-alt" style="color:var(--ju-gold)"></i> Verified Students Only
                        </div>
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,0.1);margin-top:40px;padding-top:20px;text-align:center;font-size:13px;color:rgba(255,255,255,0.4)">
                &copy; {{ date('Y') }} Campus Trade &mdash; Jimma University Student Marketplace.
                Made with <i class="fas fa-heart" style="color:var(--ju-red)"></i> for Ethiopian students.
            </div>
        </div>
    </footer>

    <!-- ══════════════════════════════════════════════
         PROFILE SLIDE PANEL  (replaces dropdown)
    ══════════════════════════════════════════════ -->
    @auth

    {{-- Blurred overlay --}}
    <div class="pp-overlay" id="ppOverlay" onclick="closeProfilePanel()"></div>

    {{-- The panel itself --}}
    <div class="pp-panel" id="ppPanel" role="dialog" aria-modal="true" aria-label="Profile menu">

        {{-- ── Header ── --}}
        <div class="pp-head">
            <button class="pp-close" onclick="closeProfilePanel()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="pp-head-inner">
                <div class="pp-avatar-ring">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="pp-name">{{ Auth::user()->name }}</div>
                <div class="pp-email">{{ Auth::user()->email }}</div>
                <div class="pp-badges">
                    @if(Auth::user()->is_verified_seller)
                        <span class="pp-badge pp-badge-gold">
                            <i class="fas fa-check-circle"></i> Verified Seller
                        </span>
                    @endif
                    @if(Auth::user()->id_verification_status === 'approved')
                        <span class="pp-badge pp-badge-green">
                            <i class="fas fa-id-card"></i> ID Verified
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Body ── --}}
        <div class="pp-body">

            <div class="pp-section-label">My Account</div>

            <a href="{{ route('profile.edit') }}" class="pp-item">
                <div class="pp-icon ic-blue"><i class="fas fa-user-circle"></i></div>
                <span class="pp-label">My Profile</span>
            </a>

            <a href="{{ route('listings.create') }}" class="pp-item">
                <div class="pp-icon ic-navy"><i class="fas fa-plus-circle"></i></div>
                <span class="pp-label">Sell an Item</span>
            </a>

            <a href="{{ route('payment.history') }}" class="pp-item">
                <div class="pp-icon ic-purple"><i class="fas fa-receipt"></i></div>
                <span class="pp-label">Transactions</span>
            </a>

            <a href="{{ route('id-verification.show') }}" class="pp-item">
                <div class="pp-icon ic-green"><i class="fas fa-id-card"></i></div>
                <span class="pp-label">ID Verification</span>
                @if(Auth::user()->id_verification_status === 'approved')
                    <span class="pp-meta" style="background:#dcfce7;color:#166534">Verified</span>
                @elseif(Auth::user()->id_verification_status === 'pending')
                    <span class="pp-meta" style="background:#fef3c7;color:#92400e">Pending</span>
                @endif
            </a>

            {{-- ── Admin section ── --}}
            @if(Auth::user()->is_admin == 1)
                <div class="pp-divider"></div>
                <div class="pp-section-label">
                    <i class="fas fa-shield-alt mr-1"></i> Admin Panel
                </div>

                <a href="{{ route('admin.dashboard') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-chart-line"></i></div>
                    <span class="pp-label">Dashboard</span>
                </a>

                <a href="{{ route('admin.users') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-users"></i></div>
                    <span class="pp-label">User Management</span>
                </a>

                <a href="{{ route('admin.listings') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-boxes"></i></div>
                    <span class="pp-label">Listings</span>
                </a>

                <a href="{{ route('admin.payments') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-credit-card"></i></div>
                    <span class="pp-label">Payments</span>
                </a>

                <a href="{{ route('admin.ratings') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-star" style="color:var(--ju-gold)"></i></div>
                    <span class="pp-label">Ratings</span>
                </a>

                <a href="{{ route('admin.top-sellers') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-trophy" style="color:var(--ju-gold)"></i></div>
                    <span class="pp-label">Top Sellers</span>
                </a>

                <a href="{{ route('admin.pending-ids') }}" class="pp-item admin-item">
                    <div class="pp-icon"><i class="fas fa-id-card"></i></div>
                    <span class="pp-label">Pending IDs</span>
                    @php $pendingCount = \App\Models\User::where('id_verification_status','pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="pp-meta" style="background:var(--ju-gold);color:var(--ju-navy-dark)">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endif

        </div>{{-- /pp-body --}}

        {{-- ── Footer / Logout ── --}}
        <div class="pp-foot">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="pp-logout">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>

    </div>{{-- /pp-panel --}}
    @endauth

    <!-- ══ SCRIPTS ══ -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, once: true, offset: 80 });

        /* ── Mobile Menu ── */
        const mobileBtn  = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }

        /* ── Hide nav on scroll-down, reveal on scroll-up ── */
        let lastScroll = 0;
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            const current = window.scrollY;
            nav.style.transform = (current > 100 && current > lastScroll) ? 'translateY(-100%)' : 'translateY(0)';
            lastScroll = current;
        });

        /* ── Lazy-load images ── */
        const imgObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.getAttribute('data-src');
                    if (src) { img.src = src; img.removeAttribute('data-src'); }
                    obs.unobserve(img);
                }
            });
        });
        document.querySelectorAll('.lazy-image').forEach(img => imgObserver.observe(img));

        /* ── Search on Enter ── */
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', e => {
                if (e.key === 'Enter')
                    window.location.href = '/marketplace?search=' + encodeURIComponent(e.target.value);
            });
        }

        /* ── Profile Panel ── */
        function openProfilePanel() {
            document.getElementById('ppPanel').classList.add('open');
            document.getElementById('ppOverlay').classList.add('show');
            const ch = document.getElementById('profileChevron');
            if (ch) ch.style.transform = 'rotate(180deg)';
            document.body.style.overflow = 'hidden';
        }
        function closeProfilePanel() {
            document.getElementById('ppPanel').classList.remove('open');
            document.getElementById('ppOverlay').classList.remove('show');
            const ch = document.getElementById('profileChevron');
            if (ch) ch.style.transform = '';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeProfilePanel(); });

        /* ── Toast ── */
        function showToast(message, type = 'success') {
            const t = document.createElement('div');
            t.className = 'toast-notification';
            t.style.cssText = 'background:#fff;border-left:4px solid var(--ju-navy);border-radius:8px;box-shadow:0 8px 30px rgba(0,30,87,0.15);padding:14px 18px;display:flex;align-items:center;gap:12px;min-width:260px';
            t.innerHTML = `<i class="fas ${type==='success'?'fa-check-circle':'fa-exclamation-circle'}" style="color:${type==='success'?'var(--ju-navy)':'var(--ju-red)'};font-size:18px"></i><span style="color:var(--ju-text);font-size:14px">${message}</span>`;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }

        /* ── Smooth Scroll ── */
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const href = a.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        /* ── Admin modal helpers ── */
        function showModal(msg) {
            const m = document.getElementById('userModal'), c = document.getElementById('modalContent');
            if (m && c) { c.innerHTML = `<p style="color:var(--ju-muted)">${msg.replace(/\n/g,'<br>')}</p>`; m.classList.remove('hidden'); m.style.display='flex'; }
        }
        function closeModal()      { const m=document.getElementById('userModal');   if(m){m.classList.add('hidden');m.style.display='none';} }
        function viewUser(id)      { window.location.href=`/admin/users?search=${id}`; }
        function viewListing(id)   { window.location.href=`/listings/${id}`; }
        function viewPayment(id)   { window.location.href=`/admin/payments`; }
        function refreshDashboard(){ location.reload(); }

        /* ── ID modal helpers ── */
        function showIDModal(url, name) {
            const m=document.getElementById('idModal'), img=document.getElementById('idImage'), t=document.getElementById('modalTitle');
            if(m&&img&&t){img.src=url;t.innerText=name+"'s ID Card";m.classList.remove('hidden');m.style.display='flex';}
        }
        function closeIDModal() { const m=document.getElementById('idModal'); if(m){m.classList.add('hidden');m.style.display='none';} }
        function showRejectModal(uid,uname) {
            const m=document.getElementById('rejectModal'), f=document.getElementById('rejectForm');
            if(m&&f){f.action='/admin/users/'+uid+'/reject-id';m.classList.remove('hidden');m.style.display='flex';}
        }
        function closeRejectModal() { const m=document.getElementById('rejectModal'); if(m){m.classList.add('hidden');m.style.display='none';} }
    </script>
</body>
</html>