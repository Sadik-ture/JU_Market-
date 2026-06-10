@extends('layouts.app-new')

@section('content')

{{-- ============================================================
     CAMPUS TRADE — Admin Dashboard
     Jimma University Official Brand — Premium Redesign
     Colors: #003087 (JU Navy), #C8960C (JU Gold), #001f5e (Deep Navy),
             #c0392b (JU Red), #f4f6fb (Off-White), #5a6480 (Muted)
     ============================================================ --}}

<style>
    /* ── Google Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap');

    /* ── JU Design Tokens ── */
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
        --ju-surface:     #f0f2f8;
        --ju-surface-2:   #e8ebf5;
        --ju-card:        #ffffff;
        --ju-border:      #dde3f0;
        --ju-border-soft: #eef1f9;
        --ju-muted:       #6b7494;
        --ju-muted-light: #9ba3bf;
        --ju-text:        #111827;
        --ju-text-2:      #374151;
        --shadow-xs: 0 1px 2px rgba(0,30,100,.06);
        --shadow-sm: 0 2px 8px rgba(0,30,100,.08), 0 1px 3px rgba(0,0,0,.04);
        --shadow-md: 0 6px 24px rgba(0,30,100,.11), 0 2px 8px rgba(0,0,0,.05);
        --shadow-lg: 0 16px 48px rgba(0,30,100,.16), 0 4px 16px rgba(0,0,0,.07);
        --shadow-glow: 0 0 0 3px rgba(0,48,135,.15);
    }

    * { box-sizing: border-box; }

    body {
        background: var(--ju-surface);
        color: var(--ju-text);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    /* ═══════════════════════════════════════════
       HERO BANNER — Signature Element
       Deep navy with animated gold grain shimmer
    ═══════════════════════════════════════════ */
    .ju-hero {
        position: relative;
        background: linear-gradient(135deg, #000d2e 0%, #001848 40%, #002678 75%, #003087 100%);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 28px;
        border: 1px solid rgba(200,150,12,.18);
    }

    /* Geometric mesh pattern overlay */
    .ju-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(200,150,12,.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(0,74,173,.25) 0%, transparent 45%),
            radial-gradient(circle at 60% 90%, rgba(200,150,12,.05) 0%, transparent 40%);
        pointer-events: none;
    }

    /* Gold shimmer sweep animation */
    .ju-hero::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 50%;
        height: 200%;
        background: linear-gradient(105deg, transparent 40%, rgba(200,150,12,.07) 50%, transparent 60%);
        animation: heroShimmer 5s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes heroShimmer {
        0%   { left: -60%; }
        100% { left: 130%; }
    }

    /* Grid lines */
    .ju-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(200,150,12,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(200,150,12,.04) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
    }

    .ju-hero-inner {
        position: relative;
        z-index: 2;
        padding: 28px 32px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    @media (min-width: 640px) {
        .ju-hero-inner {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    /* JU Shield */
    .ju-shield-wrap {
        width: 60px; height: 60px;
        border-radius: 16px;
        background: linear-gradient(145deg, rgba(200,150,12,.22), rgba(200,150,12,.08));
        border: 1px solid rgba(200,150,12,.35);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(200,150,12,.15), inset 0 1px 0 rgba(255,255,255,.1);
    }

    .ju-hero-eyebrow {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #C8960C;
        margin-bottom: 4px;
        opacity: .9;
    }
    .ju-hero-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.75rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: -.01em;
    }
    .ju-hero-sub {
        font-size: .875rem;
        color: rgba(255,255,255,.55);
        margin-top: 2px;
    }
    .ju-hero-sub strong { color: #e8c04a; font-weight: 600; }

    /* Live clock block */
    .ju-clock-block {
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 14px;
        padding: 14px 20px;
        text-align: center;
        backdrop-filter: blur(8px);
        flex-shrink: 0;
        min-width: 170px;
    }
    .ju-clock-live {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: .65rem; font-weight: 700; letter-spacing: .12em;
        text-transform: uppercase; color: #C8960C;
        margin-bottom: 4px;
    }
    .live-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #C8960C;
        animation: livePulse 1.4s ease-in-out infinite;
    }
    @keyframes livePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .4; transform: scale(.75); }
    }
    .ju-clock-time {
        font-size: 1.6rem; font-weight: 800;
        color: #fff; letter-spacing: .03em;
        font-variant-numeric: tabular-nums;
    }
    .ju-clock-date { font-size: .72rem; color: rgba(255,255,255,.5); margin-top: 2px; }

    /* ═══════════════════════════════════════════
       VERIFICATION BANNER
    ═══════════════════════════════════════════ */
    .verif-banner {
        background: linear-gradient(135deg, rgba(192,57,43,.05), rgba(192,57,43,.1));
        border: 1px solid rgba(192,57,43,.25);
        border-left: 4px solid var(--ju-red);
        border-radius: 14px;
        margin-bottom: 24px;
    }

    /* ═══════════════════════════════════════════
       STAT CARDS — premium glass finish
    ═══════════════════════════════════════════ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }
    @media (min-width: 640px)  { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .stat-grid { grid-template-columns: repeat(4, 1fr); } }

    .stat-card {
        background: var(--ju-card);
        border-radius: 18px;
        border: 1px solid var(--ju-border);
        box-shadow: var(--shadow-sm);
        padding: 22px 22px 18px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: box-shadow .25s ease, transform .25s ease;
    }
    .stat-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }

    /* Accent corner glow */
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        border-radius: 18px 18px 0 0;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 120px; height: 120px;
        border-radius: 50%;
        opacity: .04;
    }
    .stat-card.c-navy::before  { background: linear-gradient(90deg, var(--ju-navy), var(--ju-navy-light)); }
    .stat-card.c-navy::after   { background: var(--ju-navy); }
    .stat-card.c-green::before { background: linear-gradient(90deg, var(--ju-green), #2ecc71); }
    .stat-card.c-green::after  { background: var(--ju-green); }
    .stat-card.c-gold::before  { background: linear-gradient(90deg, var(--ju-gold-dark), var(--ju-gold-light)); }
    .stat-card.c-gold::after   { background: var(--ju-gold); }
    .stat-card.c-red::before   { background: linear-gradient(90deg, var(--ju-red), #e74c3c); }
    .stat-card.c-red::after    { background: var(--ju-red); }

    .stat-label {
        font-size: .7rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 8px;
    }
    .stat-value {
        font-size: 2.2rem; font-weight: 800;
        color: var(--ju-text); line-height: 1;
        letter-spacing: -.02em;
        font-variant-numeric: tabular-nums;
        margin-bottom: 12px;
    }
    .stat-delta {
        font-size: .75rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 4px;
        color: var(--ju-green);
        background: var(--ju-green-light);
        padding: 3px 8px; border-radius: 99px;
        margin-bottom: 14px;
    }

    /* Icon badge — top right */
    .stat-icon {
        position: absolute;
        top: 20px; right: 20px;
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
    }
    .stat-icon.navy  { background: rgba(0,48,135,.08);  color: var(--ju-navy); }
    .stat-icon.green { background: rgba(26,122,60,.1);  color: var(--ju-green); }
    .stat-icon.gold  { background: rgba(200,150,12,.1); color: var(--ju-gold-dark); }
    .stat-icon.red   { background: rgba(192,57,43,.1);  color: var(--ju-red); }

    .stat-footer {
        display: flex; justify-content: space-between;
        font-size: .76rem; color: var(--ju-muted);
        padding-top: 12px;
        border-top: 1px solid var(--ju-border-soft);
        gap: 4px;
    }
    .stat-footer strong { color: var(--ju-text-2); font-weight: 700; }

    /* Progress bar */
    .ju-progress {
        background: var(--ju-surface);
        border-radius: 99px;
        height: 5px;
        overflow: hidden;
        margin-bottom: 8px;
    }
    .ju-progress-bar {
        height: 100%;
        border-radius: 99px;
        transition: width 1.1s cubic-bezier(.22,1,.36,1);
    }

    /* ═══════════════════════════════════════════
       SECTION HEADER
    ═══════════════════════════════════════════ */
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px;
    }
    .section-title {
        font-size: .65rem; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: var(--ju-muted); margin-bottom: 2px;
    }
    .section-name {
        font-size: 1.05rem; font-weight: 700;
        color: var(--ju-text);
    }

    /* ═══════════════════════════════════════════
       CARDS (generic)
    ═══════════════════════════════════════════ */
    .ju-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
    }
    .ju-card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--ju-border-soft);
        display: flex; align-items: center; justify-content: space-between;
    }

    /* Range buttons */
    .range-btn {
        padding: 5px 13px;
        border-radius: 8px;
        font-size: .76rem;
        font-weight: 700;
        cursor: pointer;
        border: 1px solid var(--ju-border);
        background: var(--ju-surface);
        color: var(--ju-muted);
        transition: all .15s;
    }
    .range-btn.active,
    .range-btn:hover {
        background: var(--ju-navy);
        color: #fff;
        border-color: var(--ju-navy);
    }

    /* Chart wrap */
    .chart-wrap { position: relative; padding: 20px 20px 8px; }

    /* ═══════════════════════════════════════════
       TABS
    ═══════════════════════════════════════════ */
    .tab-strip {
        display: flex;
        background: #f8f9fd;
        border-bottom: 1px solid var(--ju-border);
        gap: 0;
        padding: 0 8px;
    }
    .tab-btn-item {
        padding: 15px 20px;
        font-size: .82rem; font-weight: 700;
        color: var(--ju-muted);
        border-bottom: 2.5px solid transparent;
        cursor: pointer;
        transition: color .2s, border-color .2s;
        display: flex; align-items: center; gap: 7px;
        white-space: nowrap;
        user-select: none;
    }
    .tab-btn-item:hover { color: var(--ju-navy); }
    .tab-btn-item.active {
        color: var(--ju-navy);
        border-bottom-color: var(--ju-navy);
        background: transparent;
    }
    .tab-badge {
        font-size: .65rem; font-weight: 800;
        background: var(--ju-navy);
        color: #fff;
        padding: 2px 6px;
        border-radius: 99px;
        min-width: 18px;
        text-align: center;
    }
    .tab-btn-item:not(.active) .tab-badge {
        background: var(--ju-surface-2);
        color: var(--ju-muted);
    }

    /* ═══════════════════════════════════════════
       ACTIVITY ROWS
    ═══════════════════════════════════════════ */
    .activity-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 24px;
        border-bottom: 1px solid var(--ju-border-soft);
        transition: background .15s;
        cursor: pointer;
        gap: 12px;
    }
    .activity-row:hover { background: #f5f7fd; }
    .activity-row:last-of-type { border-bottom: none; }

    .ju-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, var(--ju-navy), var(--ju-navy-light));
        color: #fff;
        font-weight: 800;
        font-size: .9rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,48,135,.2);
    }

    .activity-name {
        font-size: .875rem; font-weight: 600;
        color: var(--ju-text); margin-bottom: 2px;
    }
    .activity-sub {
        font-size: .75rem; color: var(--ju-muted);
    }
    .activity-right { text-align: right; flex-shrink: 0; }
    .activity-amount {
        font-size: .875rem; font-weight: 700;
        color: var(--ju-green); margin-bottom: 4px;
    }

    /* ── View All footer ── */
    .view-all-footer {
        padding: 14px 24px;
        text-align: center;
        background: #f8f9fd;
        border-top: 1px solid var(--ju-border-soft);
        border-radius: 0 0 18px 18px;
    }
    .view-all-link {
        font-size: .82rem; font-weight: 700;
        color: var(--ju-navy);
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
        transition: gap .2s;
    }
    .view-all-link:hover { gap: 10px; text-decoration: underline; }

    /* ═══════════════════════════════════════════
       STATUS PILLS
    ═══════════════════════════════════════════ */
    .pill {
        display: inline-flex; align-items: center;
        padding: 3px 9px;
        border-radius: 99px;
        font-size: .68rem; font-weight: 800;
        letter-spacing: .04em; text-transform: uppercase;
    }
    .pill.green  { background: rgba(26,122,60,.1);   color: var(--ju-green); }
    .pill.gold   { background: rgba(200,150,12,.12); color: var(--ju-gold-dark); }
    .pill.red    { background: rgba(192,57,43,.1);   color: var(--ju-red); }
    .pill.navy   { background: rgba(0,48,135,.08);   color: var(--ju-navy); }
    .pill.muted  { background: rgba(90,100,128,.1);  color: var(--ju-muted); }

    /* ═══════════════════════════════════════════
       PLATFORM HEALTH CARD
    ═══════════════════════════════════════════ */
    .health-metric { margin-bottom: 20px; }
    .health-metric:last-child { margin-bottom: 0; }
    .health-label {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 6px;
    }
    .health-label-left {
        display: flex; align-items: center; gap: 8px;
        font-size: .83rem; font-weight: 600; color: var(--ju-muted);
    }
    .health-dot {
        width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }
    .health-pct {
        font-size: .875rem; font-weight: 800;
        color: var(--ju-text);
    }
    .health-mini-grid {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid var(--ju-border-soft);
    }
    .health-mini-item { text-align: center; }
    .health-mini-val {
        font-size: 1.4rem; font-weight: 800;
        letter-spacing: -.02em;
    }
    .health-mini-lbl {
        font-size: .7rem; font-weight: 600;
        color: var(--ju-muted); margin-top: 2px; text-transform: uppercase; letter-spacing: .06em;
    }

    /* ═══════════════════════════════════════════
       TOP SELLERS TABLE
    ═══════════════════════════════════════════ */
    .sellers-table-wrap { overflow-x: auto; }
    .ju-table { width: 100%; border-collapse: collapse; }
    .ju-table thead th {
        background: #f8f9fd;
        color: var(--ju-muted);
        font-size: .68rem; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase;
        padding: 12px 20px;
        border-bottom: 1px solid var(--ju-border);
    }
    .ju-table thead th:first-child { border-radius: 0; }
    .ju-table tbody tr {
        border-bottom: 1px solid var(--ju-border-soft);
        transition: background .15s;
        cursor: pointer;
    }
    .ju-table tbody tr:hover { background: #f5f7fd; }
    .ju-table tbody tr:last-child { border-bottom: none; }
    .ju-table tbody td { padding: 14px 20px; font-size: .875rem; }

    .rank-medal { font-size: 1.5rem; line-height: 1; }
    .rank-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--ju-surface);
        color: var(--ju-muted);
        font-size: .75rem; font-weight: 800;
        display: inline-flex; align-items: center; justify-content: center;
    }

    .seller-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, var(--ju-navy), var(--ju-navy-light));
        color: #fff; font-weight: 800; font-size: .85rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,48,135,.2);
    }

    .stars-row {
        display: inline-flex; align-items: center; gap: 4px;
        background: var(--ju-gold-pale);
        padding: 3px 8px; border-radius: 99px;
    }

    .profile-btn {
        padding: 6px 14px; border-radius: 8px;
        font-size: .75rem; font-weight: 700;
        background: rgba(0,48,135,.07);
        color: var(--ju-navy);
        border: 1px solid rgba(0,48,135,.12);
        cursor: pointer;
        transition: all .15s;
    }
    .profile-btn:hover {
        background: var(--ju-navy);
        color: #fff;
        border-color: var(--ju-navy);
    }

    /* ═══════════════════════════════════════════
       MODAL
    ═══════════════════════════════════════════ */
    .ju-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,10,40,.6);
        backdrop-filter: blur(6px);
        z-index: 9000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .ju-modal-overlay.open { display: flex; }
    .ju-modal {
        background: #fff;
        border-radius: 22px;
        max-width: 460px; width: 100%;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--ju-border);
        animation: modalIn .22s cubic-bezier(.34,1.56,.64,1);
        overflow: hidden;
    }
    @keyframes modalIn {
        from { transform: scale(.9) translateY(10px); opacity: 0; }
        to   { transform: scale(1) translateY(0);     opacity: 1; }
    }
    .ju-modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--ju-border-soft);
        display: flex; align-items: center; justify-content: space-between;
        background: #fafbfd;
    }
    .ju-modal-header-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: rgba(0,48,135,.08);
        color: var(--ju-navy);
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
    }
    .ju-modal-title {
        font-size: 1rem; font-weight: 800;
        color: var(--ju-text);
        margin-left: 10px;
    }
    .ju-modal-close {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--ju-surface);
        border: 1px solid var(--ju-border);
        font-size: 1.1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: var(--ju-muted);
        transition: all .15s;
    }
    .ju-modal-close:hover { background: var(--ju-navy); color: #fff; border-color: var(--ju-navy); }
    .ju-modal-body { padding: 20px 24px 24px; }

    .modal-stat-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--ju-border-soft);
    }
    .modal-stat-row:last-child { border-bottom: none; padding-bottom: 0; }
    .modal-stat-label { font-size: .875rem; color: var(--ju-muted); font-weight: 500; }
    .modal-stat-val   { font-size: .875rem; font-weight: 800; color: var(--ju-navy); }

    /* ═══════════════════════════════════════════
       LOCKED CARDS
    ═══════════════════════════════════════════ */
    .locked-card {
        border-radius: 16px;
        border: 1.5px dashed var(--ju-border);
        background: var(--ju-card);
        padding: 24px 20px;
        text-align: center;
        opacity: .6;
        display: flex; flex-direction: column; align-items: center; gap: 10px;
    }
    .locked-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: var(--ju-surface);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        color: var(--ju-muted);
    }

    /* ═══════════════════════════════════════════
       FAB
    ═══════════════════════════════════════════ */
    .ju-fab {
        position: fixed; bottom: 28px; right: 28px; z-index: 50;
        width: 52px; height: 52px; border-radius: 50%;
        background: linear-gradient(135deg, var(--ju-navy), var(--ju-navy-light));
        color: #fff; border: none; cursor: pointer;
        box-shadow: 0 6px 24px rgba(0,48,135,.35);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        transition: transform .2s, box-shadow .2s;
    }
    .ju-fab:hover {
        transform: scale(1.1) rotate(20deg);
        box-shadow: 0 8px 32px rgba(0,48,135,.5);
    }

    /* ═══════════════════════════════════════════
       ICON BADGE (utility)
    ═══════════════════════════════════════════ */
    .icon-badge {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem; flex-shrink: 0;
    }
    .icon-badge.gold  { background: rgba(200,150,12,.1); color: var(--ju-gold-dark); }
    .icon-badge.navy  { background: rgba(0,48,135,.08);  color: var(--ju-navy); }
    .icon-badge.green { background: rgba(26,122,60,.1);  color: var(--ju-green); }

    /* ═══════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════ */
    @media (max-width: 640px) {
        .ju-hero-title { font-size: 1.4rem; }
        .tab-btn-item  { padding: 12px 14px; font-size: .78rem; }
        .ju-table thead th, .ju-table tbody td { padding: 10px 12px; }
        .activity-row  { padding: 12px 16px; }
    }

    /* 2-col chart grid */
    .charts-grid {
        display: grid; grid-template-columns: 1fr;
        gap: 20px; margin-bottom: 20px;
    }
    @media (min-width: 1024px) { .charts-grid { grid-template-columns: 1fr 1fr; } }

    /* 3-col lower grid */
    .lower-grid {
        display: grid; grid-template-columns: 1fr;
        gap: 20px; margin-bottom: 28px;
    }
    @media (min-width: 1024px) { .lower-grid { grid-template-columns: 1fr 1fr 1fr; } }

    /* ── Divider label ── */
    .divider-label {
        display: flex; align-items: center; gap: 10px;
        margin: 28px 0 18px;
        font-size: .65rem; font-weight: 800;
        letter-spacing: .15em; text-transform: uppercase;
        color: var(--ju-muted-light);
    }
    .divider-label::before, .divider-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--ju-border);
    }
