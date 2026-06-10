@extends('layouts.app-new')

@section('content')

{{-- ============================================================
     CAMPUS TRADE — Marketplace / Listings Index
     Jimma University Official Brand
     ============================================================ --}}

<style>
    :root {
        --ju-navy:       #003087;
        --ju-navy-dark:  #001f5e;
        --ju-navy-light: #0a4aad;
        --ju-gold:       #C8960C;
        --ju-gold-dark:  #a37a09;
        --ju-gold-light: #e8c04a;
        --ju-red:        #c0392b;
        --ju-green:      #1a7a3c;
        --ju-surface:    #f4f6fb;
        --ju-card:       #ffffff;
        --ju-border:     #d4dcf0;
        --ju-muted:      #5a6480;
        --ju-text:       #1a2240;
        --shadow-sm: 0 1px 3px rgba(0,48,135,.07), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md: 0 4px 18px rgba(0,48,135,.11), 0 2px 6px rgba(0,0,0,.06);
        --shadow-lg: 0 8px 32px rgba(0,48,135,.14), 0 4px 12px rgba(0,0,0,.07);
    }

    body { background: var(--ju-surface); }

    /* ── Hero Banner ── */
    .ju-hero {
        background: linear-gradient(135deg, var(--ju-navy-dark) 0%, var(--ju-navy) 55%, var(--ju-navy-light) 100%);
        border-bottom: 3px solid var(--ju-gold);
        position: relative;
        overflow: hidden;
    }
    .ju-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle at 80% 50%, rgba(200,150,12,.12) 0%, transparent 60%),
                          radial-gradient(circle at 10% 90%, rgba(255,255,255,.05) 0%, transparent 40%);
    }
    .ju-hero-inner { position: relative; z-index: 1; }

    /* ── Shield SVG ── */
    .ju-shield-wrap {
        width: 64px; height: 64px;
        border-radius: 16px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Filter Card ── */
    .ju-filter-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    /* ── Search Input ── */
    .ju-input {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid var(--ju-border);
        border-radius: 10px;
        background: var(--ju-surface);
        color: var(--ju-text);
        font-size: .9rem;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .ju-input::placeholder { color: var(--ju-muted); opacity: .7; }
    .ju-input:focus { border-color: var(--ju-navy); box-shadow: 0 0 0 3px rgba(0,48,135,.12); }

    .ju-input-icon { position: relative; }
    .ju-input-icon i {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--ju-muted); pointer-events: none; font-size: .85rem;
    }
    .ju-input-icon .ju-input { padding-left: 36px; }

    /* ── Buttons ── */
    .ju-btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px;
        background: var(--ju-navy);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: .9rem;
        cursor: pointer;
        transition: background .2s, box-shadow .2s, transform .15s;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,48,135,.25);
    }
    .ju-btn-primary:hover {
        background: var(--ju-navy-dark);
        box-shadow: 0 4px 16px rgba(0,48,135,.3);
        transform: translateY(-1px);
        color: #fff;
    }

    .ju-btn-ghost {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px;
        background: transparent;
        color: var(--ju-muted);
        border: 1px solid var(--ju-border);
        border-radius: 10px;
        font-weight: 600;
        font-size: .9rem;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }
    .ju-btn-ghost:hover { background: var(--ju-surface); color: var(--ju-navy); border-color: var(--ju-navy); }

    .ju-btn-gold {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 28px;
        background: var(--ju-gold);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: .9rem;
        cursor: pointer;
        transition: background .2s, box-shadow .2s, transform .15s;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(200,150,12,.35);
    }
    .ju-btn-gold:hover { background: var(--ju-gold-dark); transform: translateY(-1px); color: #fff; }

    /* ── Product Card ── */
    .product-card {
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: box-shadow .25s, transform .25s;
        display: flex; flex-direction: column;
    }
    .product-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }

    /* ── Product Image ── */
    .product-img-wrap {
        position: relative;
        height: 196px;
        background: var(--ju-surface);
        overflow: hidden;
    }
    .product-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .product-card:hover .product-img-wrap img { transform: scale(1.05); }

    .product-img-placeholder {
        width: 100%; height: 100%;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #eef1f8, #e4e8f4);
    }

    /* ── HOT badge ── */
    .badge-hot {
        display: inline-flex; align-items: center; gap: 4px;
        background: var(--ju-red);
        color: #fff;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: 3px 9px;
        border-radius: 99px;
        box-shadow: 0 2px 8px rgba(192,57,43,.35);
    }

    /* ── Category pill on card ── */
    .cat-pill {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(0,48,135,.07);
        color: var(--ju-navy);
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 99px;
    }

    .cond-pill {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(90,100,128,.07);
        color: var(--ju-muted);
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 99px;
    }

    /* ── Card body ── */
    .product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 6px; }

    .product-title {
        font-weight: 700;
        font-size: .95rem;
        color: var(--ju-text);
        line-clamp: 1;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color .2s;
    }
    .product-title:hover { color: var(--ju-navy); }

    .product-price {
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--ju-gold-dark);
        letter-spacing: -.01em;
    }

    .product-seller {
        font-size: .8rem;
        color: var(--ju-muted);
        display: flex; align-items: center; gap: 5px;
    }

    /* ── Favourite Button ── */
    .fav-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.18);
        transition: background .2s, transform .2s, box-shadow .2s;
        z-index: 10;
        outline: none;
        padding: 0;
    }
    .fav-btn:hover {
        background: #fff;
        box-shadow: 0 4px 16px rgba(192, 57, 43, .22);
        transform: scale(1.12);
    }
    .fav-btn:active { transform: scale(0.95); }

    .fav-btn i {
        font-size: .95rem;
        transition: color .2s, transform .3s;
        pointer-events: none;
    }
    /* un-favourited state */
    .fav-btn.fav-off i {
        color: #b0b8cc;
    }
    .fav-btn.fav-on i {
        color: var(--ju-red);
    }

    /* heart-pop animation when toggled on */
    @keyframes heart-pop {
        0%   { transform: scale(1); }
        40%  { transform: scale(1.45); }
        70%  { transform: scale(.85); }
        100% { transform: scale(1); }
    }
    .fav-btn.fav-popping i { animation: heart-pop .38s ease forwards; }

    /* ── View Details btn ── */
    .view-details-btn {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 9px 0;
        background: var(--ju-navy);
        color: #fff;
        border-radius: 9px;
        font-size: .85rem;
        font-weight: 600;
        margin-top: auto;
        text-decoration: none;
        transition: background .2s, box-shadow .2s;
    }
    .view-details-btn:hover { background: var(--ju-navy-dark); color: #fff; box-shadow: 0 4px 12px rgba(0,48,135,.25); }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: var(--ju-card);
        border-radius: 20px;
        border: 1px solid var(--ju-border);
        box-shadow: var(--shadow-sm);
    }
    .empty-icon-wrap {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: var(--ju-surface);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }

    /* ── Pagination override ── */
    nav[aria-label] { margin-top: 12px; }
    .pagination { display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; list-style: none; padding: 0; margin: 0; }
    .page-item .page-link {
        padding: 8px 16px;
        border-radius: 9px;
        background: var(--ju-card);
        border: 1px solid var(--ju-border);
        color: var(--ju-navy);
        font-weight: 600;
        font-size: .85rem;
        transition: all .15s;
        text-decoration: none;
        display: block;
    }
    .page-item.active .page-link { background: var(--ju-navy); border-color: var(--ju-navy); color: #fff; }
    .page-item .page-link:hover:not(.active) { background: var(--ju-surface); border-color: var(--ju-navy); }
    .page-item.disabled .page-link { opacity: .45; pointer-events: none; }

    /* ── Results count bar ── */
    .results-bar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 0;
        font-size: .88rem;
        color: var(--ju-muted);
        flex-wrap: wrap; gap: 8px;
    }

    /* ── Filter label ── */
    .filter-label {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--ju-muted);
        margin-bottom: 6px;
        display: block;
    }

    /* ── Toast notification ── */
    #fav-toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(80px);
        background: var(--ju-navy-dark);
        color: #fff;
        padding: 11px 22px;
        border-radius: 50px;
        font-size: .85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 24px rgba(0,0,0,.22);
        z-index: 9999;
        opacity: 0;
        transition: opacity .3s, transform .3s;
        pointer-events: none;
        white-space: nowrap;
    }
    #fav-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    #fav-toast .toast-icon { font-size: 1rem; }
