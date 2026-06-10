@extends('layouts.app-new')

@section('content')

{{-- ════════════════════════════════════════════════════════════════
     INLINE PAGE STYLES  (JU palette, already defined in layout,
     here we only add page-specific overrides & new components)
════════════════════════════════════════════════════════════════ --}}
<style>
    /* ── Page-level CSS variables (extend layout palette) ─────────── */
    :root {
        --ju-navy:       #003087;
        --ju-navy-dark:  #001f5e;
        --ju-navy-mid:   #0044b3;
        --ju-gold:       #C8960C;
        --ju-gold-lt:    #f0b429;
        --ju-white:      #ffffff;
        --ju-offwhite:   #f4f6fb;
        --ju-surface:    #eef1f8;
        --ju-border:     #c8d2e8;
        --ju-text:       #1a1f36;
        --ju-muted:      #5a6480;
        --ju-red:        #c0392b;
    }

    /* ── Hero ───────────────────────────────────────────────────── */
    .hero-section {
        background: linear-gradient(135deg, var(--ju-navy-dark) 0%, var(--ju-navy) 55%, #004fa3 100%);
        position: relative; overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 70% 80% at 80% 40%, rgba(200,150,12,.13) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 10% 80%, rgba(255,255,255,.04) 0%, transparent 60%);
        pointer-events: none;
    }
    /* Diagonal gold stripe */
    .hero-section::after {
        content: '';
        position: absolute; top: 0; right: -80px;
        width: 220px; height: 100%;
        background: linear-gradient(180deg, var(--ju-gold) 0%, transparent 100%);
        opacity: .06;
        transform: skewX(-12deg);
        pointer-events: none;
    }

    .hero-stat-value {
        font-family: 'Crimson Pro', serif;
        font-size: 2.4rem; font-weight: 700;
        color: var(--ju-gold);
        line-height: 1;
    }
    .hero-stat-label {
        font-size: 12px; color: rgba(255,255,255,.6);
        margin-top: 4px; letter-spacing: .04em;
    }
    .hero-stat-divider {
        width: 1px; background: rgba(255,255,255,.15); align-self: stretch;
    }

    /* Floating hero image frame */
    .hero-img-frame {
        border: 3px solid var(--ju-gold);
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,20,80,.4);
        transition: transform .4s ease, box-shadow .4s ease;
    }
    .hero-img-frame:hover { transform: translateY(-6px); box-shadow: 0 40px 80px rgba(0,20,80,.5); }
    .hero-img-frame img { width: 100%; height: 320px; object-fit: cover; display: block; transition: transform .5s; }
    .hero-img-frame:hover img { transform: scale(1.04); }
    .hero-img-badge {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(to top, rgba(0,20,70,.85), transparent);
        padding: 24px 16px 14px;
        text-align: center; color: #fff;
    }

    /* Live badge pulse */
    .live-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(200,150,12,.18); border: 1px solid var(--ju-gold);
        color: var(--ju-gold-lt); border-radius: 50px;
        font-size: 12px; font-weight: 700; letter-spacing: .06em;
        padding: 4px 12px; margin-bottom: 16px;
    }
    .live-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--ju-gold);
        animation: livePulse 1.5s ease-in-out infinite;
    }
    @keyframes livePulse {
        0%,100% { opacity: 1; transform: scale(1); }
        50%      { opacity: .5; transform: scale(.7); }
    }

    /* ── Section headers ─────────────────────────────────────────── */
    .section-eyebrow {
        display: inline-block;
        font-size: 11px; font-weight: 700; letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--ju-navy);
        background: rgba(0,48,135,.08);
        border: 1px solid rgba(0,48,135,.15);
        padding: 4px 14px; border-radius: 50px;
        margin-bottom: 10px;
    }
    .section-title {
        font-family: 'Crimson Pro', serif;
        font-size: 2.2rem; font-weight: 700;
        color: var(--ju-text); line-height: 1.2;
    }
    .section-title span { color: var(--ju-navy); }
    .section-title .gold { color: var(--ju-gold); }

    /* Gold underline divider */
    .gold-divider {
        width: 50px; height: 3px;
        background: linear-gradient(90deg, var(--ju-navy), var(--ju-gold));
        border-radius: 2px; margin: 10px auto 0;
    }

    /* ── Category cards ──────────────────────────────────────────── */
    .cat-card {
        background: #fff;
        border: 1.5px solid var(--ju-border);
        border-radius: 14px;
        padding: 22px 12px;
        text-align: center;
        text-decoration: none;
        display: flex; flex-direction: column; align-items: center;
        transition: all .3s cubic-bezier(.4,0,.2,1);
        position: relative; overflow: hidden;
    }
    .cat-card::after {
        content: '';
        position: absolute; bottom: 0; left: 0;
        width: 0; height: 3px;
        background: linear-gradient(90deg, var(--ju-navy), var(--ju-gold));
        transition: width .35s;
    }
    .cat-card:hover { transform: translateY(-8px); border-color: var(--ju-navy); box-shadow: 0 16px 40px rgba(0,48,135,.13); }
    .cat-card:hover::after { width: 100%; }
    .cat-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px; font-size: 22px; color: #fff;
        transition: transform .3s;
    }
    .cat-card:hover .cat-icon { transform: scale(1.12) rotate(-4deg); }
    .cat-name { font-weight: 700; font-size: 13.5px; color: var(--ju-text); }
    .cat-count { font-size: 11.5px; color: var(--ju-muted); margin-top: 3px; }
    .cat-arrow {
        font-size: 11px; color: var(--ju-navy);
        opacity: 0; transform: translateX(-6px);
        transition: all .25s; margin-top: 6px;
    }
    .cat-card:hover .cat-arrow { opacity: 1; transform: translateX(0); }

    /* ── Product cards ───────────────────────────────────────────── */
    .prod-card {
        background: #fff;
        border: 1px solid var(--ju-border);
        border-radius: 14px; overflow: hidden;
        transition: all .35s cubic-bezier(.4,0,.2,1);
        position: relative;
    }
    .prod-card:hover { transform: translateY(-7px); box-shadow: 0 20px 50px rgba(0,48,135,.14); border-color: var(--ju-navy); }
    .prod-card::after {
        content: '';
        position: absolute; bottom: 0; left: 0;
        width: 0; height: 3px;
        background: linear-gradient(90deg, var(--ju-navy), var(--ju-gold));
        transition: width .4s;
    }
    .prod-card:hover::after { width: 100%; }

    .prod-img-wrap { position: relative; overflow: hidden; background: var(--ju-surface); }
    .prod-img-wrap img { width: 100%; height: 200px; object-fit: cover; display: block; transition: transform .5s ease; }
    .prod-card:hover .prod-img-wrap img { transform: scale(1.07); }

    /* Wishlist heart button */
    .wish-btn {
        position: absolute; top: 10px; right: 10px;
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(255,255,255,.92); border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #bbb; font-size: 14px;
        transition: all .2s; z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,.12);
    }
    .wish-btn:hover { color: var(--ju-red); transform: scale(1.15); }
    .wish-btn.active { color: var(--ju-red); }

    .prod-badge {
        position: absolute; top: 10px; left: 10px; z-index: 2;
        font-size: 10.5px; font-weight: 800; letter-spacing: .04em;
        padding: 3px 9px; border-radius: 50px; color: #fff;
    }
    .badge-hot-r { background: var(--ju-red); animation: badgePulse 1.8s infinite; }
    .badge-new-g { background: var(--ju-navy); }
    .badge-sold-g { background: var(--ju-muted); }
    @keyframes badgePulse { 0%,100%{opacity:1} 50%{opacity:.75} }

    .prod-body { padding: 14px 16px 16px; }
    .prod-category { font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--ju-navy); margin-bottom: 4px; }
    .prod-title { font-weight: 700; font-size: 15px; color: var(--ju-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 6px; }
    .prod-seller { font-size: 12px; color: var(--ju-muted); display: flex; align-items: center; gap: 4px; margin-bottom: 10px; }
    .prod-seller .verified-dot { color: #16a34a; }
    .prod-price { font-family: 'Crimson Pro', serif; font-size: 1.4rem; font-weight: 700; color: var(--ju-navy); }
    .prod-condition { font-size: 11px; background: var(--ju-surface); color: var(--ju-muted); padding: 3px 10px; border-radius: 50px; border: 1px solid var(--ju-border); }
    .prod-cta {
        display: block; width: 100%; margin-top: 12px;
        background: var(--ju-navy); color: #fff;
        text-align: center; border-radius: 8px;
        padding: 9px 0; font-size: 13.5px; font-weight: 700;
        text-decoration: none; transition: all .25s;
        letter-spacing: .02em;
    }
    .prod-cta:hover { background: var(--ju-navy-mid); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,48,135,.25); }

    /* Quick-view on hover */
    .quick-view-overlay {
        position: absolute; inset: 0;
        background: rgba(0,30,87,.6);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity .3s;
        z-index: 3;
    }
    .prod-img-wrap:hover .quick-view-overlay { opacity: 1; }
    .quick-view-btn {
        background: var(--ju-gold); color: var(--ju-navy-dark);
        border: none; border-radius: 8px;
        padding: 9px 20px; font-weight: 800; font-size: 13px;
        cursor: pointer; letter-spacing: .04em;
        transition: transform .2s;
    }
    .quick-view-btn:hover { transform: scale(1.05); }

    /* ── Step cards ──────────────────────────────────────────────── */
    .step-card {
        background: #fff;
        border: 1px solid var(--ju-border);
        border-radius: 16px; padding: 32px 24px;
        text-align: center; position: relative;
        transition: all .35s;
    }
    .step-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(0,48,135,.13); border-color: var(--ju-navy); }
    .step-icon-wrap {
        width: 72px; height: 72px; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 18px; font-size: 28px; color: #fff;
        position: relative;
    }
    .step-icon-wrap::after {
        content: attr(data-step);
        position: absolute; top: -8px; right: -10px;
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--ju-gold); color: var(--ju-navy-dark);
        font-size: 11px; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff;
    }
    .step-connector {
        position: absolute; top: 36px; right: -50%;
        width: 100%; height: 2px;
        background: linear-gradient(90deg, var(--ju-border), transparent);
    }
    .step-title { font-family: 'Crimson Pro', serif; font-size: 1.25rem; font-weight: 700; color: var(--ju-text); margin-bottom: 8px; }
    .step-desc { font-size: 13.5px; color: var(--ju-muted); line-height: 1.65; }

    /* ── Testimonials ────────────────────────────────────────────── */
    .testi-card {
        background: #fff;
        border: 1px solid var(--ju-border);
        border-radius: 16px; padding: 24px;
        transition: all .35s;
        position: relative;
    }
    .testi-card::before {
        content: '\201C';
        font-family: 'Crimson Pro', serif;
        font-size: 5rem; line-height: 1;
        color: var(--ju-navy); opacity: .08;
        position: absolute; top: 10px; left: 16px;
    }
    .testi-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,48,135,.12); border-color: var(--ju-navy); }
    .testi-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2.5px solid var(--ju-gold); }
    .testi-name { font-weight: 700; font-size: 15px; color: var(--ju-text); }
    .testi-uni { font-size: 12px; color: var(--ju-navy); font-weight: 600; }
    .testi-body { font-size: 13.5px; color: var(--ju-muted); line-height: 1.7; font-style: italic; margin-top: 12px; }
    .testi-verified { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: #16a34a; margin-top: 12px; }

    /* ── JU Spotlight ────────────────────────────────────────────── */
    .spotlight-box {
        background: linear-gradient(135deg, var(--ju-navy-dark) 0%, var(--ju-navy) 100%);
        border: 2px solid var(--ju-gold);
        border-radius: 20px; overflow: hidden;
        position: relative;
    }
    .spotlight-box::before {
        content: '';
        position: absolute; top: -60%; right: -10%;
        width: 55%; height: 220%;
        background: radial-gradient(ellipse, rgba(200,150,12,.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .spotlight-stat { text-align: center; padding: 8px 20px; }
    .spotlight-stat-val { font-family: 'Crimson Pro', serif; font-size: 1.8rem; font-weight: 700; color: var(--ju-gold); line-height: 1; }
    .spotlight-stat-lbl { font-size: 11px; color: rgba(255,255,255,.6); margin-top: 2px; }
    .spotlight-divider { width: 1px; background: rgba(255,255,255,.12); align-self: stretch; }

    /* ── Trust/feature bar ───────────────────────────────────────── */
    .trust-bar {
        background: #fff;
        border-top: 1px solid var(--ju-border);
        border-bottom: 1px solid var(--ju-border);
    }
    .trust-item {
        display: flex; align-items: center; gap: 12px;
        padding: 18px 24px;
        border-right: 1px solid var(--ju-border);
        flex: 1;
    }
    .trust-item:last-child { border-right: none; }
    .trust-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(0,48,135,.08); display: flex; align-items: center; justify-content: center; color: var(--ju-navy); font-size: 18px; flex-shrink: 0; }
    .trust-label { font-weight: 700; font-size: 13.5px; color: var(--ju-text); }
    .trust-sub { font-size: 11.5px; color: var(--ju-muted); }

    /* ── CTA section ─────────────────────────────────────────────── */
    .cta-box {
        background: linear-gradient(135deg, var(--ju-navy-dark) 0%, var(--ju-navy) 60%, #004fa3 100%);
        border-radius: 20px; padding: 60px 48px;
        text-align: center; position: relative; overflow: hidden;
    }
    .cta-box::before {
        content: '';
        position: absolute; top: -50%; left: -10%;
        width: 50%; height: 200%;
        background: radial-gradient(ellipse, rgba(200,150,12,.12) 0%, transparent 65%);
    }
    .cta-box::after {
        content: '';
        position: absolute; bottom: -20%; right: -5%;
        width: 280px; height: 280px; border-radius: 50%;
        background: rgba(255,255,255,.03);
    }
    .cta-box h2 { font-family: 'Crimson Pro', serif; font-size: 2.8rem; color: #fff; font-weight: 700; line-height: 1.2; }
    .cta-box p { color: rgba(255,255,255,.75); font-size: 1.05rem; margin-top: 10px; }

    .cta-btn-main {
        background: var(--ju-gold); color: var(--ju-navy-dark);
        font-weight: 800; border-radius: 10px;
        padding: 14px 36px; font-size: 15px;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all .25s;
        box-shadow: 0 4px 20px rgba(200,150,12,.4);
    }
    .cta-btn-main:hover { background: var(--ju-gold-lt); transform: translateY(-3px); box-shadow: 0 10px 30px rgba(200,150,12,.5); }
    .cta-btn-sec {
        background: rgba(255,255,255,.12); color: #fff;
        border: 1.5px solid rgba(255,255,255,.3);
        font-weight: 700; border-radius: 10px;
        padding: 13px 28px; font-size: 15px;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all .25s;
    }
    .cta-btn-sec:hover { background: rgba(255,255,255,.22); border-color: var(--ju-gold); color: var(--ju-gold); }

    /* ── Recently Viewed (new feature) ──────────────────────────── */
    .scroll-row { display: flex; gap: 16px; overflow-x: auto; padding-bottom: 8px; scroll-snap-type: x mandatory; }
    .scroll-row::-webkit-scrollbar { height: 4px; }
    .scroll-row::-webkit-scrollbar-thumb { background: var(--ju-navy); border-radius: 4px; }
    .scroll-item { flex-shrink: 0; scroll-snap-align: start; }

    /* ── Filter tabs ─────────────────────────────────────────────── */
    .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
    .filter-tab {
        padding: 6px 18px; border-radius: 50px;
        border: 1.5px solid var(--ju-border);
        background: #fff; color: var(--ju-muted);
        font-size: 13px; font-weight: 600; cursor: pointer;
        transition: all .2s;
    }
    .filter-tab:hover, .filter-tab.active {
        background: var(--ju-navy); border-color: var(--ju-navy); color: #fff;
    }
    .filter-tab.gold.active { background: var(--ju-gold); border-color: var(--ju-gold); color: var(--ju-navy-dark); }

    /* ── Floating search pill (NEW) ──────────────────────────────── */
    .floating-search-pill {
        position: fixed; bottom: 28px; right: 28px; z-index: 40;
        background: var(--ju-navy);
        color: #fff; border: none;
        border-radius: 50px; padding: 13px 22px;
        font-size: 14px; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; gap: 10px;
        box-shadow: 0 8px 30px rgba(0,30,87,.35);
        transition: all .3s;
        text-decoration: none;
    }
    .floating-search-pill:hover { background: var(--ju-navy-mid); transform: translateY(-3px); box-shadow: 0 14px 40px rgba(0,30,87,.45); }
    .floating-search-pill .pill-icon { width: 28px; height: 28px; background: var(--ju-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--ju-navy-dark); font-size: 13px; flex-shrink: 0; }

    /* ── Scroll-to-top button ────────────────────────────────────── */
    #scrollTop {
        position: fixed; bottom: 28px; left: 28px; z-index: 40;
        width: 42px; height: 42px; border-radius: 50%;
        background: #fff; border: 1.5px solid var(--ju-border);
        color: var(--ju-navy); font-size: 16px;
        display: none; align-items: center; justify-content: center;
        cursor: pointer; transition: all .25s;
        box-shadow: 0 4px 16px rgba(0,30,87,.15);
    }
    #scrollTop.show { display: flex; }
    #scrollTop:hover { background: var(--ju-navy); color: #fff; border-color: var(--ju-navy); transform: translateY(-2px); }

    /* ── Responsive tweaks ───────────────────────────────────────── */
    @media (max-width: 768px) {
        .hero-section { padding: 48px 0; }
        .cta-box { padding: 40px 24px; }
        .cta-box h2 { font-size: 2rem; }
        .trust-item { flex-direction: column; text-align: center; }
    }
</style>

{{-- ════════════════════════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════════════════════════ --}}
<section class="hero-section py-20" data-aos="fade-in">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid md:grid-cols-2 gap-14 items-center">

            {{-- Left: copy --}}
            <div data-aos="fade-right" data-aos-delay="100">
                {{-- Live badge --}}
                <div class="live-badge mb-4">
                    <span class="live-dot"></span>
                    Live Marketplace &mdash; 1,500+ Active Students
                </div>

                <h1 style="font-family:'Crimson Pro',serif;font-size:clamp(2.5rem,5vw,3.6rem);font-weight:700;color:#fff;line-height:1.15;margin-bottom:16px">
                    Buy &amp; Sell<br>
                    <span style="color:var(--ju-gold)">On Campus,</span><br>
                    Safely &amp; Fast
                </h1>

                <p style="font-size:1.05rem;color:rgba(255,255,255,.75);max-width:480px;line-height:1.7;margin-bottom:28px">
                    The trusted marketplace built exclusively for Ethiopian university students.
                    Find great deals or sell what you no longer need — all within your campus community.
                </p>

                {{-- CTA buttons --}}
                <div class="flex gap-3 flex-wrap" style="margin-bottom:32px">
                    <a href="{{ route('listings.index') }}" style="background:var(--ju-gold);color:var(--ju-navy-dark);font-weight:800;border-radius:10px;padding:13px 28px;font-size:15px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s;box-shadow:0 4px 20px rgba(200,150,12,.35)"
                        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 30px rgba(200,150,12,.5)'"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 4px 20px rgba(200,150,12,.35)'">
                        <i class="fas fa-store"></i> Start Shopping
                    </a>
                    @guest
                        <a href="{{ route('register') }}" style="background:rgba(255,255,255,.1);color:#fff;border:1.5px solid rgba(255,255,255,.3);font-weight:700;border-radius:10px;padding:12px 24px;font-size:15px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s"
                            onmouseover="this.style.borderColor='var(--ju-gold)';this.style.color='var(--ju-gold)'"
                            onmouseout="this.style.borderColor='rgba(255,255,255,.3)';this.style.color='#fff'">
                            <i class="fas fa-user-plus"></i> Join Free
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('listings.create') }}" style="background:rgba(255,255,255,.1);color:#fff;border:1.5px solid rgba(255,255,255,.3);font-weight:700;border-radius:10px;padding:12px 24px;font-size:15px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s"
                            onmouseover="this.style.borderColor='var(--ju-gold)';this.style.color='var(--ju-gold)'"
                            onmouseout="this.style.borderColor='rgba(255,255,255,.3)';this.style.color='#fff'">
                            <i class="fas fa-plus-circle"></i> Sell an Item
                        </a>
                    @endauth
                </div>

                {{-- Stats row --}}
                <div style="display:flex;align-items:center;gap:0;padding-top:24px;border-top:1px solid rgba(255,255,255,.12);border-radius:12px;background:rgba(255,255,255,.05);padding:16px 20px;gap:0">
                    <div style="flex:1;text-align:center">
                        <div class="hero-stat-value" data-target="1500">0</div>
                        <div class="hero-stat-label">Active Students</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div style="flex:1;text-align:center">
                        <div class="hero-stat-value" data-target="2500">0</div>
                        <div class="hero-stat-label">Items Sold</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div style="flex:1;text-align:center">
                        <div class="hero-stat-value" data-target="12">0</div>
                        <div class="hero-stat-label">Universities</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div style="flex:1;text-align:center">
                        <div class="hero-stat-value">98%</div>
                        <div class="hero-stat-label">Success Rate</div>
                    </div>
                </div>
            </div>

            {{-- Right: image --}}
            <div class="hidden md:block" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-img-frame floating">
                    <img src="https://images.pexels.com/photos/267885/pexels-photo-267885.jpeg?auto=compress&cs=tinysrgb&w=700"
                         alt="Jimma University Students Trading">
                    <div class="hero-img-badge">
                        <p style="font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:6px">
                            <i class="fas fa-university" style="color:var(--ju-gold)"></i>
                            Jimma University &mdash; Main Campus
                        </p>
                        <p style="font-size:11px;color:rgba(255,255,255,.65);margin-top:3px">Trusted by 500+ JU students</p>
                    </div>
                </div>

                {{-- floating mini stats --}}
                <div style="display:flex;gap:10px;margin-top:14px">
                    <div style="flex:1;background:rgba(255,255,255,.08);border:1px solid rgba(200,150,12,.3);border-radius:12px;padding:12px 16px;backdrop-filter:blur(8px)">
                        <div style="font-size:11px;color:rgba(255,255,255,.55);margin-bottom:2px"><i class="fas fa-fire" style="color:var(--ju-gold)"></i> Trending Today</div>
                        <div style="font-size:14px;font-weight:700;color:#fff">Electronics &amp; Phones</div>
                    </div>
                    <div style="flex:1;background:rgba(255,255,255,.08);border:1px solid rgba(200,150,12,.3);border-radius:12px;padding:12px 16px;backdrop-filter:blur(8px)">
                        <div style="font-size:11px;color:rgba(255,255,255,.55);margin-bottom:2px"><i class="fas fa-tag" style="color:var(--ju-gold)"></i> Avg. Saving</div>
                        <div style="font-size:14px;font-weight:700;color:#fff">Up to 60% Off</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     TRUST BAR  (NEW — social proof strip)
════════════════════════════════════════════════════════════════ --}}
<div class="trust-bar" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <div class="trust-label">Secure Payments</div>
                    <div class="trust-sub">Powered by Chapa</div>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-id-badge"></i></div>
                <div>
                    <div class="trust-label">Verified Students</div>
                    <div class="trust-sub">University email &amp; ID checked</div>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-comments"></i></div>
                <div>
                    <div class="trust-label">In-App Messaging</div>
                    <div class="trust-sub">Chat directly with sellers</div>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-star"></i></div>
                <div>
                    <div class="trust-label">Rated 4.9 / 5</div>
                    <div class="trust-sub">By 1,500+ active users</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════
     CATEGORIES