</style>

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background:var(--ju-surface)">
<div class="max-w-7xl mx-auto">

    {{-- ══════════════════════════════════════════
         HERO BANNER
    ══════════════════════════════════════════ --}}
    <div class="ju-hero">
        <div class="ju-hero-grid"></div>
        <div class="ju-hero-inner">
            <div class="flex items-center gap-4">
                <div class="ju-shield-wrap">
                    <svg viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9">
                        <path d="M20 2L3 9V24C3 33.6 10.5 42.4 20 44C29.5 42.4 37 33.6 37 24V9L20 2Z"
                              fill="#C8960C" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                        <path d="M20 7L8 12.5V24C8 31.2 13.3 37.8 20 39.5C26.7 37.8 32 31.2 32 24V12.5L20 7Z"
                              fill="#001848"/>
                        <text x="20" y="29" text-anchor="middle" fill="#C8960C" font-size="11"
                              font-weight="700" font-family="Georgia,serif">JU</text>
                    </svg>
                </div>
                <div>
                    <p class="ju-hero-eyebrow">Jimma University — Campus Trade</p>
                    <h1 class="ju-hero-title">Admin Dashboard</h1>
                    <p class="ju-hero-sub">Welcome back, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
            </div>

            <div class="ju-clock-block">
                <div class="ju-clock-live"><span class="live-dot"></span> Live</div>
                <div class="ju-clock-time" id="liveClock">{{ now()->format('h:i:s A') }}</div>
                <div class="ju-clock-date" id="liveDate">{{ now()->format('l, F j, Y') }}</div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         VERIFICATION BANNER
    ══════════════════════════════════════════ --}}
    @if(auth()->user()->id_verification_status != 'approved')
    <div class="verif-banner px-5 py-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0"
                 style="background:rgba(192,57,43,.12)">
                <i class="fas fa-exclamation-triangle" style="color:var(--ju-red); font-size:1.1rem"></i>
            </div>
            <div>
                <p class="font-bold text-sm" style="color:var(--ju-text)">Verification Required</p>
                <p class="text-sm" style="color:var(--ju-muted)">Verify your JU student ID to unlock selling, buying, and messaging.</p>
            </div>
        </div>
        <a href="{{ route('id-verification.show') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-white transition hover:opacity-90 flex-shrink-0"
           style="background:var(--ju-red); box-shadow:0 4px 16px rgba(192,57,43,.3)">
            <i class="fas fa-id-card"></i> Verify Now
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @foreach([['fas fa-tag','Sell Items'],['fas fa-comment','Message Sellers'],['fas fa-shopping-cart','Buy Items']] as $item)
        <div class="locked-card">
            <div class="locked-icon"><i class="{{ $item[0] }}"></i></div>
            <p class="font-bold text-sm" style="color:var(--ju-text)">{{ $item[1] }}</p>
            <p class="text-xs" style="color:var(--ju-muted)">🔒 Unlocked after verification</p>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════════ --}}
    <div class="stat-grid">

        {{-- Users --}}
        <div class="stat-card c-navy" onclick="showUserModal()">
            <div class="stat-icon navy"><i class="fas fa-users"></i></div>
            <p class="stat-label">Total Users</p>
            <p class="stat-value counter" data-target="{{ $stats['total_users'] }}">0</p>
            <span class="stat-delta"><i class="fas fa-arrow-up"></i>+{{ number_format($stats['new_users_this_month']) }} this month</span>
            <div class="ju-progress">
                <div class="ju-progress-bar progress-bar" style="background:var(--ju-navy); width:{{ $stats['active_users_percentage'] }}%"></div>
            </div>
            <div class="stat-footer">
                <span>Active <strong style="color:var(--ju-green)">{{ number_format($stats['active_users']) }}</strong></span>
                <span>Verified <strong style="color:var(--ju-navy)">{{ number_format($stats['verified_sellers']) }}</strong></span>
            </div>
        </div>

        {{-- Listings --}}
        <div class="stat-card c-green" onclick="showListingModal()">
            <div class="stat-icon green"><i class="fas fa-boxes"></i></div>
            <p class="stat-label">Total Listings</p>
            <p class="stat-value counter" data-target="{{ $stats['total_listings'] }}">0</p>
            <span class="stat-delta"><i class="fas fa-arrow-up"></i>+{{ number_format($stats['new_listings_this_month']) }} new</span>
            <div class="ju-progress">
                <div class="ju-progress-bar progress-bar"
                     style="background:var(--ju-green); width:{{ $stats['total_listings'] > 0 ? ($stats['active_listings'] / $stats['total_listings'] * 100) : 0 }}%"></div>
            </div>
            <div class="stat-footer">
                <span>Active <strong style="color:var(--ju-green)">{{ number_format($stats['active_listings']) }}</strong></span>
                <span>Pending <strong style="color:var(--ju-gold-dark)">{{ number_format($stats['pending_listings']) }}</strong></span>
            </div>
        </div>

        {{-- Sales --}}
        <div class="stat-card c-gold" onclick="showSalesModal()">
            <div class="stat-icon gold"><i class="fas fa-shopping-cart"></i></div>
            <p class="stat-label">Total Sales</p>
            <p class="stat-value counter" data-target="{{ $stats['total_sales'] }}">0</p>
            <span class="stat-delta"><i class="fas fa-arrow-up"></i>+{{ number_format($stats['sales_this_month']) }} this month</span>
            <div class="stat-footer">
                <span>Completed <strong style="color:var(--ju-green)">{{ number_format($stats['completed_payments']) }}</strong></span>
                <span>Pending <strong style="color:var(--ju-gold-dark)">{{ number_format($stats['pending_payments']) }}</strong></span>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="stat-card c-navy" onclick="showRevenueModal()">
            <div class="stat-icon navy"><i class="fas fa-coins"></i></div>
            <p class="stat-label">Total Revenue</p>
            <p class="stat-value counter" data-target="{{ $stats['revenue'] }}">0</p>
            <span class="stat-delta"><i class="fas fa-arrow-up"></i>ETB {{ number_format($stats['revenue_this_month'], 2) }} month</span>
            <div class="stat-footer">
                <span>Avg Order</span>
                <strong style="color:var(--ju-navy)">ETB {{ number_format($stats['average_order_value'], 2) }}</strong>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         CHARTS ROW
    ══════════════════════════════════════════ --}}
    <div class="divider-label">Analytics</div>

    <div class="charts-grid mb-5">
        <div class="ju-card">
            <div class="ju-card-header">
                <div>
                    <p class="section-title">Overview</p>
                    <p class="section-name">Sales Trend</p>
                </div>
                <div class="flex gap-2">
                    <button class="range-btn active" data-days="7">7D</button>
                    <button class="range-btn" data-days="30">30D</button>
                    <button class="range-btn" data-days="90">90D</button>
                </div>
            </div>
            <div class="chart-wrap"><canvas id="salesChart" height="220"></canvas></div>
        </div>

        <div class="ju-card">
            <div class="ju-card-header">
                <div>
                    <p class="section-title">ETB (Ethiopian Birr)</p>
                    <p class="section-name">Revenue Breakdown</p>
                </div>
            </div>
            <div class="chart-wrap"><canvas id="revenueChart" height="220"></canvas></div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         CATEGORY / PAYMENT / HEALTH ROW
    ══════════════════════════════════════════ --}}
    <div class="lower-grid">

        {{-- Category Donut --}}
        <div class="ju-card">
            <div class="ju-card-header">
                <div>
                    <p class="section-title">Distribution</p>
                    <p class="section-name"><i class="fas fa-layer-group mr-2" style="color:var(--ju-gold)"></i>By Category</p>
                </div>
            </div>
            <div class="chart-wrap" style="padding-top:16px">
                <canvas id="categoryChart" height="200"></canvas>
                <p class="text-xs text-center mt-2" style="color:var(--ju-muted)">Click a segment to filter</p>
            </div>
        </div>

        {{-- Payment Status --}}
        <div class="ju-card">
            <div class="ju-card-header">
                <div>
                    <p class="section-title">Transactions</p>
                    <p class="section-name"><i class="fas fa-credit-card mr-2" style="color:var(--ju-navy)"></i>Payment Status</p>
                </div>
                <span class="pill green" style="font-size:.7rem">
                    {{ number_format($stats['payment_success_rate'], 1) }}% success
                </span>
            </div>
            <div class="chart-wrap" style="padding-top:16px">
                <canvas id="paymentStatusChart" height="200"></canvas>
            </div>
        </div>

        {{-- Platform Health --}}
        <div class="ju-card">
            <div class="ju-card-header">
                <div>
                    <p class="section-title">Status</p>
                    <p class="section-name"><i class="fas fa-heartbeat mr-2" style="color:var(--ju-red)"></i>Platform Health</p>
                </div>
            </div>
            <div style="padding:20px 24px">
                <div class="health-metric cursor-pointer" onclick="showUserDetails('active')">
                    <div class="health-label">
                        <span class="health-label-left">
                            <span class="health-dot" style="background:var(--ju-green)"></span>
                            Active Users
                        </span>
                        <span class="health-pct">{{ number_format($stats['active_users_percentage'], 1) }}%</span>
                    </div>
                    <div class="ju-progress">
                        <div class="ju-progress-bar progress-bar" style="background:var(--ju-green); width:{{ $stats['active_users_percentage'] }}%"></div>
                    </div>
                </div>
                <div class="health-metric cursor-pointer" onclick="showUserDetails('verified')">
                    <div class="health-label">
                        <span class="health-label-left">
                            <span class="health-dot" style="background:var(--ju-navy)"></span>
                            Verified Sellers
                        </span>
                        <span class="health-pct">{{ number_format($stats['verified_sellers_percentage'], 1) }}%</span>
                    </div>
                    <div class="ju-progress">
                        <div class="ju-progress-bar progress-bar" style="background:var(--ju-navy); width:{{ $stats['verified_sellers_percentage'] }}%"></div>
                    </div>
                </div>
                <div class="health-metric cursor-pointer" onclick="showImageDetails()">
                    <div class="health-label">
                        <span class="health-label-left">
                            <span class="health-dot" style="background:var(--ju-gold)"></span>
                            Listings w/ Images
                        </span>
                        <span class="health-pct">{{ number_format($stats['listings_with_images_percentage'], 1) }}%</span>
                    </div>
                    <div class="ju-progress">
                        <div class="ju-progress-bar progress-bar" style="background:var(--ju-gold); width:{{ $stats['listings_with_images_percentage'] }}%"></div>
                    </div>
                </div>

                <div class="health-mini-grid">
                    <div class="health-mini-item">
                        <div class="health-mini-val" style="color:var(--ju-green)">{{ number_format($stats['completed_payments']) }}</div>
                        <div class="health-mini-lbl">Done</div>
                    </div>
                    <div class="health-mini-item">
                        <div class="health-mini-val" style="color:var(--ju-gold-dark)">{{ number_format($stats['pending_payments']) }}</div>
                        <div class="health-mini-lbl">Pending</div>
                    </div>
                    <div class="health-mini-item">
                        <div class="health-mini-val" style="color:var(--ju-red)">{{ number_format($stats['failed_payments']) }}</div>
                        <div class="health-mini-lbl">Failed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         RECENT ACTIVITY TABS
    ══════════════════════════════════════════ --}}
    <div class="divider-label">Recent Activity</div>

    <div class="ju-card overflow-hidden mb-6">
        <div class="tab-strip">
            <button class="tab-btn-item active" data-tab="users">
                <i class="fas fa-users"></i> Users
                <span class="tab-badge">{{ count($recent_users) }}</span>
            </button>
            <button class="tab-btn-item" data-tab="listings">
                <i class="fas fa-boxes"></i> Listings
                <span class="tab-badge">{{ count($recent_listings) }}</span>
            </button>
            <button class="tab-btn-item" data-tab="payments">
                <i class="fas fa-credit-card"></i> Payments
            </button>
        </div>

        {{-- Users Tab --}}
        <div id="users-tab" class="tab-content">
            @foreach($recent_users as $user)
            <div class="activity-row" onclick="viewUser({{ $user->id }})">
                <div class="flex items-center gap-12" style="min-width:0">
                    <div class="ju-avatar flex-shrink-0">{{ substr($user->name, 0, 1) }}</div>
                    <div style="min-width:0">
                        <p class="activity-name">{{ $user->name }}</p>
                        <p class="activity-sub">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    @if($user->is_verified_seller)
                    <span class="pill green"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                    @endif
                    <span class="text-xs" style="color:var(--ju-muted-light)">{{ $user->created_at->diffForHumans() }}</span>
                    <i class="fas fa-chevron-right text-xs" style="color:var(--ju-border)"></i>
                </div>
            </div>
            @endforeach
            <div class="view-all-footer">
                <a href="{{ route('admin.users') }}" class="view-all-link">
                    View All Users <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        {{-- Listings Tab --}}
        <div id="listings-tab" class="tab-content hidden">
            @foreach($recent_listings as $listing)
            <div class="activity-row" onclick="viewListing({{ $listing->id }})">
                <div class="flex items-center gap-3" style="min-width:0">
                    @if($listing->photos->first())
                    <img src="{{ $listing->photos->first()->photo_path }}"
                         class="w-10 h-10 object-cover rounded-xl border flex-shrink-0"
                         style="border-color:var(--ju-border)">
                    @else
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:var(--ju-surface)">
                        <i class="fas fa-image" style="color:var(--ju-muted-light)"></i>
                    </div>
                    @endif
                    <div style="min-width:0">
                        <p class="activity-name">{{ Str::limit($listing->title, 32) }}</p>
                        <p class="activity-sub">By {{ $listing->user->name }}</p>
                    </div>
                </div>
                <div class="activity-right">
                    <p class="activity-amount">ETB {{ number_format($listing->price, 2) }}</p>
                    <span class="pill {{ $listing->status == 'Active' ? 'green' : ($listing->status == 'Sold' ? 'muted' : 'gold') }}">
                        {{ $listing->status }}
                    </span>
                </div>
            </div>
            @endforeach
            <div class="view-all-footer">
                <a href="{{ route('admin.listings') }}" class="view-all-link">
                    View All Listings <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        {{-- Payments Tab --}}
        <div id="payments-tab" class="tab-content hidden">
            @php
                $recent_payments = App\Models\Payment::with(['buyer','seller','listing'])->latest()->limit(10)->get();
            @endphp
            @foreach($recent_payments as $payment)
            <div class="activity-row" onclick="viewPayment({{ $payment->id }})">
                <div class="flex items-center gap-3" style="min-width:0">
                    <div class="icon-badge gold flex-shrink-0" style="width:40px;height:40px;border-radius:12px">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div style="min-width:0">
                        <p class="activity-name">{{ Str::limit($payment->listing->title ?? 'N/A', 28) }}</p>
                        <p class="activity-sub">Buyer: {{ $payment->buyer->name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="activity-right">
                    <p class="activity-amount">ETB {{ number_format($payment->amount, 2) }}</p>
                    <span class="pill {{ $payment->status == 'completed' ? 'green' : ($payment->status == 'pending' ? 'gold' : 'red') }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         TOP SELLERS TABLE
    ══════════════════════════════════════════ --}}
    <div class="divider-label">Leaderboard</div>

    <div class="ju-card overflow-hidden">
        <div class="ju-card-header">
            <div class="flex items-center gap-3">
                <div class="icon-badge gold" style="width:40px;height:40px;border-radius:12px;font-size:1.1rem">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <p class="section-title">Performance</p>
                    <p class="section-name">Top Performing Sellers</p>
                </div>
            </div>
            <span class="text-xs font-semibold" style="color:var(--ju-muted)">Ranked by revenue</span>
        </div>
        <div class="sellers-table-wrap">
            <table class="ju-table">
                <thead>
                    <tr>
                        <th class="text-left" style="width:60px">Rank</th>
                        <th class="text-left">Seller</th>
                        <th class="text-center">Items Sold</th>
                        <th class="text-center">Revenue</th>
                        <th class="text-center">Rating</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top_sellers as $index => $seller)
                    <tr onclick="viewSeller({{ $loop->index }})">
                        <td>
                            @if($index == 0) <span class="rank-medal">🥇</span>
                            @elseif($index == 1) <span class="rank-medal">🥈</span>
                            @elseif($index == 2) <span class="rank-medal">🥉</span>
                            @else <span class="rank-num">#{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="seller-avatar">{{ substr($seller['name'], 0, 1) }}</div>
                                <span class="font-semibold text-sm" style="color:var(--ju-text)">{{ $seller['name'] }}</span>
                            </div>
                        </td>
                        <td class="text-center font-bold text-sm" style="color:var(--ju-text-2)">
                            {{ number_format($seller['items_sold']) }}
                        </td>
                        <td class="text-center">
                            <span class="font-bold text-sm" style="color:var(--ju-green)">ETB {{ number_format($seller['revenue'], 2) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="stars-row">
                                <i class="fas fa-star text-xs" style="color:var(--ju-gold)"></i>
                                <span class="font-bold text-sm" style="color:var(--ju-text-2)">{{ number_format($seller['rating'], 1) }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <button onclick="event.stopPropagation(); viewSellerDetails({{ $index }})"
                                    class="profile-btn">
                                View Profile
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>{{-- /max-w-7xl --}}
</div>

{{-- ══════════════════════════════════════════
     MODAL
══════════════════════════════════════════ --}}
<div id="juModal" class="ju-modal-overlay" onclick="closeModal()">
    <div class="ju-modal" onclick="event.stopPropagation()">
        <div class="ju-modal-header">
            <div class="flex items-center">
                <div class="ju-modal-header-icon"><i class="fas fa-chart-bar"></i></div>
                <h3 class="ju-modal-title" id="modalTitle">Details</h3>
            </div>
            <button class="ju-modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="ju-modal-body" id="modalContent"></div>
    </div>
</div>

{{-- FAB --}}
<button class="ju-fab" onclick="refreshDashboard()" title="Refresh Dashboard">
    <i class="fas fa-sync-alt"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
/* ── Clock ── */
function updateClock() {
    const now  = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString('en-US');
}
setInterval(updateClock, 1000);

/* ── Counter animation ── */
document.querySelectorAll('.counter').forEach(el => {
    const target = parseInt(el.dataset.target) || 0;
    let current  = 0;
    const step   = Math.ceil(target / 55);
    const run = () => {
        current += step;
        if (current < target) { el.textContent = Math.floor(current).toLocaleString(); requestAnimationFrame(run); }
        else                  { el.textContent = target.toLocaleString(); }
    };
    run();
});

/* ── Progress bars animate in ── */
document.querySelectorAll('.progress-bar').forEach(bar => {
    const w = bar.style.width;
    bar.style.width = '0%';
    setTimeout(() => { bar.style.cssText += '; width:' + w + '; transition: width 1.1s cubic-bezier(.22,1,.36,1)'; }, 160);
});

/* ── Tabs ── */
document.querySelectorAll('.tab-btn-item').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tab-btn-item').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const tab = this.dataset.tab;
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById(tab + '-tab').classList.remove('hidden');
    });
});

