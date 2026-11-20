@extends('layouts.app')

@section('title', 'About | Bandit Music Studio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">🎤 Our Story</span>
        <h1>About <span class="grad-text">Bandit</span></h1>
        <p>A home for bands who need a place to practice, create and grow.</p>
    </div>
</section>

{{-- STORY (Read More / Read Less) --}}
<section class="container story-wrap">
    <div class="story card reveal">
        <p>
            Bandit started with a simple problem: we were a band with nowhere good to rehearse.
            Rooms were too small, gear was always missing, and nothing matched our sound.
            So we built the studio we wished existed, with a room for every genre.
            <span class="more-text" id="moreText">
                Today Bandit has five themed rehearsal rooms (Rock, Jazz, OPM, R&amp;B and Reggae)
                and a growing wall of rentable guitars, basses, drums, keyboards and pedals.
                Every room is soundproofed, lit for the mood, and set up so your band can walk in,
                plug in and play within minutes. We love supporting local bands, from first jam
                sessions to demo recordings.
            </span>
        </p>
        <button type="button" class="btn btn-ghost" id="readMoreBtn">Read More</button>
    </div>
</section>

{{-- COUNTERS --}}
<section class="container">
    <div class="counters">
        <div class="counter card glow-hover reveal"><h2><span class="count" data-target="5">0</span></h2><p>Themed Studios</p></div>
        <div class="counter card glow-hover reveal"><h2><span class="count" data-target="16">0</span></h2><p>Rentable Instruments</p></div>
        <div class="counter card glow-hover reveal"><h2><span class="count" data-target="300">0</span>+</h2><p>Bands Hosted</p></div>
        <div class="counter card glow-hover reveal"><h2><span class="count" data-target="1200">0</span>+</h2><p>Hours Played</p></div>
    </div>
</section>

{{-- MISSION / VISION --}}
<section class="section">
    <div class="container mv-grid">
        <div class="card glow-hover reveal mv"><div class="mv-icon">🎯</div><h3>Our Mission</h3>
            <p>To give every band an affordable, inspiring space and the gear they need to sound their best.</p></div>
        <div class="card glow-hover reveal mv"><div class="mv-icon">🔭</div><h3>Our Vision</h3>
            <p>A music community where every genre has a stage, and every local band has a place to start.</p></div>
        <div class="card glow-hover reveal mv"><div class="mv-icon">💚</div><h3>Our Values</h3>
            <p>Respect for every sound, care for the gear, and a welcome for musicians of all levels.</p></div>
    </div>
</section>

{{-- WHY BANDIT --}}
<section class="container">
    <div class="section-head reveal">
        <span class="eyebrow">Why Bandit</span>
        <h2>Built for <span class="grad-text">musicians</span></h2>
    </div>
    <div class="why-grid">
        <div class="why card glow-hover reveal"><span>🔊</span><h4>Soundproofed rooms</h4><p>Play loud without bothering anyone.</p></div>
        <div class="why card glow-hover reveal"><span>🎛️</span><h4>Pro gear on hand</h4><p>Guitars, basses, drums, keys and pedals.</p></div>
        <div class="why card glow-hover reveal"><span>🕒</span><h4>Flexible hours</h4><p>Open daily from 10:00 AM to 12:00 MN.</p></div>
        <div class="why card glow-hover reveal"><span>💸</span><h4>Fair prices</h4><p>Pay by the hour. No hidden fees.</p></div>
    </div>
</section>

{{-- TEAM --}}
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">The Crew</span>
            <h2>Meet the <span class="grad-text">team</span></h2>
            <p>The people who keep Bandit running.</p>
        </div>
        <div class="team-grid">
            <div class="team card glow-hover reveal"><div class="avatar">1</div><h3>Juliana Clado</h3><span>Studio Manager</span></div>
            <div class="team card glow-hover reveal"><div class="avatar">2</div><h3>Jasmin Dagani</h3><span>Sound Engineer</span></div>
            <div class="team card glow-hover reveal"><div class="avatar">3</div><h3>Flora Busa</h3><span>Gear Technician</span></div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/about.js') }}"></script>
@endpush