</style>

{{-- ── Hero Banner ── --}}
<div class="ju-hero">
    <div class="ju-hero-inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="ju-shield-wrap">
                    <svg viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                        <path d="M20 2L3 9V24C3 33.6 10.5 42.4 20 44C29.5 42.4 37 33.6 37 24V9L20 2Z" fill="#C8960C" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                        <path d="M20 7L8 12.5V24C8 31.2 13.3 37.8 20 39.5C26.7 37.8 32 31.2 32 24V12.5L20 7Z" fill="#001f5e"/>
                        <text x="20" y="28" text-anchor="middle" fill="#C8960C" font-size="12" font-weight="700" font-family="Georgia,serif">JU</text>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase mb-1" style="color:rgba(200,150,12,.9)">
                        Jimma University · Campus Trade
                    </p>
                    <h1 class="text-4xl font-extrabold text-white leading-tight tracking-tight">Marketplace</h1>
                    <p class="mt-1 text-base" style="color:rgba(255,255,255,.65)">
                        Discover deals from fellow Jimma University students
                    </p>
                </div>
            </div>

            @auth
            @if(auth()->user()->id_verification_status == 'approved')
            <a href="{{ route('listings.create') }}" class="ju-btn-gold flex-shrink-0">
                <i class="fas fa-plus-circle"></i> Post a Listing
            </a>
            @else
            <a href="{{ route('id-verification.show') }}" class="ju-btn-gold flex-shrink-0">
                <i class="fas fa-id-card"></i> Verify to Sell
            </a>
            @endif
            @else
            <a href="{{ route('login') }}" class="ju-btn-gold flex-shrink-0">
                <i class="fas fa-sign-in-alt"></i> Sign In to Sell
            </a>
            @endauth
        </div>

        {{-- ── Quick stats strip ── --}}
        <div class="mt-8 flex flex-wrap gap-6">
            @foreach([
                ['fas fa-tag',          '42K+',   'Active Students'],
                ['fas fa-store',        '10K+',   'Listed Items'],
                ['fas fa-shield-alt',   '100%',   'Verified Only'],
                ['fas fa-map-marker-alt','On-Campus','Jimma, Ethiopia'],
            ] as $stat)
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background:rgba(200,150,12,.15); color:#e8c04a">
                    <i class="{{ $stat[0] }} text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-tight">{{ $stat[1] }}</p>
                    <p class="text-xs" style="color:rgba(255,255,255,.5)">{{ $stat[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Main Content ── --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── Filter Card ── --}}
    <div class="ju-filter-card p-5 mb-8">
        <form method="GET" action="{{ route('listings.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Search --}}
                <div>
                    <label class="filter-label">Search</label>
                    <div class="ju-input-icon">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="ju-input"
                               placeholder="Search items…" value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Category --}}
                <div>
                    <label class="filter-label">Category</label>
                    <select name="category" class="ju-input">
                        <option value="">All Categories</option>
                        @foreach([
                            ['Electronics','📱'],
                            ['Textbooks','📚'],
                            ['Furniture','🪑'],
                            ['Clothing','👕'],
                            ['Vehicles','🚗'],
                        ] as $cat)
                        <option value="{{ $cat[0] }}" {{ request('category') == $cat[0] ? 'selected' : '' }}>
                            {{ $cat[1] }} {{ $cat[0] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Min Price --}}
                <div>
                    <label class="filter-label">Min Price (ETB)</label>
                    <div class="ju-input-icon">
                        <i class="fas fa-coins"></i>
                        <input type="number" name="min_price" class="ju-input"
                               placeholder="0" value="{{ request('min_price') }}" min="0">
                    </div>
                </div>

                {{-- Max Price --}}
                <div>
                    <label class="filter-label">Max Price (ETB)</label>
                    <div class="ju-input-icon">
                        <i class="fas fa-coins"></i>
                        <input type="number" name="max_price" class="ju-input"
                               placeholder="Any" value="{{ request('max_price') }}" min="0">
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mt-4 pt-4" style="border-top:1px solid var(--ju-border)">
                <button type="submit" class="ju-btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <a href="{{ route('listings.index') }}" class="ju-btn-ghost">
                    <i class="fas fa-times"></i> Clear All
                </a>

                @if(request()->hasAny(['search','category','min_price','max_price']))
                <div class="flex flex-wrap gap-2 items-center ml-auto">
                    @if(request('search'))
                    <span class="text-xs px-3 py-1.5 rounded-full font-semibold"
                          style="background:rgba(0,48,135,.08); color:var(--ju-navy)">
                        <i class="fas fa-search mr-1"></i>{{ request('search') }}
                    </span>
                    @endif
                    @if(request('category'))
                    <span class="text-xs px-3 py-1.5 rounded-full font-semibold"
                          style="background:rgba(200,150,12,.1); color:var(--ju-gold-dark)">
                        <i class="fas fa-layer-group mr-1"></i>{{ request('category') }}
                    </span>
                    @endif
                </div>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Results bar ── --}}
    <div class="results-bar">
        <span>
            Showing <strong style="color:var(--ju-text)">{{ $listings->count() }}</strong>
            of <strong style="color:var(--ju-text)">{{ $listings->total() }}</strong> listings
        </span>
        @if(request()->hasAny(['search','category','min_price','max_price']))
        <a href="{{ route('listings.index') }}" class="text-xs font-semibold hover:underline" style="color:var(--ju-red)">
            <i class="fas fa-times-circle mr-1"></i>Clear filters
        </a>
        @endif
    </div>

    {{-- ── Grid ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($listings as $listing)
        <div class="product-card">

            {{-- Image --}}
            <div class="product-img-wrap">
                @if($listing->photos->first())
                <img src="{{ $listing->photos->first()->photo_path }}"
                     alt="{{ $listing->title }}"
                     loading="lazy"
                     onerror="this.parentElement.innerHTML='<div class=\'product-img-placeholder\'><i class=\'fas fa-image\' style=\'font-size:2.5rem; color:#b0b8d4\'></i><span style=\'font-size:.8rem; color:#8991ae\'>No Image</span></div>'">
                @else
                <div class="product-img-placeholder">
                    <i class="fas fa-image" style="font-size:2.5rem; color:#b0b8d4"></i>
                    <span style="font-size:.8rem; color:#8991ae">No Image</span>
                </div>
                @endif

                {{-- HOT badge --}}
                <div style="position:absolute; top:12px; left:12px">
                    <span class="badge-hot"><i class="fas fa-fire" style="font-size:.6rem"></i>HOT</span>
                </div>

                {{-- ── Favourite / Like Button ── --}}
                @auth
                    {{-- Logged in: full toggle button --}}
                    <button
                        class="fav-btn {{ auth()->user()->hasFavorited($listing->id) ? 'fav-on' : 'fav-off' }}"
                        data-listing-id="{{ $listing->id }}"
                        data-favorited="{{ auth()->user()->hasFavorited($listing->id) ? 'true' : 'false' }}"
                        data-toggle-url="{{ route('listings.favorite.toggle', $listing->id) }}"
                        title="{{ auth()->user()->hasFavorited($listing->id) ? 'Remove from Saved' : 'Save to Favorites' }}"
                        aria-label="Toggle favourite"
                    >
                        <i class="{{ auth()->user()->hasFavorited($listing->id) ? 'fas' : 'far' }} fa-heart"></i>
                    </button>
                @else
                    {{-- Guest: redirect to login on click --}}
                    <a href="{{ route('login') }}"
                       class="fav-btn fav-off"
                       title="Sign in to save favourites"
                       aria-label="Sign in to favourite">
                        <i class="far fa-heart"></i>
                    </a>
                @endauth
            </div>

            {{-- Body --}}
            <div class="product-body">
                <a href="{{ route('listings.show', $listing) }}" class="product-title">
                    {{ $listing->title }}
                </a>

                <div class="flex flex-wrap gap-1.5 my-1">
                    <span class="cat-pill"><i class="fas fa-tag" style="font-size:.6rem"></i>{{ $listing->category }}</span>
                    @if($listing->condition)
                    <span class="cond-pill">{{ $listing->condition }}</span>
                    @endif
                </div>

                <div class="flex items-center justify-between mt-1">
                    <span class="product-price">ETB {{ number_format($listing->price, 2) }}</span>
                    <span class="product-seller">
                        <i class="fas fa-user-circle" style="font-size:.85rem; color:var(--ju-muted)"></i>
                        {{ Str::limit($listing->user->name, 14) }}
                    </span>
                </div>

                <a href="{{ route('listings.show', $listing) }}" class="view-details-btn">
                    View Details <i class="fas fa-arrow-right" style="font-size:.75rem"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="empty-state">
                <div class="empty-icon-wrap">
                    <i class="fas fa-box-open" style="font-size:2.4rem; color:var(--ju-muted)"></i>
                </div>
                <h3 class="text-xl font-bold mb-2" style="color:var(--ju-text)">No listings found</h3>
                <p class="text-sm mb-6" style="color:var(--ju-muted)">
                    @if(request()->hasAny(['search','category','min_price','max_price']))
                        Try adjusting your filters or clear them to see all listings.
                    @else
                        Be the first to list something on Campus Trade!
                    @endif
                </p>
                @if(request()->hasAny(['search','category','min_price','max_price']))
                <a href="{{ route('listings.index') }}" class="ju-btn-ghost">
                    <i class="fas fa-undo"></i> Clear Filters
                </a>
                @else
                <a href="{{ route('listings.create') }}" class="ju-btn-primary">
                    <i class="fas fa-plus-circle"></i> Create First Listing
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    {{-- ── Pagination ── --}}
    @if($listings->hasPages())
    <div class="mt-10 flex justify-center">
        {{ $listings->links() }}
    </div>
    @endif

</div>{{-- /max-w-7xl --}}

{{-- ── Toast Notification ── --}}
<div id="fav-toast">
    <i class="fas fa-heart toast-icon"></i>
    <span id="fav-toast-msg">Added to Favourites</span>
</div>

{{-- ── Favourite Toggle JS ── --}}
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    let toastTimer = null;
    const toast    = document.getElementById('fav-toast');
    const toastMsg = document.getElementById('fav-toast-msg');

    function showToast(message, isAdd) {
        toastMsg.textContent = message;
        toast.querySelector('.toast-icon').className =
            (isAdd ? 'fas' : 'far') + ' fa-heart toast-icon';
        toast.style.background = isAdd ? 'var(--ju-navy-dark)' : '#4a5568';
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
    }

    document.querySelectorAll('.fav-btn[data-listing-id]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const listingId  = btn.dataset.listingId;
            const toggleUrl  = btn.dataset.toggleUrl;
            let   favorited  = btn.dataset.favorited === 'true';
            const icon       = btn.querySelector('i');

            // Optimistic UI update
            favorited = !favorited;
            btn.dataset.favorited = favorited ? 'true' : 'false';
            btn.classList.toggle('fav-on',  favorited);
            btn.classList.toggle('fav-off', !favorited);
            icon.className = (favorited ? 'fas' : 'far') + ' fa-heart';
            btn.title = favorited ? 'Remove from Saved' : 'Save to Favorites';

            // Heart pop animation
            btn.classList.remove('fav-popping');
            void btn.offsetWidth; // reflow to restart animation
            if (favorited) btn.classList.add('fav-popping');
            btn.addEventListener('animationend', () => btn.classList.remove('fav-popping'), { once: true });

            // Server request
            fetch(toggleUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(function (res) {
                if (!res.ok) throw new Error('Server error ' + res.status);
                return res.json();
            })
            .then(function (data) {
                // Sync with server response (data.favorited = true|false)
                const serverState = data.favorited ?? favorited;
                if (serverState !== favorited) {
                    // Roll back optimistic update if server disagrees
                    btn.dataset.favorited = serverState ? 'true' : 'false';
                    btn.classList.toggle('fav-on',  serverState);
                    btn.classList.toggle('fav-off', !serverState);
                    icon.className = (serverState ? 'fas' : 'far') + ' fa-heart';
                }
                const msg = serverState ? 'Saved to Favourites' : 'Removed from Favourites';
                showToast(msg, serverState);
            })
            .catch(function () {
                // Revert on error
                favorited = !favorited;
                btn.dataset.favorited = favorited ? 'true' : 'false';
                btn.classList.toggle('fav-on',  favorited);
                btn.classList.toggle('fav-off', !favorited);
                icon.className = (favorited ? 'fas' : 'far') + ' fa-heart';
                showToast('Something went wrong. Please try again.', false);
            });
        });
    });
})();
</script>

@endsection