/* ── Chart defaults ── */
Chart.defaults.font.family = "'Inter','Segoe UI',sans-serif";
Chart.defaults.color       = '#6b7494';
Chart.defaults.plugins.tooltip.cornerRadius = 10;
Chart.defaults.plugins.tooltip.padding      = 12;

let salesChart, revenueChart;

function buildGrad(ctx, color) {
    const g = ctx.createLinearGradient(0, 0, 0, 240);
    g.addColorStop(0, color + '30');
    g.addColorStop(1, color + '00');
    return g;
}

function initCharts(sL, sD, rL, rD) {
    if (salesChart)   salesChart.destroy();
    if (revenueChart) revenueChart.destroy();

    const sCtx = document.getElementById('salesChart').getContext('2d');
    salesChart = new Chart(sCtx, {
        type: 'line',
        data: {
            labels: sL,
            datasets: [{
                label: 'Sales',
                data: sD,
                borderColor: '#003087',
                backgroundColor: buildGrad(sCtx, '#003087'),
                tension: 0.45,
                fill: true,
                pointBackgroundColor: '#003087',
                pointBorderColor: '#fff',
                pointBorderWidth: 2.5,
                pointRadius: 4,
                pointHoverRadius: 7,
                borderWidth: 2.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: '#001848' }
            },
            scales: {
                y: { grid: { color: '#edf0f8' }, ticks: { color: '#6b7494' }, border: { display: false } },
                x: { grid: { display: false }, ticks: { color: '#6b7494' }, border: { display: false } }
            }
        }
    });

    const rCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(rCtx, {
        type: 'bar',
        data: {
            labels: rL,
            datasets: [{
                label: 'Revenue (ETB)',
                data: rD,
                backgroundColor: '#C8960C',
                hoverBackgroundColor: '#a37a09',
                borderRadius: 8,
                borderSkipped: false,
                barPercentage: 0.58,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: '#001848' }
            },
            scales: {
                y: { grid: { color: '#edf0f8' }, ticks: { color: '#6b7494' }, border: { display: false } },
                x: { grid: { display: false }, ticks: { color: '#6b7494' }, border: { display: false } }
            }
        }
    });
}

