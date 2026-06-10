@extends('layouts.app-new')

@section('content')

{{-- ============================================================
     CAMPUS TRADE — User Dashboard
     Jimma University Official Brand
     Colors: #003087 (JU Navy), #C8960C (JU Gold), #001f5e (Deep Navy)
     ============================================================ --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap');

    :root {
        --ju-navy:        #003087;
        --ju-navy-dark:   #001f5e;
        --ju-navy-mid:    #012575;
        --ju-navy-light:  #0a4aad;
        --ju-gold:        #C8960C;
        --ju-gold-light:  #e8b020;
        --ju-gold-pale:   #fdf3d8;
        --ju-gold-dark:   #a37a09;
        --ju-red:         #c0392b;
        --ju-green:       #1a7a3c;
        --ju-green-light: #e8f7ee;
        --ju-purple:      #6d28d9;
        --ju-surface:     #f0f2f8;
        --ju-surface-2:   #e8ebf5;
        --ju-card:        #ffffff;
        --ju-border:      #dde3f0;
        --ju-border-soft: #eef1f9;
        --ju-muted:       #6b7494;
        --ju-muted-light: #9ba3bf;
        --ju-text:        #111827;
        --ju-text-2:      #374151;
        --shadow-sm: 0 2px 8px rgba(0,30,100,.08), 0 1px 3px rgba(0,0,0,.04);
        --shadow-md: 0 6px 24px rgba(0,30,100,.11), 0 2px 8px rgba(0,0,0,.05);
        --shadow-lg: 0 16px 48px rgba(0,30,100,.14), 0 4px 16px rgba(0,0,0,.06);
    }

    * { box-sizing: border-box; }
    body {
        background: var(--ju-surface);
        color: var(--ju-text);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    /* ═══════════════════════════
       HERO BANNER
    ═══════════════════════════ */
    .ju-hero {
        position: relative;
        background: linear-gradient(135deg, #000d2e 0%, #001848 40%, #002678 75%, #003087 100%);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 28px;
        border: 1px solid rgba(200,150,12,.18);
    }
    .ju-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(200,150,12,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(200,150,12,.04) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
    }
    .ju-hero::after {
        content: '';
        position: absolute;
        top: -50%; left: -60%;
        width: 50%; height: 200%;
        background: linear-gradient(105deg, transparent 40%, rgba(200,150,12,.07) 50%, transparent 60%);
        animation: heroShimmer 6s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes heroShimmer { 0% { left: -60%; } 100% { left: 130%; } }

    .ju-hero-inner {
        position: relative; z-index: 2;
        padding: 28px 32px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    @media (min-width: 640px) {
        .ju-hero-inner { flex-direction: row; align-items: center; justify-content: space-between; }
    }

    .ju-shield-wrap {
        width: 56px; height: 56px; border-radius: 16px;
        background: linear-gradient(145deg, rgba(200,150,12,.22), rgba(200,150,12,.08));
        border: 1px solid rgba(200,150,12,.35);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(200,150,12,.15), inset 0 1px 0 rgba(255,255,255,.1);
    }

    .hero-eyebrow {
        font-size: .68rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: #C8960C; margin-bottom: 4px; opacity: .9;
    }
    .hero-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.7rem; font-weight: 800;
        color: #fff; line-height: 1.2; letter-spacing: -.01em;
    }
    .hero-sub {
        font-size: .875rem; color: rgba(255,255,255,.55); margin-top: 3px;
    }
    .hero-sub strong { color: #e8c04a; font-weight: 600; }

    /* Action buttons in hero */
    .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }
    .btn-hero {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 20px; border-radius: 11px;
        font-size: .83rem; font-weight: 800;
        text-decoration: none; border: none; cursor: pointer;
        transition: transform .2s, box-shadow .2s, opacity .2s;
        white-space: nowrap;
    }
    .btn-hero:hover { transform: translateY(-2px); }
    .btn-hero.green {
        background: linear-gradient(135deg, #1a7a3c, #22a04e);
        color: #fff;
        box-shadow: 0 4px 16px rgba(26,122,60,.35);
    }
    .btn-hero.green:hover { box-shadow: 0 8px 24px rgba(26,122,60,.45); }
    .btn-hero.navy {
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.18);
        color: #fff;
        backdrop-filter: blur(8px);
    }
    .btn-hero.navy:hover { background: rgba(255,255,255,.16); }

    /* ═══════════════════════════
       STAT CARDS
    ═══════════════════════════ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 16px; margin-bottom: 28px;
    }
    @media (min-width: 640px)  { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .stat-grid { grid-template-columns: repeat(4, 1fr); } }

    .stat-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 18px;
        padding: 20px 20px 16px;
        box-shadow: var(--shadow-sm);
        cursor: default;
        position: relative; overflow: hidden;
        transition: box-shadow .25s, transform .25s;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 4px; border-radius: 18px 18px 0 0;
    }
    .stat-card.c-navy::before  { background: linear-gradient(90deg, var(--ju-navy), var(--ju-navy-light)); }
    .stat-card.c-green::before { background: linear-gradient(90deg, var(--ju-green), #2ecc71); }
    .stat-card.c-gold::before  { background: linear-gradient(90deg, var(--ju-gold-dark), var(--ju-gold-light)); }
    .stat-card.c-red::before   { background: linear-gradient(90deg, var(--ju-red), #e74c3c); }

    .stat-icon {
        position: absolute; top: 18px; right: 18px;
        width: 42px; height: 42px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
    }
    .stat-icon.navy  { background: rgba(0,48,135,.08);  color: var(--ju-navy); }
    .stat-icon.green { background: rgba(26,122,60,.1);  color: var(--ju-green); }
    .stat-icon.gold  { background: rgba(200,150,12,.1); color: var(--ju-gold-dark); }
    .stat-icon.red   { background: rgba(192,57,43,.1);  color: var(--ju-red); }

    .stat-label {
        font-size: .68rem; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 8px;
    }
    .stat-value {
        font-size: 2rem; font-weight: 800;
        color: var(--ju-text); line-height: 1;
        letter-spacing: -.02em; margin-bottom: 10px;
        font-variant-numeric: tabular-nums;
    }
    .stat-tag {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: .72rem; font-weight: 700;
        padding: 3px 8px; border-radius: 99px;
    }
    .stat-tag.green { background: var(--ju-green-light); color: var(--ju-green); }
    .stat-tag.gold  { background: rgba(200,150,12,.1);    color: var(--ju-gold-dark); }
    .stat-tag.red   { background: rgba(192,57,43,.08);    color: var(--ju-red); }
    .stat-tag.navy  { background: rgba(0,48,135,.08);     color: var(--ju-navy); }

    /* ═══════════════════════════
       GENERIC CARD
    ═══════════════════════════ */
    .ju-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
    }
    .ju-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--ju-border-soft);
        display: flex; align-items: center; justify-content: space-between;
        background: #f8f9fd;
        border-radius: 18px 18px 0 0;
    }
    .card-icon {
        width: 38px; height: 38px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem; flex-shrink: 0;
    }
    .card-icon.navy   { background: rgba(0,48,135,.08);  color: var(--ju-navy); }
    .card-icon.green  { background: rgba(26,122,60,.1);  color: var(--ju-green); }
    .card-icon.red    { background: rgba(192,57,43,.1);  color: var(--ju-red); }
    .card-icon.purple { background: rgba(109,40,217,.1); color: var(--ju-purple); }

    .card-title   { font-size: .95rem; font-weight: 800; color: var(--ju-text); }
    .card-subtitle { font-size: .75rem; color: var(--ju-muted); margin-top: 2px; }

    .card-count-pill {
        font-size: .68rem; font-weight: 800;
        background: rgba(0,48,135,.08); color: var(--ju-navy);
        padding: 3px 10px; border-radius: 99px;
    }

    .view-all-link {
        font-size: .8rem; font-weight: 700;
        color: var(--ju-navy); text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
        transition: gap .2s, color .15s;
    }
    .view-all-link:hover { gap: 8px; color: var(--ju-gold-dark); }

    /* ═══════════════════════════
       LISTING ROWS
    ═══════════════════════════ */
    .listing-row {
        padding: 16px 24px;
        border-bottom: 1px solid var(--ju-border-soft);
        display: flex; flex-direction: column; gap: 14px;
        transition: background .15s; cursor: pointer;
    }
    .listing-row:last-of-type { border-bottom: none; }
    .listing-row:hover { background: #f5f7fd; }
    @media (min-width: 640px) {
        .listing-row { flex-direction: row; align-items: center; justify-content: space-between; }
    }

    .listing-thumb {
        width: 60px; height: 60px; object-fit: cover;
        border-radius: 12px; border: 1px solid var(--ju-border);
        flex-shrink: 0;
    }
    .listing-thumb-empty {
        width: 60px; height: 60px; border-radius: 12px;
        background: var(--ju-surface); display: flex;
        align-items: center; justify-content: center;
        border: 1px solid var(--ju-border); flex-shrink: 0;
        color: var(--ju-muted-light); font-size: 1.1rem;
    }

    .listing-name {
        font-size: .9rem; font-weight: 700;
        color: var(--ju-text); margin-bottom: 6px;
        transition: color .15s;
    }
    .listing-row:hover .listing-name { color: var(--ju-navy); }

    /* Inline pills */
    .pill-sm {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 99px;
        font-size: .68rem; font-weight: 800;
        letter-spacing: .03em;
    }
    .pill-sm.navy   { background: rgba(0,48,135,.08);   color: var(--ju-navy); }
    .pill-sm.green  { background: rgba(26,122,60,.1);   color: var(--ju-green); }
    .pill-sm.gold   { background: rgba(200,150,12,.1);  color: var(--ju-gold-dark); }
    .pill-sm.muted  { background: rgba(90,100,128,.1);  color: var(--ju-muted); }

    .listing-price {
        font-size: 1.3rem; font-weight: 800;
        color: var(--ju-green); margin-bottom: 6px;
        font-variant-numeric: tabular-nums;
    }
    .listing-actions { display: flex; align-items: center; gap: 8px; }
    .action-link {
        font-size: .78rem; font-weight: 700;
        text-decoration: none; transition: color .15s;
    }
    .action-link.edit { color: var(--ju-gold-dark); }
    .action-link.edit:hover { color: var(--ju-gold); }
    .action-link.view { color: var(--ju-navy); }
    .action-link.view:hover { color: var(--ju-navy-light); }
    .action-sep { color: var(--ju-border); font-size: .8rem; }

    /* ═══════════════════════════
       EMPTY STATES
    ═══════════════════════════ */
    .empty-state {
        padding: 48px 24px; text-align: center;
    }
    .empty-icon {
        width: 64px; height: 64px; border-radius: 50%;
        background: var(--ju-surface); border: 1px solid var(--ju-border);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.4rem; color: var(--ju-muted-light);
    }
    .empty-title { font-size: .95rem; font-weight: 700; color: var(--ju-text); margin-bottom: 6px; }
    .empty-sub   { font-size: .83rem; color: var(--ju-muted); margin-bottom: 16px; }
    .btn-empty {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 20px; border-radius: 11px;
        background: linear-gradient(135deg, var(--ju-navy-mid), var(--ju-navy-light));
        color: #fff; font-size: .83rem; font-weight: 800;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0,48,135,.25);
        transition: transform .2s, box-shadow .2s;
    }
    .btn-empty:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,48,135,.32); }

    /* View all footer */
    .card-footer {
        padding: 12px 24px;
        text-align: center;
        background: #f8f9fd;
        border-top: 1px solid var(--ju-border-soft);
        border-radius: 0 0 18px 18px;
    }

    /* ═══════════════════════════
       MINI ITEM ROWS (favorites / messages)
    ═══════════════════════════ */
    .mini-row {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 24px;
        border-bottom: 1px solid var(--ju-border-soft);
        transition: background .15s; cursor: pointer;
    }
    .mini-row:last-of-type { border-bottom: none; }
    .mini-row:hover { background: #f5f7fd; }

    .mini-thumb {
        width: 46px; height: 46px; object-fit: cover;
        border-radius: 10px; border: 1px solid var(--ju-border);
        flex-shrink: 0;
    }
    .mini-thumb-empty {
        width: 46px; height: 46px; border-radius: 10px;
        background: var(--ju-surface); border: 1px solid var(--ju-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ju-muted-light); font-size: .9rem; flex-shrink: 0;
    }
    .mini-name   { font-size: .85rem; font-weight: 700; color: var(--ju-text); margin-bottom: 2px; }
    .mini-price  { font-size: .83rem; font-weight: 800; color: var(--ju-green); }
    .mini-arrow  { font-size: .75rem; color: var(--ju-border); margin-left: auto; flex-shrink: 0; }

    /* Message avatar */
    .msg-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, var(--ju-navy), var(--ju-navy-light));
        color: #fff; font-size: .9rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,48,135,.2);
    }
    .msg-name { font-size: .85rem; font-weight: 700; color: var(--ju-text); }
    .msg-about { font-size: .75rem; color: var(--ju-muted); margin-top: 1px; }
    .msg-preview { font-size: .73rem; color: var(--ju-muted-light); margin-top: 2px; }
    .msg-time { font-size: .7rem; color: var(--ju-muted-light); flex-shrink: 0; }
    .unread-badge {
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--ju-red); color: #fff;
        font-size: .62rem; font-weight: 800;
        min-width: 18px; height: 18px; border-radius: 99px;
        padding: 0 4px; margin-left: 5px;
    }

    /* ═══════════════════════════
       ACTIVITY FOOTER STRIP
    ═══════════════════════════ */
    .activity-strip {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-top: 3px solid var(--ju-gold);
        border-radius: 18px;
        padding: 20px 28px;
        margin-top: 24px;
        display: flex; flex-direction: column; gap: 16px;
        box-shadow: var(--shadow-sm);
    }
    @media (min-width: 640px) {
        .activity-strip { flex-direction: row; align-items: center; justify-content: space-between; }
    }

    .strip-left {
        display: flex; align-items: center; gap: 12px;
    }
    .strip-icon {
        width: 40px; height: 40px; border-radius: 11px;
        background: rgba(0,48,135,.08); color: var(--ju-navy);
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
    }
    .strip-label { font-size: .83rem; font-weight: 700; color: var(--ju-text); }
    .strip-sub   { font-size: .73rem; color: var(--ju-muted); margin-top: 1px; }

    .strip-stats { display: flex; gap: 28px; flex-wrap: wrap; }
    .strip-stat { text-align: center; }
    .strip-stat-val {
        font-size: 1.4rem; font-weight: 800;
        color: var(--ju-text); letter-spacing: -.02em;
        font-variant-numeric: tabular-nums;
    }
    .strip-stat-lbl {
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .08em; color: var(--ju-muted); margin-top: 1px;
    }

    .verified-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: .75rem; font-weight: 700;
        color: var(--ju-green);
        background: var(--ju-green-light);
        padding: 5px 12px; border-radius: 99px;
    }

    /* ═══════════════════════════
       SECTION DIVIDER
    ═══════════════════════════ */
    .divider-label {
        display: flex; align-items: center; gap: 10px;
        margin: 28px 0 18px;
        font-size: .65rem; font-weight: 800;
        letter-spacing: .15em; text-transform: uppercase;
        color: var(--ju-muted-light);
    }
    .divider-label::before, .divider-label::after {
        content: ''; flex: 1; height: 1px; background: var(--ju-border);
    }

    /* ═══════════════════════════
       2-COL GRID
    ═══════════════════════════ */
    .two-col {
        display: grid; grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 1024px) { .two-col { grid-template-columns: 1fr 1fr; } }