════════════════════════════════════════════════════════════════ --}}
<section style="padding:72px 0" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center" style="margin-bottom:48px">
            <div class="section-eyebrow">What are you looking for?</div>
            <h2 class="section-title" style="margin-top:8px">Browse <span>Categories</span></h2>
            <div class="gold-divider"></div>
            <p style="color:var(--ju-muted);margin-top:14px;font-size:15px">Find exactly what you need from your fellow students</p>
        </div>

        @php
            $categories = [
                ['name'=>'Electronics','icon'=>'fa-laptop',    'count'=>'234','color'=>'#003087'],
                ['name'=>'Textbooks',  'icon'=>'fa-book',      'count'=>'567','color'=>'#004fa3'],
                ['name'=>'Furniture',  'icon'=>'fa-couch',     'count'=>'89', 'color'=>'#0062b8'],
                ['name'=>'Clothing',   'icon'=>'fa-tshirt',    'count'=>'456','color'=>'#C8960C'],
                ['name'=>'Vehicles',   'icon'=>'fa-car',       'count'=>'45', 'color'=>'#a37208'],
                ['name'=>'Other',      'icon'=>'fa-ellipsis-h','count'=>'123','color'=>'#5a6480'],
            ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('listings.index', ['category' => $cat['name']]) }}"
                   class="cat-card"
                   data-aos="zoom-in"
                   data-aos-delay="{{ $loop->index * 60 }}">
                    <div class="cat-icon" style="background:{{ $cat['color'] }}">
                        <i class="fas {{ $cat['icon'] }}"></i>
                    </div>
                    <div class="cat-name">{{ $cat['name'] }}</div>
                    <div class="cat-count">{{ $cat['count'] }} items</div>
                    <div class="cat-arrow"><i class="fas fa-arrow-right"></i> Browse</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     FEATURED LISTINGS  (with filter tabs — NEW)