/* ── Category Donut ── */
new Chart(document.getElementById('categoryChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($category_labels) !!},
        datasets: [{
            data: {!! json_encode($category_data) !!},
            backgroundColor: ['#003087','#1a7a3c','#C8960C','#c0392b','#7c3aed','#0ea5e9'],
            borderWidth: 3,
            borderColor: '#fff',
            hoverOffset: 14,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#6b7494', padding: 14, usePointStyle: true, font: { size: 11, weight: '600' } } }
        },
        cutout: '70%',
        onClick: (e, els) => {
            if (els.length) {
                const cat = {!! json_encode($category_labels) !!}[els[0].index];
                window.location.href = '/admin/listings?category=' + cat;
            }
        }
    }
});

/* ── Payment Donut ── */
new Chart(document.getElementById('paymentStatusChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Completed','Pending','Failed'],
        datasets: [{
            data: [{{ $stats['completed_payments'] }}, {{ $stats['pending_payments'] }}, {{ $stats['failed_payments'] }}],
            backgroundColor: ['#1a7a3c','#C8960C','#c0392b'],
            borderWidth: 3,
            borderColor: '#fff',
            hoverOffset: 14,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#6b7494', padding: 14, usePointStyle: true, font: { size: 11, weight: '600' } } }
        },
        cutout: '70%',
        onClick: () => window.location.href = '/admin/payments'
    }
});

