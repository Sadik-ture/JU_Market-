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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
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
            --ju-red:       #c0392b;
        }

        * { box-sizing: border-box; }

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

        /* Page header band */
        .ju-page-header {
            background: var(--ju-white);
            border-bottom: 2px solid var(--ju-border);
            box-shadow: 0 1px 6px rgba(0,30,87,0.06);
        }

        .ju-page-header h2 {
            color: var(--ju-navy-dark);
            font-size: 22px;
            font-weight: 700;
        }

        /* Content area */
        .ju-content {
            background: var(--ju-offwhite);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--ju-surface); }
        ::-webkit-scrollbar-thumb { background: var(--ju-navy); border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--ju-navy-mid); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen ju-content">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="ju-page-header">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>