════════════════════════════════════════════════════════════════ --}}
<section style="padding:72px 0;background:var(--ju-surface)" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Header + filter tabs --}}
        <div class="flex flex-wrap justify-between items-start gap-4" style="margin-bottom:32px">
            <div>
                <div class="section-eyebrow">This Week's Picks</div>
                <h2 class="section-title" style="margin-top:6px">
                    <i class="fas fa-fire" style="color:var(--ju-red);font-size:1.6rem;vertical-align:middle;margin-right:6px"></i>
                    Featured <span>Listings</span>
                </h2>
                <div class="gold-divider" style="margin:10px 0 0"></div>
            </div>
            <a href="{{ route('listings.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;color:var(--ju-navy);font-weight:700;font-size:14px;text-decoration:none;margin-top:8px;border:1.5px solid var(--ju-navy);padding:7px 18px;border-radius:8px;transition:all .2s"
               onmouseover="this.style.background='var(--ju-navy)';this.style.color='#fff'"
               onmouseout="this.style.background='';this.style.color='var(--ju-navy)'">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- Filter tabs (NEW) --}}
        <div class="filter-tabs" style="margin-bottom:28px" id="listingFilterTabs">
            <button class="filter-tab active" data-filter="all">All</button>
            <button class="filter-tab" data-filter="Electronics">Electronics</button>
            <button class="filter-tab" data-filter="Textbooks">Textbooks</button>
            <button class="filter-tab" data-filter="Furniture">Furniture</button>
            <button class="filter-tab" data-filter="Clothing">Clothing</button>
            <button class="filter-tab gold active" data-filter="hot" style="border-color:var(--ju-red);color:var(--ju-red)">
                <i class="fas fa-fire"></i> Hot Deals
            </button>
        </div>

        @php
            $listings = App\Models\Listing::active()->with('user','photos')->latest()->limit(8)->get();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="listingsGrid">
            @forelse($listings as $listing)
                <div class="prod-card"
                     data-category="{{ $listing->category }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ $loop->index * 60 }}">

                    {{-- Image --}}
                    <div class="prod-img-wrap">
                        @if($listing->photos->first())
                            <img class="lazy-image" data-src="{{ $listing->photos->first()->photo_path }}" alt="{{ $listing->title }}" style="width:100%;height:200px;object-fit:cover">
                        @else
                            <div style="width:100%;height:200px;background:var(--ju-surface);display:flex;align-items:center;justify-content:center">
                                <i class="fas fa-image" style="font-size:2.5rem;color:var(--ju-border)"></i>
                            </div>
                        @endif

                        {{-- Badge --}}
                        <span class="prod-badge {{ $loop->index < 3 ? 'badge-hot-r' : 'badge-new-g' }}">
                            {{ $loop->index < 3 ? '🔥 HOT' : 'NEW' }}
                        </span>

                        {{-- Wishlist --}}
                        <button class="wish-btn" onclick="toggleWish(this, {{ $listing->id }})" title="Save to favorites">
                            <i class="fas fa-heart"></i>
                        </button>

                        {{-- Quick view overlay (NEW) --}}
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="window.location='{{ route('listings.show', $listing) }}'">
                                <i class="fas fa-eye mr-1"></i> Quick View
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="prod-body">
                        <div class="prod-category">{{ $listing->category }}</div>
                        <div class="prod-title">{{ Str::limit($listing->title, 38) }}</div>
                        <div class="prod-seller">
                            <i class="fas fa-user-circle" style="color:var(--ju-navy)"></i>
                            {{ $listing->user->name }}
                            @if($listing->user->is_verified_seller)
                                <i class="fas fa-check-circle verified-dot" title="Verified Seller"></i>
                            @endif
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                            <span class="prod-price">ETB {{ number_format($listing->price, 2) }}</span>
                            <span class="prod-condition">{{ $listing->condition }}</span>
                        </div>
                        <a href="{{ route('listings.show', $listing) }}" class="prod-cta">
                            <i class="fas fa-eye" style="font-size:12px"></i> View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16" style="color:var(--ju-muted)">
                    <i class="fas fa-box-open" style="font-size:3rem;margin-bottom:12px;display:block;opacity:.4"></i>
                    No listings yet — be the first to sell!
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     HOW IT WORKS
════════════════════════════════════════════════════════════════ --}}
<section style="padding:72px 0" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center" style="margin-bottom:52px">
            <div class="section-eyebrow">Simple &amp; Safe</div>
            <h2 class="section-title" style="margin-top:8px">How It <span>Works</span></h2>
            <div class="gold-divider"></div>
            <p style="color:var(--ju-muted);margin-top:14px;font-size:15px">Three easy steps to start trading with your campus community</p>
        </div>

        @php
            $steps = [
                ['step'=>'1','title'=>'Create Your Account','desc'=>'Sign up with your university email in under 60 seconds. Optionally verify your student ID for a trusted badge.','icon'=>'fa-user-graduate','color'=>'#003087'],
                ['step'=>'2','title'=>'Browse or List Items','desc'=>'Search thousands of student listings or post your own item with photos, price, and condition details.','icon'=>'fa-search','color'=>'#C8960C'],
                ['step'=>'3','title'=>'Trade Safely on Campus','desc'=>'Message sellers directly, agree on a meet-up spot, and pay securely via Chapa with buyer protection.','icon'=>'fa-handshake','color'=>'#16a34a'],
            ];
        @endphp

        <div class="grid md:grid-cols-3 gap-8" style="position:relative">
            @foreach($steps as $i => $step)
                <div class="step-card" data-aos="flip-left" data-aos-delay="{{ $loop->index * 120 }}">
                    <div class="step-icon-wrap floating" style="background:{{ $step['color'] }}" data-step="{{ $step['step'] }}">
                        <i class="fas {{ $step['icon'] }}"></i>
                    </div>
                    <div class="step-title">{{ $step['title'] }}</div>
                    <p class="step-desc">{{ $step['desc'] }}</p>
                    @if(!$loop->last)
                        <div style="display:none" class="md:block step-connector"></div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Video / tutorial CTA (NEW) --}}
        <div class="text-center" style="margin-top:40px">
            <a href="{{ route('listings.index') }}"
               style="display:inline-flex;align-items:center;gap:10px;background:var(--ju-surface);border:1.5px solid var(--ju-border);color:var(--ju-navy);font-weight:700;font-size:14px;border-radius:10px;padding:12px 24px;text-decoration:none;transition:all .25s"
               onmouseover="this.style.borderColor='var(--ju-navy)';this.style.boxShadow='0 8px 24px rgba(0,48,135,.12)'"
               onmouseout="this.style.borderColor='var(--ju-border)';this.style.boxShadow=''">
                <i class="fas fa-play-circle" style="color:var(--ju-gold);font-size:18px"></i>
                Explore the Marketplace Now
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     TESTIMONIALS
════════════════════════════════════════════════════════════════ --}}
<section style="padding:72px 0;background:var(--ju-surface)" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center" style="margin-bottom:52px">
            <div class="section-eyebrow">Student Reviews</div>
            <h2 class="section-title" style="margin-top:8px">What <span class="gold">Students</span> Say</h2>
            <div class="gold-divider"></div>
            <p style="color:var(--ju-muted);margin-top:14px;font-size:15px">Trusted by students across Ethiopian universities</p>
        </div>

        @php
            $testimonials = [
                ['name'=>'Almaz Bekele',  'uni'=>'Jimma University',      'text'=>'I sold my old laptop within 3 days! Campus Trade is amazing. The payment system is secure and fast.','rating'=>5,'image'=>'https://randomuser.me/api/portraits/women/1.jpg'],
                ['name'=>'Dawit Tesfaye', 'uni'=>'Addis Ababa University','text'=>'Found all my textbooks at half price. The messaging feature makes negotiating with sellers easy.','rating'=>5,'image'=>'https://randomuser.me/api/portraits/men/2.jpg'],
                ['name'=>'Sara Mohammed', 'uni'=>'Jimma University',      'text'=>'I bought a like-new smartphone and the seller was very responsive. Best student marketplace in Ethiopia!','rating'=>5,'image'=>'https://randomuser.me/api/portraits/women/3.jpg'],
                ['name'=>'Henok Gashaw',  'uni'=>'Bahir Dar University',  'text'=>'The Chapa payment integration is seamless. I received my money instantly after selling my guitar.','rating'=>5,'image'=>'https://randomuser.me/api/portraits/men/4.jpg'],
                ['name'=>'Meron Ayele',   'uni'=>'Jimma University',      'text'=>'Campus Trade helped me find affordable furniture for my dorm. Highly recommended for all students!','rating'=>4,'image'=>'https://randomuser.me/api/portraits/women/5.jpg'],
                ['name'=>'Yonas Abera',   'uni'=>'Hawassa University',    'text'=>'Sold two items already. User-friendly platform and the support team is incredibly helpful.','rating'=>5,'image'=>'https://randomuser.me/api/portraits/men/6.jpg'],
            ];
        @endphp

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
                <div class="testi-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="position:relative">
                            <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}" class="testi-avatar">
                            <div style="position:absolute;bottom:-2px;right:-2px;width:14px;height:14px;background:#16a34a;border-radius:50%;border:2px solid #fff"></div>
                        </div>
                        <div>
                            <div class="testi-name">{{ $t['name'] }}</div>
                            <div class="testi-uni"><i class="fas fa-university" style="font-size:10px;margin-right:3px"></i>{{ $t['uni'] }}</div>
                        </div>
                        {{-- Stars --}}
                        <div style="margin-left:auto;display:flex;gap:2px;color:#f59e0b;font-size:13px">
                            @for($i=1;$i<=5;$i++)
                                <i class="{{ $i <= $t['rating'] ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="testi-body">"{{ $t['text'] }}"</p>
                    <div class="testi-verified">
                        <i class="fas fa-check-circle"></i> Verified Student
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Average rating bar (NEW) --}}
        <div style="margin-top:40px;background:#fff;border:1px solid var(--ju-border);border-radius:14px;padding:24px 32px;display:flex;flex-wrap:wrap;align-items:center;gap:24px">
            <div style="text-align:center;min-width:100px">
                <div style="font-family:'Crimson Pro',serif;font-size:3.5rem;font-weight:700;color:var(--ju-navy);line-height:1">4.9</div>
                <div style="display:flex;gap:2px;justify-content:center;color:#f59e0b;font-size:14px;margin:4px 0">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <div style="font-size:12px;color:var(--ju-muted)">Overall Rating</div>
            </div>
            <div style="flex:1;min-width:200px">
                @foreach([['5 stars',92],['4 stars',6],['3 stars',2]] as $r)
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:7px">
                        <span style="font-size:12px;color:var(--ju-muted);width:50px">{{ $r[0] }}</span>
                        <div style="flex:1;height:8px;background:var(--ju-surface);border-radius:4px;overflow:hidden">
                            <div class="progress-bar" style="height:100%;background:linear-gradient(90deg,var(--ju-navy),var(--ju-gold));border-radius:4px;width:{{ $r[1] }}%"></div>
                        </div>
                        <span style="font-size:12px;color:var(--ju-muted);width:32px">{{ $r[1] }}%</span>
                    </div>
                @endforeach
            </div>
            <div style="font-size:13px;color:var(--ju-muted);max-width:220px">
                Based on <strong style="color:var(--ju-text)">1,500+</strong> verified student reviews across all Ethiopian university campuses.
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     JIMMA UNIVERSITY SPOTLIGHT
════════════════════════════════════════════════════════════════ --}}
<section style="padding:72px 0" data-aos="fade-up">
    <div class="max-w-6xl mx-auto px-4">
        <div class="spotlight-box">
            <div class="grid md:grid-cols-2 gap-0">
                {{-- Text side --}}
                <div style="padding:48px 40px;position:relative;z-index:1">
                    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(200,150,12,.15);border:1px solid rgba(200,150,12,.35);border-radius:50px;padding:5px 14px;margin-bottom:16px">
                        <i class="fas fa-graduation-cap" style="color:var(--ju-gold);font-size:14px"></i>
                        <span style="font-size:11.5px;font-weight:700;color:var(--ju-gold);letter-spacing:.06em">PROUD PARTNER</span>
                    </div>
                    <h3 style="font-family:'Crimson Pro',serif;font-size:2rem;font-weight:700;color:#fff;line-height:1.25;margin-bottom:14px">
                        Jimma University<br><span style="color:var(--ju-gold)">Student Community</span>
                    </h3>
                    <p style="color:rgba(255,255,255,.7);font-size:14.5px;line-height:1.7;margin-bottom:24px">
                        Join hundreds of JU students already buying and selling on Campus Trade.
                        The safest, most trusted marketplace for campus trading in Ethiopia.
                    </p>

                    {{-- Stats --}}
                    <div style="display:flex;flex-wrap:wrap;gap:0;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:12px;overflow:hidden;margin-bottom:24px">
                        <div class="spotlight-stat">
                            <div class="spotlight-stat-val">500+</div>
                            <div class="spotlight-stat-lbl">JU Students</div>
                        </div>
                        <div class="spotlight-divider"></div>
                        <div class="spotlight-stat">
                            <div class="spotlight-stat-val">1,200+</div>
                            <div class="spotlight-stat-lbl">Items Listed</div>
                        </div>
                        <div class="spotlight-divider"></div>
                        <div class="spotlight-stat">
                            <div class="spotlight-stat-val">98%</div>
                            <div class="spotlight-stat-lbl">Success Rate</div>
                        </div>
                    </div>

                    <a href="{{ route('register') }}"
                       style="display:inline-flex;align-items:center;gap:8px;background:var(--ju-gold);color:var(--ju-navy-dark);font-weight:800;border-radius:10px;padding:12px 26px;font-size:14px;text-decoration:none;transition:all .25s"
                       onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(200,150,12,.4)'"
                       onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <i class="fas fa-user-graduate"></i> Join JU Community
                    </a>
                </div>

                {{-- Image side --}}
                <div style="position:relative;min-height:280px;overflow:hidden">
                    <img src="https://images.pexels.com/photos/2383010/pexels-photo-2383010.jpeg?auto=compress&cs=tinysrgb&w=700"
                         alt="Jimma University Campus"
                         style="width:100%;height:100%;object-fit:cover;transition:transform .5s"
                         onmouseover="this.style.transform='scale(1.04)'"
                         onmouseout="this.style.transform=''">
                    <div style="position:absolute;inset:0;background:linear-gradient(to right,rgba(0,20,70,.6),transparent)"></div>
                    <div style="position:absolute;bottom:16px;left:16px;right:16px">
                        <div style="background:rgba(0,20,70,.75);border:1px solid rgba(200,150,12,.4);border-radius:10px;padding:12px 16px;backdrop-filter:blur(8px)">
                            <p style="color:#fff;font-size:13px;font-weight:700;display:flex;align-items:center;gap:6px">
                                <i class="fas fa-map-marker-alt" style="color:var(--ju-gold)"></i>
                                Jimma University, Main Campus
                            </p>
                            <p style="color:rgba(255,255,255,.6);font-size:11.5px;margin-top:2px">Jimma, Oromia, Ethiopia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     RECENTLY ACTIVE SELLERS (NEW FEATURE)
