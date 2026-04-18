<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {
            baseUrl: '{{ url('/') }}',
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    @php
        $favicon = \App\Models\Setting::first()?->site_favicon;
        $path = request()->path();
        $currentSlug = ($path === '/' || $path === '' || $path === 'index.php') ? 'home' : $path;
        $seo = \App\Models\SeoMeta::where('slug', $currentSlug)->first();
    @endphp

    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset($favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    @if($seo)
        <title>{{ $seo->meta_title }}</title>
        <meta name="description" content="{{ $seo->meta_description }}">
        <meta name="keywords" content="{{ $seo->meta_keywords }}">
        <link rel="canonical" href="{{ $seo->canonical_url ?? url()->current() }}">
        <meta name="robots" content="{{ $seo->robots_index }}, {{ $seo->robots_follow }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $seo->og_title ?? $seo->meta_title }}">
        <meta property="og:description" content="{{ $seo->og_description ?? $seo->meta_description }}">
        @if($seo->og_image)
            <meta property="og:image" content="{{ asset($seo->og_image) }}">
        @endif

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $seo->twitter_title ?? $seo->meta_title }}">
        @if($seo->twitter_image)
            <meta property="twitter:image" content="{{ asset($seo->twitter_image) }}">
        @endif
    @else
        <title>@yield('title') | {{ config('app.name', 'Nice Guest House') }}</title>
    @endif

    <script src="{{ asset('assets/js/loader.js') }}"></script>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Flatpickr for Date Range -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Slick Slider for Hero Section -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

    <!-- Pannellum for 360-degree view -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/root.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />

    @stack('styles')

    <style>
        body,
        html {
            overflow-x: clip;
        }

        .goog-te-banner-frame.skiptranslate,
        .goog-te-banner-frame,
        .goog-te-gadget-icon,
        #goog-gt-tt,
        .goog-te-balloon-frame,
        .goog-te-menu-value img {
            display: none !important;
            visibility: hidden !important;
        }

        body {
            top: 0px !important;
            position: static !important;
        }

        .skiptranslate {
            display: none !important;
        }

        #google_translate_element {
            position: absolute;
            top: -9999px;
            left: -9999px;
            visibility: hidden;
            display: none;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.modals')
    @include('partials.mobile-menu')

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (Required for Slick and Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Slick Slider JS -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Pannellum JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

    <!-- custom js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    @stack('scripts')

    <!-- Google Translate -->
    <div id="google_translate_element"></div>
    <script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>