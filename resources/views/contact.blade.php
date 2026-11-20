@extends('layouts.app')

@section('title', 'Contact & Booking | Bandit Music Studio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">✉️ Contact &amp; Booking</span>
        <h1>Get in <span class="grad-text">touch</span></h1>
        <p>Send us a message, or book a studio session and rent instruments for your band.</p>
    </div>
</section>

<section class="container contact-wrap">

    {{-- DETAILS --}}
    <div class="info-col">
        <div class="info card glow-hover reveal"><span class="ic">📍</span><div><h4>Visit us</h4><p>Bandit Music Studio, Brgy. San Vicente, Butuan City</p></div></div>
        <div class="info card glow-hover reveal"><span class="ic">📞</span><div><h4>Call or text</h4><p>0912 345 6789</p></div></div>
        <div class="info card glow-hover reveal"><span class="ic">✉️</span><div><h4>Email</h4><p>hello&#64;bandit.test</p></div></div>
        <div class="info card glow-hover reveal"><span class="ic">🕒</span><div><h4>Studio hours</h4><p>Daily, 10:00 AM – 12:00 MN</p></div></div>
    </div>

    {{-- TABBED PANEL --}}
    <div class="card panel" id="book">
        <div class="tabs" id="panelTabs">
            <button type="button" class="tab active" data-panel="message">💬 Send a message</button>
            <button type="button" class="tab" data-panel="booking">📅 Book a session</button>
        </div>

        {{-- ===== MESSAGE FORM ===== --}}
        <form class="panel-body" id="contactForm" data-panel="message" novalidate>
            <div class="field" id="c-name">
                <label for="cName">Name</label>
                <input type="text" id="cName" placeholder="Your name">
                <small class="error"></small>
            </div>
            <div class="field" id="c-email">
                <label for="cEmail">Email</label>
                <input type="email" id="cEmail" placeholder="you@example.com">
                <small class="error"></small>
            </div>
            <div class="field" id="c-subject">
                <label for="cSubject">Subject</label>
                <input type="text" id="cSubject" placeholder="What is this about?">
                <small class="error"></small>
            </div>
            <div class="field" id="c-message">
                <label for="cMessage">Message</label>
                <textarea id="cMessage" rows="5" placeholder="Write your message..."></textarea>
                <small class="error"></small>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send Message ✦</button>
            <p class="success" id="msgSuccess" hidden>✅ Message sent! We'll get back to you soon.</p>
        </form>

        {{-- ===== BOOKING FORM ===== --}}
        <form class="panel-body" id="bookingForm" data-panel="booking" hidden novalidate>
            <div class="two-col">
                <div class="field" id="b-name">
                    <label for="bName">Name / Band name</label>
                    <input type="text" id="bName" placeholder="e.g. The Night Owls">
                    <small class="error"></small>
                </div>
                <div class="field" id="b-phone">
                    <label for="bPhone">Mobile number</label>
                    <input type="tel" id="bPhone" placeholder="09XX XXX XXXX">
                    <small class="error"></small>
                </div>
            </div>

            <h3 class="sub">1. Choose a studio</h3>
            <div class="studio-pick">
                @foreach ($studios as $key => $s)
                    <label class="pick-card">
                        <input type="radio" name="studio" value="{{ $key }}"
                               data-name="{{ $s['name'] }}" data-rate="{{ $s['rate'] }}" data-cap="{{ $s['capacity'] }}">
                        <div class="pick-inner">
                            <img src="{{ asset($s['image']) }}" alt="{{ $s['name'] }}" loading="lazy">
                            <div>
                                <strong>{{ $s['name'] }}</strong>
                                <small>{{ '₱' . number_format($s['rate']) }}/hr · up to {{ $s['capacity'] }}</small>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            <small class="error block-error" id="studioError"></small>

            <h3 class="sub">2. Schedule</h3>
            <div class="four-col">
                <div class="field" id="b-date">
                    <label for="bDate">Date</label>
                    <input type="date" id="bDate">
                    <small class="error"></small>
                </div>
                <div class="field" id="b-time">
                    <label for="bTime">Start time</label>
                    <select id="bTime">
                        <option value="">Select</option>
                        @for ($h = 10; $h <= 22; $h++)
                            <option value="{{ sprintf('%02d:00', $h) }}">{{ date('g:00 A', mktime($h, 0, 0)) }}</option>
                        @endfor
                    </select>
                    <small class="error"></small>
                </div>
                <div class="field" id="b-hours">
                    <label for="bHours">Hours</label>
                    <select id="bHours">
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'hour' : 'hours' }}</option>
                        @endfor
                    </select>
                    <small class="error"></small>
                </div>
                <div class="field" id="b-members">
                    <label for="bMembers">Band members</label>
                    <input type="number" id="bMembers" min="1" max="10" value="4">
                    <small class="error"></small>
                </div>
            </div>

            <h3 class="sub">3. Add instruments <em>(optional)</em></h3>
            @foreach ($categories as $cat)
                <h4 class="gear-cat">{{ $cat['emoji'] }} {{ $cat['label'] }}</h4>
                <div class="gear-pick">
                    @foreach (collect($instruments)->where('category', $cat['key']) as $ins)
                        <label class="gear-item">
                            <input type="checkbox" class="gear-check" value="{{ $ins['id'] }}" data-rate="{{ $ins['rate'] }}">
                            <div class="gear-inner">
                                <img src="{{ asset($ins['image']) }}" alt="{{ $ins['name'] }}" loading="lazy">
                                <div>
                                    <strong>{{ $ins['name'] }}</strong>
                                    <small>{{ '₱' . number_format($ins['rate']) }}/hr</small>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endforeach

            <div class="field notes">
                <label for="bNotes">Notes (optional)</label>
                <textarea id="bNotes" rows="3" placeholder="e.g. Need an extra mic stand"></textarea>
            </div>

            <div class="estimate">
                <div><span>Estimated total</span><small id="estDetail">Choose a studio to see the price</small></div>
                <strong id="estTotal">₱0</strong>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Request Appointment ✦</button>
            <div class="success booked" id="bookSuccess" hidden></div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/contact.js') }}"></script>
@endpush