════════════════════════════════════════════════════════════════ --}}
<section style="padding:64px 0;background:var(--ju-surface)" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;flex-wrap:wrap;gap:12px">
            <div>
                <div class="section-eyebrow">Community</div>
                <h2 class="section-title" style="margin-top:6px;font-size:1.8rem">Top <span>Sellers</span> This Month</h2>
            </div>
            <a href="{{ route('listings.index') }}" style="font-size:13.5px;color:var(--ju-navy);font-weight:700;text-decoration:none;display:flex;align-items:center;gap:5px">
                See All Sellers <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @php
            $topSellers = App\Models\User::withCount('listings')
                ->having('listings_count', '>', 0)
                ->orderByDesc('listings_count')
                ->limit(6)
                ->get();
        @endphp
        <div class="scroll-row" id="sellersRow">
            @forelse($topSellers as $seller)
                <div class="scroll-item" style="width:180px">
                    <div style="background:#fff;border:1px solid var(--ju-border);border-radius:14px;padding:20px 14px;text-align:center;transition:all .3s;cursor:pointer"
                         onmouseover="this.style.borderColor='var(--ju-navy)';this.style.transform='translateY(-5px)';this.style.boxShadow='0 12px 30px rgba(0,48,135,.12)'"
                         onmouseout="this.style.borderColor='var(--ju-border)';this.style.transform='';this.style.boxShadow=''">
                        <div style="width:56px;height:56px;border-radius:50%;background:var(--ju-navy);color:var(--ju-gold);font-family:'Crimson Pro',serif;font-size:1.5rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;border:2.5px solid var(--ju-gold)">
                            {{ strtoupper(substr($seller->name,0,1)) }}
                        </div>
                        <div style="font-weight:700;font-size:14px;color:var(--ju-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Str::limit($seller->name, 16) }}</div>
                        <div style="font-size:12px;color:var(--ju-muted);margin-top:3px">
                            <i class="fas fa-tag" style="color:var(--ju-navy);font-size:10px"></i>
                            {{ $seller->listings_count }} listings
                        </div>
                        @if($seller->is_verified_seller)
                            <div style="margin-top:6px;font-size:11px;color:#16a34a;font-weight:700">
                                <i class="fas fa-check-circle"></i> Verified
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p style="color:var(--ju-muted);font-size:14px;padding:12px 0">No active sellers yet — be the first!</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     CTA SECTION
════════════════════════════════════════════════════════════════ --}}
<section style="padding:72px 0" data-aos="zoom-in">
    <div class="max-w-4xl mx-auto px-4">
        <div class="cta-box">
            <div style="position:relative;z-index:1">
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(200,150,12,.18);border:1px solid rgba(200,150,12,.4);border-radius:50px;padding:5px 16px;margin-bottom:20px">
                    <i class="fas fa-bolt" style="color:var(--ju-gold);font-size:13px"></i>
                    <span style="font-size:12px;font-weight:700;color:var(--ju-gold);letter-spacing:.06em">GET STARTED TODAY</span>
                </div>
                <h2>Ready to Start Trading?</h2>
                <p>Join 1,500+ Ethiopian university students already using Campus Trade</p>
                <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-top:28px">
                    @guest
                        <a href="{{ route('register') }}" class="cta-btn-main">
                            <i class="fas fa-user-graduate"></i> Create Free Account
                        </a>
                        <a href="{{ route('listings.index') }}" class="cta-btn-sec">
                            <i class="fas fa-search"></i> Browse Items
                        </a>
                    @else
                        <a href="{{ route('listings.create') }}" class="cta-btn-main">
                            <i class="fas fa-plus-circle"></i> Sell an Item
                        </a>
                        <a href="{{ route('listings.index') }}" class="cta-btn-sec">
                            <i class="fas fa-store"></i> Browse Marketplace
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════
     FLOATING ELEMENTS (UI enhancements)
