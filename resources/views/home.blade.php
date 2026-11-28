@extends('layouts.app')

@section('title', 'Bandit Music Studio | Rehearse. Record. Rock.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jam.css') }}">
@endpush

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">🎶 Band Rehearsal Studios</span>
            <h1>Plug in. <span class="grad-text">Jam out.</span> Own the room.</h1>
            <p class="hero-desc">
                Bandit is a music studio with five themed rehearsal rooms and a full wall of
                rentable gear. Pick your vibe, pick your instruments, and book your session online.
            </p>
            <div class="hero-cta">
                <a href="{{ route('contact') }}#book" class="btn btn-primary">Book a Session</a>
                <a href="#instruments" class="btn btn-ghost">Browse Instruments</a>
                <a href="#jam" class="btn btn-ghost">🎹 Jam Corner</a>
            </div>
            <ul class="hero-stats">
                <li><strong>{{ count($studios) }}</strong><span>Themed studios</span></li>
                <li><strong>{{ count($instruments) }}</strong><span>Rentable instruments</span></li>
                <li><strong>10AM–12MN</strong><span>Open daily</span></li>
            </ul>
        </div>

        <div class="hero-visual">
            <div class="eq" id="heroEq" aria-hidden="true"></div>
            <img class="shot shot-a" src="{{ asset($studios['rock']['image']) }}" alt="Rock Studio">
            <img class="shot shot-b" src="{{ asset($studios['reggae']['image']) }}" alt="Reggae Studio">
            <div class="float-card">🟢 Now booking tonight's sessions</div>
        </div>
    </div>
</section>

{{-- ================= QUICK APPOINTMENT BAR ================= --}}
<section class="container quick-wrap">
    <form class="quickbar card reveal" id="quickBook" data-action="{{ route('contact') }}">
        <div class="field">
            <label for="qStudio">Studio</label>
            <select id="qStudio" name="studio">
                <option value="">Choose a studio</option>
                @foreach ($studios as $key => $s)
                    <option value="{{ $key }}">{{ $s['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="qDate">Date</label>
            <input type="date" id="qDate" name="date">
        </div>
        <div class="field">
            <label for="qTime">Start time</label>
            <select id="qTime" name="time">
                <option value="">Any time</option>
                @for ($h = 10; $h <= 22; $h++)
                    <option value="{{ sprintf('%02d:00', $h) }}">{{ date('g:00 A', mktime($h, 0, 0)) }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary quick-btn">Make Appointment ✦</button>
    </form>
</section>

{{-- ================= STUDIOS ================= --}}
<section class="section" id="studios">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Our Rooms</span>
            <h2>Pick your <span class="grad-text">studio vibe</span></h2>
            <p>Every room has its own look, sound and feel. Choose the one that matches your genre.</p>
        </div>

        <div class="studio-grid">
            @foreach ($studios as $key => $s)
                <article class="studio-card card glow-hover reveal">
                    <div class="studio-img">
                        <img src="{{ asset($s['image']) }}" alt="{{ $s['name'] }}" loading="lazy">
                        <span class="rate-tag">{{ '₱' . number_format($s['rate']) }}/hr</span>
                    </div>
                    <div class="studio-body">
                        <h3>{{ $s['name'] }}</h3>
                        <p class="tagline">{{ $s['tagline'] }}</p>
                        <p class="desc">{{ $s['desc'] }}</p>
                        <div class="chips">
                            @foreach ($s['features'] as $f)
                                <span class="chip">{{ $f }}</span>
                            @endforeach
                        </div>
                        <div class="studio-foot">
                            <small>👥 Up to {{ $s['capacity'] }} members</small>
                            <a href="{{ route('contact', ['studio' => $key]) }}#book" class="btn btn-primary btn-sm">Book this room</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= INSTRUMENT GALLERY ================= --}}
<section class="section gear-section" id="instruments">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Rent Our Gear</span>
            <h2>Bring your <span class="grad-text">talent</span>, we have the gear</h2>
            <p>Electric and acoustic guitars, basses, drums, keyboards and pedals. Rent them with your studio session.</p>
        </div>

        <div class="tabs" id="gearTabs">
            <button type="button" class="tab active" data-filter="all">All ({{ count($instruments) }})</button>
            @foreach ($categories as $cat)
                <button type="button" class="tab" data-filter="{{ $cat['key'] }}">{{ $cat['emoji'] }} {{ $cat['label'] }}</button>
            @endforeach
        </div>

        <div class="gear-grid" id="gearGrid">
            @foreach ($instruments as $ins)
                <article class="gear-card card glow-hover" data-cat="{{ $ins['category'] }}">
                    <div class="gear-img">
                        <img src="{{ asset($ins['image']) }}" alt="{{ $ins['name'] }}" loading="lazy">
                        <span class="rate-tag">{{ '₱' . number_format($ins['rate']) }}/hr</span>
                    </div>
                    <div class="gear-body">
                        <small class="brand">{{ $ins['brand'] }}</small>
                        <h3>{{ $ins['name'] }}</h3>
                        <p>{{ $ins['desc'] }}</p>
                        <a href="{{ route('contact', ['gear' => $ins['id']]) }}#book" class="btn btn-ghost btn-sm">＋ Rent this</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= JAM CORNER (just for fun) ================= --}}