</style>

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background:var(--ju-surface)">
<div class="max-w-7xl mx-auto">

    {{-- ══════════════════════════════════════
         HERO BANNER
    ══════════════════════════════════════ --}}
    <div class="ju-hero">
        <div class="ju-hero-inner">
            <div class="flex items-center gap-4">
                <div class="ju-shield-wrap">
                    <svg viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:34px;height:34px">
                        <path d="M20 2L3 9V24C3 33.6 10.5 42.4 20 44C29.5 42.4 37 33.6 37 24V9L20 2Z"
                              fill="#C8960C" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                        <path d="M20 7L8 12.5V24C8 31.2 13.3 37.8 20 39.5C26.7 37.8 32 31.2 32 24V12.5L20 7Z"
                              fill="#001848"/>
                        <text x="20" y="29" text-anchor="middle" fill="#C8960C"
                              font-size="11" font-weight="700" font-family="Georgia,serif">JU</text>
                    </svg>
                </div>
                <div>
                    <p class="hero-eyebrow">Jimma University — Campus Trade</p>
                    <h1 class="hero-title">My Dashboard</h1>
                    <p class="hero-sub">Welcome back, <strong>{{ Auth::user()->name }}</strong></p>
                </div>
            </div>

            <div class="hero-actions">
                <a href="{{ route('listings.create') }}" class="btn-hero green">
                    <i class="fas fa-plus-circle"></i> Sell Item
                </a>
                <a href="{{ route('listings.index') }}" class="btn-hero navy">
                    <i class="fas fa-store"></i> Marketplace
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════ --}}
    <div class="stat-grid">

        <div class="stat-card c-navy">
            <div class="stat-icon navy"><i class="fas fa-boxes"></i></div>
            <p class="stat-label">Total Listings</p>
            <p class="stat-value">{{ App\Models\Listing::where('user_id', auth()->id())->count() }}</p>
            <span class="stat-tag navy"><i class="fas fa-chart-line"></i> Your activity</span>
        </div>

        <div class="stat-card c-green">
            <div class="stat-icon green"><i class="fas fa-tag"></i></div>
            <p class="stat-label">Active Listings</p>
            <p class="stat-value">{{ App\Models\Listing::where('user_id', auth()->id())->where('status', 'Active')->count() }}</p>
            <span class="stat-tag green"><i class="fas fa-eye"></i> Currently for sale</span>
        </div>

        <div class="stat-card c-gold">
            <div class="stat-icon gold"><i class="fas fa-eye"></i></div>
            <p class="stat-label">Total Views</p>
            <p class="stat-value">{{ number_format(App\Models\Listing::where('user_id', auth()->id())->sum('views_count')) }}</p>
            <span class="stat-tag gold"><i class="fas fa-chart-simple"></i> All-time views</span>
        </div>

        <div class="stat-card c-red">
            <div class="stat-icon red"><i class="fas fa-heart"></i></div>
            <p class="stat-label">Favorites</p>
            <p class="stat-value">{{ auth()->user()->favoriteListings()->count() }}</p>
            <span class="stat-tag red"><i class="fas fa-bookmark"></i> Saved items</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         ACTIVE LISTINGS
    ══════════════════════════════════════ --}}
    <div class="divider-label">Your Listings</div>

    @php
        $myListings = App\Models\Listing::where('user_id', Auth::id())
                        ->where('status', 'Active')
                        ->latest()->limit(5)->get();
    @endphp

    <div class="ju-card overflow-hidden mb-6">
        <div class="ju-card-header">
            <div class="flex items-center gap-3">
                <div class="card-icon navy"><i class="fas fa-box-open"></i></div>
                <div>
                    <p class="card-title">Your Active Listings</p>
                    <p class="card-subtitle">Items you're currently selling</p>
                </div>
            </div>
            <span class="card-count-pill">
                {{ App\Models\Listing::where('user_id', Auth::id())->where('status', 'Active')->count() }} active
            </span>
        </div>

        @forelse($myListings as $listing)
        <div class="listing-row" onclick="window.location='{{ route('listings.show', $listing) }}'">
            <div class="flex items-center gap-4 flex-1" style="min-width:0">
                @if($listing->photos->first())
                    <img src="{{ $listing->photos->first()->photo_path }}"
                         alt="{{ $listing->title }}" class="listing-thumb">
                @else
                    <div class="listing-thumb-empty"><i class="fas fa-image"></i></div>
                @endif
                <div style="min-width:0">
                    <p class="listing-name">{{ $listing->title }}</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="pill-sm navy"><i class="fas fa-tag"></i>{{ $listing->category }}</span>
                        <span class="pill-sm green"><i class="fas fa-eye"></i>{{ $listing->views_count }} views</span>
                        <span class="pill-sm gold"><i class="fas fa-clock"></i>{{ $listing->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-start sm:items-end gap-1 flex-shrink-0">
                <p class="listing-price">ETB {{ number_format($listing->price, 2) }}</p>
                <div class="listing-actions">
                    <a href="{{ route('listings.edit', $listing) }}"
                       class="action-link edit" onclick="event.stopPropagation()">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <span class="action-sep">|</span>
                    <a href="{{ route('listings.show', $listing) }}"
                       class="action-link view" onclick="event.stopPropagation()">
                        View <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <p class="empty-title">No active listings yet</p>
            <p class="empty-sub">Start selling your items to the JU community.</p>
            <a href="{{ route('listings.create') }}" class="btn-empty">
                <i class="fas fa-plus-circle"></i> Create Your First Listing
            </a>
        </div>
        @endforelse

        @if($myListings->count() > 0)
        <div class="card-footer">
            <a href="{{ route('listings.index') }}?user={{ Auth::id() }}" class="view-all-link">
                View All Your Listings <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════
         FAVORITES + MESSAGES
    ══════════════════════════════════════ --}}
    <div class="divider-label">Activity</div>

    <div class="two-col">

        {{-- Favorites --}}
        <div class="ju-card overflow-hidden">
            <div class="ju-card-header">
                <div class="flex items-center gap-3">
                    <div class="card-icon red"><i class="fas fa-heart"></i></div>
                    <div>
                        <p class="card-title">Your Favorites</p>
                        <p class="card-subtitle">Items you've saved</p>
                    </div>
                </div>
                <a href="{{ route('favorites.index') }}" class="view-all-link">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            @php
                $favorites = auth()->user()->favoriteListings()
                    ->with('photos')->latest()->limit(4)->get();
            @endphp

            @forelse($favorites as $favorite)
            <div class="mini-row" onclick="window.location='{{ route('listings.show', $favorite) }}'">
                @if($favorite->photos->first())
                    <img src="{{ $favorite->photos->first()->photo_path }}"
                         alt="{{ $favorite->title }}" class="mini-thumb">
                @else
                    <div class="mini-thumb-empty"><i class="fas fa-image"></i></div>
                @endif
                <div style="min-width:0; flex:1">
                    <p class="mini-name">{{ Str::limit($favorite->title, 38) }}</p>
                    <p class="mini-price">ETB {{ number_format($favorite->price, 2) }}</p>
                </div>
                <i class="fas fa-chevron-right mini-arrow"></i>
            </div>
            @empty
            <div class="empty-state" style="padding:36px 24px">
                <div class="empty-icon"><i class="fas fa-heart-broken"></i></div>
                <p class="empty-title">No favorites yet</p>
                <p class="empty-sub">Save items you're interested in.</p>
                <a href="{{ route('listings.index') }}" class="view-all-link">
                    Browse Items <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endforelse

            @if($favorites->count() > 0)
            <div class="card-footer">
                <a href="{{ route('favorites.index') }}" class="view-all-link">
                    View All Favorites <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endif
        </div>

        {{-- Messages --}}
        <div class="ju-card overflow-hidden">
            <div class="ju-card-header">
                <div class="flex items-center gap-3">
                    <div class="card-icon purple"><i class="fas fa-comments"></i></div>
                    <div>
                        <p class="card-title">Recent Messages</p>
                        <p class="card-subtitle">Latest conversations</p>
                    </div>
                </div>
                <a href="{{ route('messages.index') }}" class="view-all-link">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            @php
                $recentMessages = App\Models\Conversation::where('buyer_id', auth()->id())
                    ->orWhere('seller_id', auth()->id())
                    ->with(['buyer', 'seller', 'listing', 'lastMessage'])
                    ->orderBy('last_message_at', 'desc')
                    ->limit(4)->get();
            @endphp

            @forelse($recentMessages as $message)
            @php
                $otherUser   = $message->buyer_id === auth()->id() ? $message->seller : $message->buyer;
                $unreadCount = $message->unreadMessagesFor(auth()->id());
            @endphp
            <div class="mini-row" onclick="window.location='{{ route('messages.show', $message) }}'">
                <div class="msg-avatar">{{ substr($otherUser->name, 0, 1) }}</div>
                <div style="min-width:0; flex:1">
                    <div class="flex items-center justify-between gap-6">
                        <p class="msg-name">
                            {{ $otherUser->name }}
                            @if($unreadCount > 0)
                                <span class="unread-badge">{{ $unreadCount }}</span>
                            @endif
                        </p>
                        @if($message->lastMessage)
                        <span class="msg-time">{{ $message->lastMessage->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <p class="msg-about">About: {{ Str::limit($message->listing->title, 32) }}</p>
                    @if($message->lastMessage)
                    <p class="msg-preview">{{ Str::limit($message->lastMessage->message, 42) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state" style="padding:36px 24px">
                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                <p class="empty-title">No messages yet</p>
                <p class="empty-sub">Start a conversation with a seller.</p>
                <a href="{{ route('listings.index') }}" class="view-all-link">
                    Browse Items <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endforelse

            @if($recentMessages->count() > 0)
            <div class="card-footer">
                <a href="{{ route('messages.index') }}" class="view-all-link">
                    View All Messages <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endif
        </div>

    </div>

    {{-- ══════════════════════════════════════
         ACTIVITY STRIP FOOTER
    ══════════════════════════════════════ --}}
    <div class="activity-strip">
        <div class="strip-left">
            <div class="strip-icon"><i class="fas fa-chart-line"></i></div>
            <div>
                <p class="strip-label">Your Campus Trade Activity</p>
                <p class="strip-sub">Jimma University Marketplace</p>
            </div>
        </div>

        <div class="strip-stats">
            <div class="strip-stat">
                <p class="strip-stat-val">{{ App\Models\Listing::where('user_id', auth()->id())->count() }}</p>
                <p class="strip-stat-lbl">Total Items</p>
            </div>
            <div class="strip-stat">
                <p class="strip-stat-val">{{ App\Models\Listing::where('user_id', auth()->id())->where('status', 'Sold')->count() }}</p>
                <p class="strip-stat-lbl">Sold</p>
            </div>
            <div class="strip-stat">
                <p class="strip-stat-val">{{ App\Models\Conversation::where('buyer_id', auth()->id())->orWhere('seller_id', auth()->id())->count() }}</p>
                <p class="strip-stat-lbl">Conversations</p>
            </div>
        </div>

        <div>
            @if(auth()->user()->is_verified_seller)
            <span class="verified-badge">
                <i class="fas fa-shield-alt"></i> Verified Student
            </span>
            @else
            <a href="{{ route('id-verification.show') }}"
               class="verified-badge" style="background:rgba(192,57,43,.08); color:var(--ju-red); text-decoration:none">
                <i class="fas fa-exclamation-circle"></i> Verify ID
            </a>
            @endif
        </div>
    </div>

</div>
</div>

@endsection