════════════════════════════════════════════════════════════════ --}}

{{-- Floating Sell button (mobile-friendly) --}}
@auth
<a href="{{ route('listings.create') }}" class="floating-search-pill">
    <div class="pill-icon"><i class="fas fa-plus"></i></div>
    Sell an Item
</a>
@else
<a href="{{ route('listings.index') }}" class="floating-search-pill">
    <div class="pill-icon"><i class="fas fa-search"></i></div>
    Browse Listings
</a>
@endauth

{{-- Scroll-to-top --}}
<button id="scrollTop" title="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-chevron-up"></i>
</button>

{{-- ════════════════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════════════════ --}}
<script>
/* ── Animated Number Counter ─────────────────────────────── */
const counters = document.querySelectorAll('[data-target]');
const runCounters = () => {
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        let current = 0;
        const step = target / 80;
        const run = () => {
            current += step;
            if (current < target) {
                counter.innerText = Math.floor(current).toLocaleString();
                requestAnimationFrame(run);
            } else {
                counter.innerText = target.toLocaleString() + '+';
            }
        };
        run();
    });
};
const heroObs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { runCounters(); heroObs.disconnect(); } });
});
const heroEl = document.querySelector('.hero-section');
if (heroEl) heroObs.observe(heroEl);

/* ── Scroll-to-top button show/hide ─────────────────────── */
const scrollTopBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
    scrollTopBtn.classList.toggle('show', window.scrollY > 400);
});