<section class="section jam-section" id="jam">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">🎹 Jam Corner</span>
            <h2>Play with us, <span class="grad-text">just for fun</span></h2>
            <p>No band yet? Tap the keys or build a beat right here. Turn your sound up and jam.</p>
        </div>

        <div class="jam-volume reveal">
            <label for="jamVolume">🔊 Volume</label>
            <input type="range" id="jamVolume" min="0" max="1" step="0.05" value="0.7">
        </div>

        {{-- PIANO --}}
        <div class="jam-card card reveal">
            <div class="jam-head">
                <div>
                    <h3>Play me a tune</h3>
                    <p>Tap the keys, or press <b>A S D F G H J K</b> on your keyboard. Black keys are <b>W E T Y U</b>.</p>
                </div>
                <div class="field inline">
                    <label for="soundSel">Sound</label>
                    <select id="soundSel">
                        <option value="keys">🎹 Keys</option>
                        <option value="synth">🎛️ Synth</option>
                        <option value="bell">🔔 Bell</option>
                        <option value="organ">⛪ Organ</option>
                    </select>
                </div>
            </div>
            <div class="piano" id="piano"></div>
        </div>

        {{-- BEAT MAKER --}}
        <div class="jam-card card reveal">
            <div class="jam-head">
                <div>
                    <h3>Make a beat</h3>
                    <p>Tap the squares to build a loop, then press play. Or load a groove from one of our studios.</p>
                </div>
                <div class="jam-controls">
                    <button type="button" class="btn btn-primary btn-sm" id="playBtn">▶ Play</button>
                    <button type="button" class="btn btn-ghost btn-sm" id="surpriseBtn">Surprise me</button>
                    <button type="button" class="btn btn-ghost btn-sm" id="clearBtn">Clear</button>
                    <label class="tempo" for="tempo">Tempo
                        <input type="range" id="tempo" min="60" max="160" value="100">
                        <span id="tempoVal">100 bpm</span>
                    </label>
                </div>
            </div>

            <div class="presets" id="presets">
                <span class="presets-label">Studio grooves:</span>
                <button type="button" class="preset" data-groove="rock">Rock</button>
                <button type="button" class="preset" data-groove="jazz">Jazz</button>
                <button type="button" class="preset" data-groove="opm">OPM</button>
                <button type="button" class="preset" data-groove="rnb">R&amp;B</button>
                <button type="button" class="preset" data-groove="reggae">Reggae</button>
            </div>

            <div class="seq-scroll"><div class="seq" id="seq"></div></div>
        </div>
    </div>
</section>

{{-- ================= HOW IT WORKS ================= --}}
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Easy Booking</span>
            <h2>Three steps to <span class="grad-text">your session</span></h2>
        </div>
        <div class="steps">
            <div class="step card glow-hover reveal"><span class="num">1</span><h3>Choose a studio</h3><p>Pick the room that fits your genre and band size.</p></div>
            <div class="step card glow-hover reveal"><span class="num">2</span><h3>Add instruments</h3><p>Rent guitars, bass, drums, keys and pedals by the hour.</p></div>
            <div class="step card glow-hover reveal"><span class="num">3</span><h3>Show up and jam</h3><p>Get your booking code and walk in. We handle the rest.</p></div>
        </div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="container cta-wrap">
    <div class="cta reveal">
        <h2>Ready to make some noise?</h2>
        <p>Reserve your rehearsal slot in under a minute.</p>
        <a href="{{ route('contact') }}#book" class="btn btn-primary">Book a Session</a>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/jam.js') }}"></script>
@endpush
