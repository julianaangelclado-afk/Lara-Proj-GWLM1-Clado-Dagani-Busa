<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bandit Music Studio')</title>

    {{-- apply saved theme BEFORE the page paints (no flash) --}}
    <script>
        try {
            document.documentElement.setAttribute('data-theme', localStorage.getItem('bandit-theme') || 'light');
        } catch (e) {}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Sora:wght@500;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @stack('styles')
</head>
<body>

    <header class="navbar" id="navbar">
        <a href="{{ route('home') }}" class="logo" aria-label="Bandit home">
            <span class="logo-eq"><i></i><i></i><i></i><i></i></span>
            <span class="logo-text">BAND<span>IT</span></span>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Open menu">☰</button>

        <nav class="nav-links" id="navLinks">
            <a href="{{ route('home') }}"    class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}"   class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            <a href="{{ route('contact') }}#book" class="nav-cta">Book Now</a>
            <button id="themeToggle" class="theme-btn" aria-label="Switch night / light mode" title="Night / Light mode">🌙</button>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-glow"></div>
        <div class="container footer-grid">
            <div>
                <p class="footer-brand">BAND<span>IT</span></p>
                <p class="footer-text">Band rehearsal studios and gear rental. Plug in, jam out, own the room.</p>
            </div>
            <div>
                <h4>Explore</h4>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('contact') }}#book">Book a Session</a>
            </div>
            <div>
                <h4>Studio Hours</h4>
                <p class="footer-text">Open daily<br>10:00 AM – 12:00 MN</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Built by: <strong>Clado</strong> • <strong>Dagani</strong> • <strong>Busa</strong></p>
            <small>© {{ date('Y') }} Bandit Music Studio · Web System and Technologies Final Project</small>
        </div>
    </footer>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script src="{{ asset('js/global.js') }}"></script>
    @stack('scripts')
</body>
</html>