/* ── Filter tabs ─────────────────────────────────────────── */
const tabs = document.querySelectorAll('.filter-tab');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const filter = tab.dataset.filter;
        document.querySelectorAll('#listingsGrid .prod-card').forEach(card => {
            const cat = card.dataset.category || '';
            if (filter === 'all' || filter === 'hot') {
                card.style.display = '';
            } else {
                card.style.display = cat === filter ? '' : 'none';
            }
        });
    });
});

/* ── Wishlist toggle (heart button) ─────────────────────── */
function toggleWish(btn, id) {
    btn.classList.toggle('active');
    const isActive = btn.classList.contains('active');
    btn.style.color = isActive ? 'var(--ju-red)' : '';
    btn.style.transform = 'scale(1.3)';
    setTimeout(() => btn.style.transform = '', 200);

    // AJAX call — fire and forget
    fetch(`/listings/${id}/favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Content-Type': 'application/json'
        }
    }).catch(() => {});
}

/* ── Lazy load images ────────────────────────────────────── */
const imgObs = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            const src = img.getAttribute('data-src');
            if (src) { img.src = src; img.removeAttribute('data-src'); }
            obs.unobserve(img);
        }
    });
});
document.querySelectorAll('.lazy-image').forEach(img => imgObs.observe(img));
</script>

@endsection