/* ── Range buttons ── */
document.querySelectorAll('.range-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.range-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        fetch('/admin/chart-data/' + this.dataset.days)
            .then(r => r.json())
            .then(d => initCharts(d.sales_labels, d.sales_data, d.revenue_labels, d.revenue_data));
    });
});

/* ── Modal helpers ── */
function showModal(title, html) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('juModal').classList.add('open');
}
function closeModal() { document.getElementById('juModal').classList.remove('open'); }

function statRow(label, value) {
    return '<div class="modal-stat-row"><span class="modal-stat-label">' + label + '</span><span class="modal-stat-val">' + value + '</span></div>';
}

function showUserModal()    { showModal('User Statistics',    statRow('Total Users','{{ number_format($stats['total_users']) }}') + statRow('Active','{{ number_format($stats['active_users']) }}') + statRow('Verified','{{ number_format($stats['verified_sellers']) }}')); }
function showListingModal() { showModal('Listing Statistics', statRow('Total Listings','{{ number_format($stats['total_listings']) }}') + statRow('Active','{{ number_format($stats['active_listings']) }}') + statRow('Sold','{{ number_format($stats['sold_listings']) }}')); }
function showSalesModal()   { showModal('Sales Statistics',   statRow('Total Sales','{{ number_format($stats['total_sales']) }}') + statRow('This Month','{{ number_format($stats['sales_this_month']) }}') + statRow('Success Rate','{{ number_format($stats['payment_success_rate'], 1) }}%')); }
function showRevenueModal() { showModal('Revenue Statistics', statRow('Total Revenue','ETB {{ number_format($stats['revenue'], 2) }}') + statRow('This Month','ETB {{ number_format($stats['revenue_this_month'], 2) }}') + statRow('Avg Order','ETB {{ number_format($stats['average_order_value'], 2) }}')); }
function showUserDetails(t) {
    if (t === 'active') showModal('Active Users', statRow('Active Users','{{ number_format($stats['active_users']) }}') + statRow('Percentage','{{ number_format($stats['active_users_percentage'], 1) }}%'));
    else showModal('Verified Sellers', statRow('Verified Sellers','{{ number_format($stats['verified_sellers']) }}') + statRow('Percentage','{{ number_format($stats['verified_sellers_percentage'], 1) }}%'));
}
function showImageDetails() { showModal('Listings with Images', statRow('With Images','{{ number_format($stats['listings_with_images']) }}') + statRow('Percentage','{{ number_format($stats['listings_with_images_percentage'], 1) }}%')); }

function viewUser(id)    { window.location.href = '/admin/users?search=' + id; }
function viewListing(id) { window.location.href = '/listings/' + id; }
function viewPayment()   { window.location.href = '/admin/payments'; }
function refreshDashboard() { location.reload(); }
function viewSeller(i)        { showModal('Top Seller #' + (i+1), '<p style="color:#6b7494;font-size:.875rem;line-height:1.6">Full seller profile and transaction history are available in the User Management panel.</p>'); }
function viewSellerDetails(i) { showModal('Seller Profile — Rank ' + (i+1), '<p style="color:#6b7494;font-size:.875rem;line-height:1.6">Full details available in the User Management section.</p>'); }

/* ── Init charts ── */
initCharts(
    {!! json_encode($sales_labels) !!},
    {!! json_encode($sales_data) !!},
    {!! json_encode($revenue_labels) !!},
    {!! json_encode($revenue_data) !!}
);
</script>

@endsection




boundery is here


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Campus Trade') }} - Jimma University Campus Marketplace</title>

    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ─── JIMMA UNIVERSITY OFFICIAL PALETTE ─── */
        :root {
            --ju-navy:        #003087;
            --ju-navy-dark:   #001f5e;
            --ju-navy-mid:    #0044b3;
            --ju-navy-light:  #1a4a9e;
            --ju-gold:        #C8960C;
            --ju-gold-lt:     #f0b429;
            --ju-gold-pale:   #fef3c7;
            --ju-white:       #ffffff;
            --ju-offwhite:    #f4f6fb;
            --ju-surface:     #eef1f8;
            --ju-border:      #c8d2e8;
            --ju-text:        #1a1f36;
            --ju-muted:       #5a6480;
            --ju-red:         #c0392b;
            --ju-green:       #2e7d32;
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

        /* ════════════════════════════════════════
           INSTITUTIONAL TOP STRIP
           (mimics JU site: thin colored ribbon)
        ════════════════════════════════════════ */
        .ju-institution-bar {
            background: var(--ju-navy-dark);
            border-bottom: 1px solid rgba(200,150,12,0.35);
            padding: 0;
        }
        .ju-institution-bar__inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: stretch;
            justify-content: space-between;
            font-size: 12px;
        }
        .ju-inst-left,
        .ju-inst-right {
            display: flex;
            align-items: center;
            gap: 0;
        }
        .ju-inst-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            color: rgba(255,255,255,0.65);
            font-size: 11.5px;
            border-right: 1px solid rgba(255,255,255,0.07);
            white-space: nowrap;
            text-decoration: none;
            transition: color 0.2s, background 0.2s;
        }
        .ju-inst-item:first-child { border-left: 1px solid rgba(255,255,255,0.07); }
        .ju-inst-item:hover { color: var(--ju-gold-lt); background: rgba(255,255,255,0.04); }
        .ju-inst-item i { color: var(--ju-gold); font-size: 10.5px; }
        .ju-inst-highlight {
            background: var(--ju-gold);
            color: var(--ju-navy-dark) !important;
            font-weight: 700;
            font-size: 11px;
            padding: 8px 16px;
            border-left: none !important;
            transition: background 0.2s;
        }
        .ju-inst-highlight:hover { background: var(--ju-gold-lt) !important; }
        .ju-inst-highlight i { color: var(--ju-navy-dark) !important; }

        /* ════════════════════════════════════════
           ANNOUNCEMENT TICKER
        ════════════════════════════════════════ */
        .ju-ticker {
            background: linear-gradient(90deg, var(--ju-gold) 0%, #d9a200 100%);
            padding: 6px 0;
            overflow: hidden;
            position: relative;
        }
        .ju-ticker__label {
            background: var(--ju-navy-dark);
            color: var(--ju-gold);
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0 14px;
            height: 100%;
            display: flex;
            align-items: center;
            position: absolute;
            left: 0; top: 0;
            z-index: 2;
        }
        .ju-ticker__track {
            display: flex;
            align-items: center;
            padding-left: 110px;
            color: var(--ju-navy-dark);
            font-size: 12.5px;
            font-weight: 700;
            gap: 32px;
            white-space: nowrap;
        }
        .ju-ticker__dot {
            width: 5px; height: 5px;
            background: var(--ju-navy-dark);
            border-radius: 50%;
            opacity: 0.4;
            flex-shrink: 0;
        }

        /* ════════════════════════════════════════
           HEADER IDENTITY BAND
           (logo + search: the JU "masthead")
        ════════════════════════════════════════ */
        .ju-masthead {
            background: var(--ju-navy);
            padding: 16px 0 14px;
            border-bottom: 4px solid var(--ju-gold);
        }
        .ju-masthead__inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        /* Shield / crest */
        .ju-crest {
            width: 58px; height: 58px;
            background: linear-gradient(145deg, var(--ju-gold) 0%, #a87500 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(200,150,12,0.4), inset 0 1px 0 rgba(255,255,255,0.25);
            transition: transform 0.3s;
        }
        .ju-crest:hover { transform: scale(1.06) rotate(-2deg); }
        .ju-crest i { color: var(--ju-navy-dark); font-size: 24px; }

        /* Wordmark */
        .ju-wordmark { flex: 0 0 auto; }
        .ju-wordmark__name {
            font-family: 'Crimson Pro', serif;
            font-weight: 700;
            font-size: 26px;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .ju-wordmark__name span { color: var(--ju-gold); }
        .ju-wordmark__sub {
            font-size: 10px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.16em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Masthead divider */
        .ju-masthead-divider {
            width: 1px; height: 44px;
            background: rgba(255,255,255,0.15);
            flex-shrink: 0;
        }

        /* Masthead tagline */
        .ju-tagline {
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .ju-tagline__title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ju-gold);
        }
        .ju-tagline__desc {
            font-size: 12.5px;
            color: rgba(255,255,255,0.5);
        }

        /* Masthead search */
        .ju-masthead-search {
            flex: 1;
            max-width: 540px;
            margin-left: auto;
        }
        .ju-search-box {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.09);
            border: 1.5px solid rgba(255,255,255,0.18);
            border-radius: 6px;
            overflow: hidden;
            transition: all 0.25s;
        }
        .ju-search-box:focus-within {
            background: rgba(255,255,255,0.14);
            border-color: var(--ju-gold);
            box-shadow: 0 0 0 3px rgba(200,150,12,0.18);
        }
        .ju-search-box input {
            flex: 1;
            background: transparent;
            border: none; outline: none;
            padding: 10px 14px;
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13.5px;
        }
        .ju-search-box input::placeholder { color: rgba(255,255,255,0.4); }
        .ju-search-btn {
            background: var(--ju-gold);
            color: var(--ju-navy-dark);
            border: none;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .ju-search-btn:hover { background: var(--ju-gold-lt); }

        /* Masthead actions */
        .ju-masthead-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ════════════════════════════════════════
           PRIMARY NAVIGATION
           (separate band below masthead — JU style)
        ════════════════════════════════════════ */
        .ju-nav {
            background: var(--ju-navy-mid);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 3px 16px rgba(0,30,87,0.3);
            border-bottom: 2px solid rgba(200,150,12,0.35);
            transition: transform 0.3s ease;
        }
        .ju-nav__inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: stretch;
            justify-content: space-between;
        }

        /* Nav items */
        .ju-nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 0 18px;
            height: 46px;
            color: rgba(255,255,255,0.82);
            font-weight: 600;
            font-size: 13.5px;
            text-decoration: none;
            position: relative;
            transition: color 0.2s, background 0.2s;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }
        .ju-nav-link::before {
            content: '';
            position: absolute;
            bottom: -3px; left: 0; right: 0;
            height: 3px;
            background: var(--ju-gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s;
        }
        .ju-nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }
        .ju-nav-link:hover::before { transform: scaleX(1); }
        .ju-nav-link.active {
            color: var(--ju-gold);
            background: rgba(0,0,0,0.15);
        }
        .ju-nav-link.active::before { transform: scaleX(1); }
        .ju-nav-link i { font-size: 12px; }

        /* Badge dot on nav */
        .ju-nav-badge {
            position: absolute;
            top: 8px; right: 8px;
            background: var(--ju-red);
            color: #fff;
            font-size: 9.5px;
            border-radius: 50%;
            min-width: 17px; height: 17px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.15); opacity: 0.85; }
        }

        /* Nav right section (sell + avatar) */
        .ju-nav-right {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ════════════════════════════════════════
           BUTTONS
        ════════════════════════════════════════ */
        .btn-primary {
            background: var(--ju-gold);
            color: var(--ju-navy-dark);
            font-weight: 700;
            border-radius: 5px;
            padding: 8px 20px;
            font-size: 13px;
            border: none; cursor: pointer;
            transition: all 0.22s;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(200,150,12,0.3);
            letter-spacing: 0.01em;
        }
        .btn-primary:hover {
            background: var(--ju-gold-lt);
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(200,150,12,0.38);
        }

        .btn-outline-white {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.35);
            color: rgba(255,255,255,0.82);
            border-radius: 5px;
            padding: 7px 17px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.22s;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
        }
        .btn-outline-white:hover {
            border-color: var(--ju-gold);
            color: var(--ju-gold);
        }

        /* ════════════════════════════════════════
           PROFILE AVATAR  —  shows photo or initial
        ════════════════════════════════════════ */
        .ju-user-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .ju-user-trigger:hover { background: rgba(255,255,255,0.1); }

        .ju-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid var(--ju-gold);
            overflow: hidden;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: var(--ju-gold);
            font-family: 'Crimson Pro', serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--ju-navy-dark);
            transition: transform 0.22s, box-shadow 0.22s;
        }
        .ju-avatar img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
        }
        .ju-user-trigger:hover .ju-avatar {
            transform: scale(1.06);
            box-shadow: 0 0 0 3px rgba(200,150,12,0.35);
        }
        .ju-user-name {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ════════════════════════════════════════
           PROFILE SLIDE PANEL
        ════════════════════════════════════════ */
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
            width: 300px; background: #fff; z-index: 300;
            transform: translateX(100%);
            transition: transform .35s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column; overflow: hidden;
            border-left: 1px solid var(--ju-border);
            box-shadow: -8px 0 40px rgba(0,20,87,0.18);
        }
        .pp-panel.open { transform: translateX(0); }

        /* Panel header */
        .pp-head {
            background: var(--ju-navy-dark);
            position: relative; overflow: hidden; flex-shrink: 0;
        }
        .pp-head::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--ju-gold), var(--ju-gold-lt), var(--ju-gold));
        }
        .pp-head-inner { padding: 24px 20px 22px; }

        .pp-close {
            position: absolute; top: 10px; right: 10px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.65); border-radius: 6px;
            width: 28px; height: 28px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; transition: all .2s;
        }
        .pp-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

        /* ── Profile photo in panel (big) ── */
        .pp-photo-ring {
            width: 68px; height: 68px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.2);
            overflow: hidden;
            background: var(--ju-gold);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-bottom: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        }
        .pp-photo-ring img {
            width: 100%; height: 100%;
            object-fit: cover; display: block;
        }
        .pp-photo-ring .pp-photo-initial {
            font-family: 'Crimson Pro', serif;
            font-weight: 700;
            font-size: 28px;
            color: var(--ju-navy-dark);
        }

        .pp-name {
            color: #fff; font-family: 'Crimson Pro', serif;
            font-weight: 700; font-size: 18px; line-height: 1.2;
        }
        .pp-email { color: rgba(255,255,255,0.48); font-size: 11.5px; margin-top: 2px; }
        .pp-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px; }
        .pp-badge {
            font-size: 10px; font-weight: 700; padding: 2px 9px; border-radius: 4px;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .pp-badge-gold  { background: rgba(200,150,12,0.2); color: var(--ju-gold-lt); border: 1px solid rgba(200,150,12,0.3); }
        .pp-badge-green { background: rgba(74,222,128,0.12); color: #4ade80; border: 1px solid rgba(74,222,128,0.2); }

        /* Panel body */
        .pp-body { flex: 1; overflow-y: auto; padding: 8px 0; }
        .pp-body::-webkit-scrollbar { width: 3px; }
        .pp-body::-webkit-scrollbar-thumb { background: var(--ju-border); border-radius: 4px; }

        .pp-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: var(--ju-muted); padding: 12px 18px 4px;
        }

        .pp-item {
            display: flex; align-items: center; gap: 11px; padding: 10px 18px;
            color: var(--ju-text); font-size: 13px; text-decoration: none;
            transition: background .15s; position: relative;
            border: none; background: none; width: 100%; text-align: left; cursor: pointer;
        }
        .pp-item:hover { background: var(--ju-surface); color: var(--ju-navy); }

        .pp-icon {
            width: 32px; height: 32px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 13px; transition: transform .2s;
        }
        .pp-item:hover .pp-icon { transform: translateX(2px); }
        .pp-label { flex: 1; font-weight: 600; }
        .pp-meta {
            font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 4px;
        }
        .pp-divider { height: 1px; background: var(--ju-border); margin: 5px 0; }

        .ic-blue   { background: #eff6ff; color: #1d4ed8; }
        .ic-navy   { background: #eef2fb; color: var(--ju-navy); }
        .ic-purple { background: #faf5ff; color: #7c3aed; }
        .ic-green  { background: #f0fdf4; color: #166534; }

        .pp-item.admin-item .pp-icon { background: #eef2fb; color: var(--ju-navy-dark); }
        .pp-item.admin-item:hover     { background: #eef2fb; }
        .pp-item.admin-item:hover .pp-icon { background: var(--ju-navy); color: #fff; }

        .pp-foot {
            flex-shrink: 0; padding: 10px 18px 22px;
            border-top: 1px solid var(--ju-border);
        }
        .pp-logout {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px; border-radius: 7px;
            border: 1.5px solid #fecaca; background: #fff;
            color: var(--ju-red); font-size: 13px; font-weight: 700;
            cursor: pointer; transition: all .2s;
        }
        .pp-logout:hover { background: #fef2f2; border-color: #f87171; }

        /* ════════════════════════════════════════
           PRODUCT CARDS
        ════════════════════════════════════════ */
        .product-card {
            background: #fff;
            border: 1px solid var(--ju-border);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.32s cubic-bezier(0.4,0,0.2,1);
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 36px rgba(0,30,87,0.13);
            border-color: var(--ju-navy);
        }
        .product-card::after {
            content: '';
            position: absolute; bottom: 0; left: 0;
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
        .product-card:hover .product-image { transform: scale(1.04); }

        /* ════════════════════════════════════════
           CATEGORY CARD
        ════════════════════════════════════════ */
        .category-card {
            background: #fff;
            border: 1px solid var(--ju-border);
            border-radius: 8px;
            transition: all 0.3s;
        }
        .category-card:hover {
            background: var(--ju-navy);
            border-color: var(--ju-navy);
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0,30,87,0.2);
        }
        .category-card:hover * { color: #fff !important; }

        /* ════════════════════════════════════════
           GENERIC BADGES
        ════════════════════════════════════════ */
        .badge {
            font-size: 10.5px; font-weight: 700; letter-spacing: 0.04em;
            padding: 2px 8px; border-radius: 4px;
        }
        .badge-hot      { background: var(--ju-red); color: #fff; }
        .badge-verified { background: var(--ju-navy); color: var(--ju-gold); }
        .badge-sold     { background: var(--ju-surface); color: var(--ju-muted); }
        .badge-new      { background: var(--ju-gold); color: var(--ju-navy-dark); }

        /* ════════════════════════════════════════
           CARD LIGHT
        ════════════════════════════════════════ */
        .card-light {
            background: #fff; border: 1px solid var(--ju-border); border-radius: 8px;
            transition: all 0.3s;
        }
        .card-light:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,30,87,0.11);
            border-color: var(--ju-navy);
        }

        /* ════════════════════════════════════════
           SKELETON SHIMMER
        ════════════════════════════════════════ */
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

        /* ════════════════════════════════════════
           TOAST
        ════════════════════════════════════════ */
        .toast-notification {
            position: fixed; bottom: 20px; right: 20px; z-index: 1000;
            animation: slideInRight 0.3s ease-out;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(80px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ════════════════════════════════════════
           SCROLLBAR
        ════════════════════════════════════════ */
        ::-webkit-scrollbar { width: 7px; }
        ::-webkit-scrollbar-track { background: var(--ju-surface); }
        ::-webkit-scrollbar-thumb { background: var(--ju-navy); border-radius: 7px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--ju-navy-mid); }

        /* ════════════════════════════════════════
           ANIMATIONS
        ════════════════════════════════════════ */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-6px); }
        }
        .floating { animation: float 3s ease-in-out infinite; }

        .spinner {
            width: 36px; height: 36px;
            border: 3px solid var(--ju-border);
            border-top-color: var(--ju-navy);
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ════════════════════════════════════════
           MODAL
        ════════════════════════════════════════ */
        .modal-overlay { background: rgba(0,20,60,0.75); backdrop-filter: blur(6px); }

        /* ════════════════════════════════════════
           FOOTER
        ════════════════════════════════════════ */
        .ju-footer {
            background: var(--ju-navy-dark);
            color: rgba(255,255,255,0.75);
            border-top: 4px solid var(--ju-gold);
        }
        .ju-footer h4 {
            font-family: 'Crimson Pro', serif;
            color: #fff; font-size: 17px; margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .ju-footer a {
            color: rgba(255,255,255,0.6); text-decoration: none;
            font-size: 13px; transition: color 0.2s;
            display: flex; align-items: center; gap: 8px;
        }
        .ju-footer a:hover { color: var(--ju-gold); }
        .ju-footer a i { color: var(--ju-gold); font-size: 10px; }

        .social-btn {
            width: 33px; height: 33px;
            background: rgba(255,255,255,0.08);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.65); text-decoration: none;
            transition: all 0.22s;
        }
        .social-btn:hover { background: var(--ju-gold); color: var(--ju-navy-dark) !important; }

        /* ════════════════════════════════════════
           MOBILE MENU DRAWER
        ════════════════════════════════════════ */
        #mobileMenu {
            background: var(--ju-navy-dark);
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        #mobileMenu a {
            color: rgba(255,255,255,0.78);
            display: flex; align-items: center; gap: 10px;
            padding: 11px 20px;
            font-size: 13.5px; font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        #mobileMenu a:hover { background: rgba(255,255,255,0.06); color: var(--ju-gold); }

        /* ════════════════════════════════════════
           HERO
        ════════════════════════════════════════ */
        .hero-section { position: relative; overflow: hidden; }
        .hero-section::before {
            content: '';
            position: absolute; top: -40%; right: -15%;
            width: 70%; height: 200%;
            background: radial-gradient(circle, rgba(200,150,12,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ════════════════════════════════════════
           MISC
        ════════════════════════════════════════ */
        .progress-bar { transition: width 1s ease-out; }
        [data-aos] { color: inherit !important; }

        @media (max-width: 1024px) {
            .ju-masthead .ju-tagline { display: none; }
            .ju-masthead-divider    { display: none; }
        }
        @media (max-width: 768px) {
            .pp-panel { width: 88%; }
            .ju-masthead__inner { gap: 12px; }
            .ju-wordmark__name { font-size: 20px; }
            .ju-crest { width: 44px; height: 44px; }
            .ju-crest i { font-size: 18px; }
        }
    </style>
</head>
<body>

    {{-- ══ INSTITUTIONAL TOP BAR ══ --}}
    <div class="ju-institution-bar">
        <div class="ju-institution-bar__inner">
            <div class="ju-inst-left">
                <span class="ju-inst-item">
                    <i class="fas fa-shield-alt"></i> Secure Payments
                </span>
                <span class="ju-inst-item">
                    <i class="fas fa-truck"></i> Campus Delivery
                </span>
                <span class="ju-inst-item hidden md:flex">
                    <i class="fas fa-id-badge"></i> Verified Students Only
                </span>
            </div>
            <div class="ju-inst-right">
                <span class="ju-inst-item floating">
                    <i class="fas fa-users"></i> 1,500+ Active
                </span>
                <span class="ju-inst-item hidden md:flex">
                    <i class="fas fa-star"></i> 4.9 Rating
                </span>
                <a href="#" class="ju-inst-item ju-inst-highlight">
                    <i class="fas fa-headset"></i> 24/7 Support
                </a>
            </div>
        </div>
    </div>

    {{-- ══ ANNOUNCEMENT TICKER ══ --}}
    <div class="ju-ticker">
        <div class="ju-ticker__label">
            <i class="fas fa-bullhorn mr-1.5" style="font-size:9px"></i> NEWS
        </div>
        <div class="ju-ticker__track">
            <i class="fas fa-graduation-cap"></i>
            Sell textbooks, electronics &amp; more — Join 1,500+ active JU students already trading!
            <span class="ju-ticker__dot"></span>
            Post your first listing for FREE — no commission on your first 3 sales!
            <span class="ju-ticker__dot"></span>
            New: Verified ID badge now available for all registered students
            <i class="fas fa-long-arrow-alt-right ml-2"></i>
        </div>
    </div>

    {{-- ══ MASTHEAD (Identity Band) ══ --}}
    <div class="ju-masthead">
        <div class="ju-masthead__inner">

            {{-- Crest + Wordmark --}}
            <a href="{{ route('landing') }}" style="display:flex;align-items:center;gap:14px;text-decoration:none;flex-shrink:0">
                <div class="ju-crest"><i class="fas fa-university"></i></div>
                <div class="ju-wordmark">
                    <div class="ju-wordmark__name">Campus<span>Trade</span></div>
                    <div class="ju-wordmark__sub">Jimma University Marketplace</div>
                </div>
            </a>

            {{-- Divider + tagline --}}
            <div class="ju-masthead-divider"></div>
            <div class="ju-tagline">
                <div class="ju-tagline__title"><i class="fas fa-map-marker-alt mr-1"></i> Jimma, Ethiopia</div>
                <div class="ju-tagline__desc">Campus-to-campus student trading platform</div>
            </div>

            {{-- Search --}}
            <div class="ju-masthead-search hidden md:block">
                <div class="ju-search-box">
                    <i class="fas fa-search" style="color:rgba(255,255,255,0.35);font-size:13px;padding-left:14px;flex-shrink:0"></i>
                    <input type="text" id="searchInput" placeholder="Search textbooks, electronics, furniture…">
                    <button class="ju-search-btn">
                        <i class="fas fa-search" style="font-size:12px"></i> Search
                    </button>
                </div>
            </div>

            {{-- Auth Actions --}}
            <div class="ju-masthead-actions">
                @auth
                    <a href="{{ route('listings.create') }}" class="btn-primary hidden sm:inline-flex" style="font-size:12.5px;padding:8px 16px">
                        <i class="fas fa-plus-circle"></i> Sell Item
                    </a>
                @else
                    <a href="{{ route('login') }}"    class="btn-outline-white" style="font-size:12.5px">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary"       style="font-size:12.5px">Sign Up Free</a>
                @endauth

                {{-- Mobile menu toggle --}}
                <button id="mobileMenuBtn"
                    style="background:none;border:none;color:rgba(255,255,255,0.75);font-size:20px;cursor:pointer;padding:4px 6px;display:none"
                    class="block lg:hidden"
                    aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ══ PRIMARY NAVIGATION BAR ══ --}}
    <nav class="ju-nav" id="mainNav">
        <div class="ju-nav__inner">

            {{-- Left nav links --}}
            <div class="hidden lg:flex items-stretch">
                <a href="{{ route('landing') }}" class="ju-nav-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('listings.index') }}" class="ju-nav-link">
                    <i class="fas fa-store"></i> Marketplace
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="ju-nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('messages.index') }}" class="ju-nav-link" style="position:relative">
                        <i class="fas fa-comments"></i> Messages
                        @php $unread = auth()->user()->unreadMessagesCount(); @endphp
                        @if($unread > 0)
                            <span class="ju-nav-badge">{{ $unread }}</span>
                        @endif
                    </a>
                    <a href="{{ route('favorites.index') }}" class="ju-nav-link" style="position:relative">
                        <i class="fas fa-heart" style="color:#e74c3c"></i> Saved
                        @php $favCount = auth()->user()->favoriteListings()->count(); @endphp
                        @if($favCount > 0)
                            <span class="ju-nav-badge">{{ $favCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('payment.history') }}" class="ju-nav-link">
                        <i class="fas fa-receipt"></i> Transactions
                    </a>
                @endauth
            </div>

            {{-- Right: avatar/user trigger --}}
            <div class="ju-nav-right">
                @auth
                    {{-- Profile avatar button --}}
                    <button
                        onclick="openProfilePanel()"
                        class="ju-user-trigger"
                        aria-label="Open profile menu">

                        {{-- Avatar: show profile photo if available, else initial --}}
                        <div class="ju-avatar">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                     alt="{{ Auth::user()->name }}"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <span style="display:none">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @elseif(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}"
                                     alt="{{ Auth::user()->name }}"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <span style="display:none">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>

                        <span class="ju-user-name hidden md:block">{{ Auth::user()->name }}</span>
                        <i id="profileChevron" class="fas fa-chevron-down hidden md:block"
                           style="color:rgba(255,255,255,0.45);font-size:10px;transition:transform .25s"></i>
                    </button>
                @else
                    {{-- Guest: show login/register in nav too --}}
                    <a href="{{ route('login') }}"    class="btn-outline-white" style="font-size:12.5px;padding:6px 14px">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary"       style="font-size:12.5px;padding:7px 14px">Sign Up</a>
                @endauth

                {{-- Mobile hamburger (visible in nav bar on small screens) --}}
                <button id="mobileMenuBtnNav" class="lg:hidden"
                    style="background:none;border:none;color:rgba(255,255,255,0.75);font-size:20px;cursor:pointer;padding:4px 6px;margin-left:4px"
                    aria-label="Toggle mobile menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        {{-- Mobile search row --}}
        <div class="md:hidden" style="padding:8px 16px 10px;border-top:1px solid rgba(255,255,255,0.08)">
            <div class="ju-search-box" style="border-radius:5px">
                <i class="fas fa-search" style="color:rgba(255,255,255,0.35);font-size:12px;padding-left:12px;flex-shrink:0"></i>
                <input type="text" placeholder="Search products…">
                <button class="ju-search-btn" style="padding:9px 16px;font-size:12px">Go</button>
            </div>
        </div>

        {{-- Mobile Menu Drawer --}}
        <div id="mobileMenu" class="hidden lg:hidden">
            <a href="{{ route('landing') }}"><i class="fas fa-home fa-fw"></i> Home</a>
            <a href="{{ route('listings.index') }}"><i class="fas fa-store fa-fw"></i> Marketplace</a>
            @auth
                <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
                <a href="{{ route('messages.index') }}"><i class="fas fa-comments fa-fw"></i> Messages</a>
                <a href="{{ route('favorites.index') }}"><i class="fas fa-heart fa-fw"></i> Saved Items</a>
                <a href="{{ route('payment.history') }}"><i class="fas fa-receipt fa-fw"></i> Transactions</a>
                <a href="{{ route('listings.create') }}" style="color:var(--ju-gold)!important">
                    <i class="fas fa-plus-circle fa-fw"></i> Sell Item
                </a>
                <a href="{{ route('id-verification.show') }}"><i class="fas fa-id-card fa-fw"></i> Verify ID</a>
                @if(Auth::user()->is_admin == 1)
                    <div style="padding:8px 20px 3px;font-size:10px;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);border-top:1px solid rgba(255,255,255,0.06);margin-top:4px">
                        <i class="fas fa-shield-alt mr-1"></i> Admin
                    </div>
                    <a href="{{ route('admin.dashboard') }}"  style="color:#c084fc!important"><i class="fas fa-chart-line fa-fw"></i> Dashboard</a>
                    <a href="{{ route('admin.users') }}"><i class="fas fa-users fa-fw"></i> Users</a>
                    <a href="{{ route('admin.listings') }}"><i class="fas fa-boxes fa-fw"></i> Listings</a>
                    <a href="{{ route('admin.payments') }}"><i class="fas fa-credit-card fa-fw"></i> Payments</a>
                    <a href="{{ route('admin.ratings') }}"><i class="fas fa-star fa-fw"></i> Ratings</a>
                    <a href="{{ route('admin.top-sellers') }}"><i class="fas fa-trophy fa-fw"></i> Top Sellers</a>
                    <a href="{{ route('admin.pending-ids') }}"><i class="fas fa-id-card fa-fw"></i> Pending IDs</a>
                @endif
            @else
                <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt fa-fw"></i> Login</a>
                <a href="{{ route('register') }}" style="color:var(--ju-gold)!important"><i class="fas fa-user-plus fa-fw"></i> Sign Up</a>
            @endauth
        </div>
    </nav>

    {{-- ══ MAIN CONTENT ══ --}}
    <main>
        @yield('content')
    </main>

    {{-- ══ FOOTER ══ --}}
    <footer class="ju-footer" style="margin-top:80px">
        <div style="max-width:1280px;margin:0 auto;padding:0 20px">

            {{-- Footer top band --}}
            <div style="background:rgba(200,150,12,0.08);border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                <div style="display:flex;align-items:center;gap:14px">
                    <div class="ju-crest" style="width:42px;height:42px;flex-shrink:0">
                        <i class="fas fa-university" style="font-size:18px"></i>
                    </div>
                    <div>
                        <div class="ju-wordmark__name" style="font-size:18px">Campus<span style="color:var(--ju-gold)">Trade</span></div>
                        <div style="font-size:10.5px;color:rgba(255,255,255,0.4);letter-spacing:0.12em;text-transform:uppercase">Jimma University Marketplace</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px">
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f" style="font-size:12px"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-twitter"    style="font-size:12px"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-instagram"  style="font-size:12px"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-telegram"   style="font-size:12px"></i></a>
                </div>
            </div>

            <div style="padding:40px 0 30px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:32px">

                {{-- Brand blurb --}}
                <div data-aos="fade-up">
                    <h4>About CampusTrade</h4>
                    <p style="font-size:13px;line-height:1.75;color:rgba(255,255,255,0.55)">
                        The #1 marketplace for Ethiopian university students. Buy, sell, and trade with confidence — all within your campus community.
                    </p>
                    <div style="margin-top:14px;display:flex;flex-direction:column;gap:7px">
                        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.55)">
                            <i class="fas fa-check-circle" style="color:#4ade80"></i> 100% Secure Payments
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.55)">
                            <i class="fas fa-shield-alt" style="color:var(--ju-gold)"></i> Verified Students Only
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.55)">
                            <i class="fas fa-truck" style="color:var(--ju-gold)"></i> Campus-wide Delivery
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div data-aos="fade-up" data-aos-delay="100">
                    <h4>Quick Links</h4>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:9px">
                        <li><a href="{{ route('landing') }}"><i class="fas fa-chevron-right"></i>Home</a></li>
                        <li><a href="{{ route('listings.index') }}"><i class="fas fa-chevron-right"></i>Marketplace</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i>How It Works</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i>Safety Tips</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i>Terms &amp; Conditions</a></li>
                    </ul>
                </div>

                {{-- Categories --}}
                <div data-aos="fade-up" data-aos-delay="200">
                    <h4>Browse Categories</h4>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:9px">
                        <li><a href="{{ route('listings.index', ['category'=>'Electronics']) }}"><i class="fas fa-chevron-right"></i>Electronics</a></li>
                        <li><a href="{{ route('listings.index', ['category'=>'Textbooks']) }}"><i class="fas fa-chevron-right"></i>Textbooks</a></li>
                        <li><a href="{{ route('listings.index', ['category'=>'Furniture']) }}"><i class="fas fa-chevron-right"></i>Furniture</a></li>
                        <li><a href="{{ route('listings.index', ['category'=>'Clothing']) }}"><i class="fas fa-chevron-right"></i>Clothing</a></li>
                        <li><a href="{{ route('listings.index') }}"><i class="fas fa-chevron-right"></i>View All</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact Us</h4>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:10px">
                        <li style="display:flex;align-items:flex-start;gap:10px;color:rgba(255,255,255,0.6);font-size:13px">
                            <i class="fas fa-envelope" style="color:var(--ju-gold);margin-top:2px;flex-shrink:0"></i>
                            support@campustrade.com
                        </li>
                        <li style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.6);font-size:13px">
                            <i class="fas fa-phone" style="color:var(--ju-gold);flex-shrink:0"></i>
                            +251-911-XXXXXX
                        </li>
                        <li style="display:flex;align-items:flex-start;gap:10px;color:rgba(255,255,255,0.6);font-size:13px">
                            <i class="fas fa-map-marker-alt" style="color:var(--ju-gold);margin-top:2px;flex-shrink:0"></i>
                            Jimma University, Jimma, Ethiopia
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Footer bottom --}}
            <div style="border-top:1px solid rgba(255,255,255,0.08);padding:16px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;font-size:12px;color:rgba(255,255,255,0.38)">
                <span>&copy; {{ date('Y') }} CampusTrade &mdash; Jimma University Student Marketplace.</span>
                <span>Made with <i class="fas fa-heart" style="color:var(--ju-red)"></i> for Ethiopian students.</span>
            </div>
        </div>
    </footer>

    {{-- ══ PROFILE SLIDE PANEL ══ --}}
    @auth

    <div class="pp-overlay" id="ppOverlay" onclick="closeProfilePanel()"></div>

    <div class="pp-panel" id="ppPanel" role="dialog" aria-modal="true" aria-label="Profile menu">

        {{-- Header --}}
        <div class="pp-head">
            <button class="pp-close" onclick="closeProfilePanel()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="pp-head-inner">

                {{-- Profile photo (large) in panel --}}
                <div class="pp-photo-ring">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                             alt="{{ Auth::user()->name }}"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <span class="pp-photo-initial" style="display:none">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @elseif(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}"
                             alt="{{ Auth::user()->name }}"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <span class="pp-photo-initial" style="display:none">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @else
                        <span class="pp-photo-initial">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                </div>

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

        {{-- Body --}}
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

            {{-- Admin section --}}
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
                        <span class="pp-meta" style="background:var(--ju-gold);color:var(--ju-navy-dark)">{{ $pendingCount }}</span>
                    @endif
                </a>
            @endif

        </div>

        {{-- Logout --}}
        <div class="pp-foot">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="pp-logout">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>

    </div>
    @endauth

    {{-- ══ SCRIPTS ══ --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, once: true, offset: 80 });

        /* ── Mobile Menu (both toggle buttons) ── */
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) menu.classList.toggle('hidden');
        }
        const mobileBtn1 = document.getElementById('mobileMenuBtn');
        const mobileBtn2 = document.getElementById('mobileMenuBtnNav');
        if (mobileBtn1) mobileBtn1.addEventListener('click', toggleMobileMenu);
        if (mobileBtn2) mobileBtn2.addEventListener('click', toggleMobileMenu);

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
            t.style.cssText = 'background:#fff;border-left:4px solid var(--ju-navy);border-radius:7px;box-shadow:0 8px 28px rgba(0,30,87,0.14);padding:13px 16px;display:flex;align-items:center;gap:10px;min-width:250px';
            t.innerHTML = `<i class="fas ${type==='success'?'fa-check-circle':'fa-exclamation-circle'}" style="color:${type==='success'?'var(--ju-navy)':'var(--ju-red)'};font-size:17px"></i><span style="color:var(--ju-text);font-size:13.5px">${message}</span>`;
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


onother boundery

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:Y7kl8BeqHc/rEgmDuTgmwRA+3o14yb5GWzna5ZaGQYI=
APP_DEBUG=true
APP_URL=http://campus-trade.test

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

# PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=campus_trade
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=cc19e1a4fa0511
MAIL_PASSWORD=d1c5dfb0aafbb5
MAIL_FROM_ADDRESS="noreply@campustrade.com"
MAIL_FROM_NAME="Campus Trade"
MAIL_ENCRYPTION=tls

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

CHAPA_SECRET_KEY=CHASECK_TEST-qRevEAJCGskblSdOyGvQWnCNBnVuisGF
CHAPA_PUBLIC_KEY=CHAPUBK_TEST-UHkHWlbNsWGQdNJZ0FL3Mt4Nq6iJAdUX
VITE_APP_NAME="${APP_NAME}"








