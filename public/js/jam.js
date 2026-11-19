/* =====================================================
   JAM CORNER: playable piano + beat maker (just for fun)
   Sounds are generated live with the Web Audio API,
   so there are no audio files to download.
   ===================================================== */
document.addEventListener('DOMContentLoaded', () => {
    const pianoBox = document.getElementById('piano');
    const seqBox = document.getElementById('seq');
    if (!pianoBox || !seqBox) return;

    const soundSel = document.getElementById('soundSel');
    const volume = document.getElementById('jamVolume');
    const tempo = document.getElementById('tempo');
    const tempoVal = document.getElementById('tempoVal');
    const playBtn = document.getElementById('playBtn');

    /* ---------- audio engine ---------- */
    let ac = null, master = null, noiseBuf = null;

    function audio() {
        if (!ac) {
            const AC = window.AudioContext || window.webkitAudioContext;
            if (!AC) return null;
            ac = new AC();
            master = ac.createGain();
            master.gain.value = Number(volume.value);
            const comp = ac.createDynamicsCompressor();   // keeps loud chords from clipping
            master.connect(comp);
            comp.connect(ac.destination);
            noiseBuf = ac.createBuffer(1, ac.sampleRate, ac.sampleRate);
            const data = noiseBuf.getChannelData(0);
            for (let i = 0; i < data.length; i++) data[i] = Math.random() * 2 - 1;
        }
        if (ac.state === 'suspended') ac.resume();
        return ac;
    }
    volume.addEventListener('input', () => { if (master) master.gain.value = Number(volume.value); });

    /* ================= PIANO ================= */
    const WHITE = [
        { n: 'C', f: 261.63, k: 'a' }, { n: 'D', f: 293.66, k: 's' }, { n: 'E', f: 329.63, k: 'd' },
        { n: 'F', f: 349.23, k: 'f' }, { n: 'G', f: 392.00, k: 'g' }, { n: 'A', f: 440.00, k: 'h' },
        { n: 'B', f: 493.88, k: 'j' }, { n: 'C', f: 523.25, k: 'k' }
    ];
    const BLACK = [   // "after" = index of the white key it sits to the right of
        { n: 'C#', f: 277.18, k: 'w', after: 0 }, { n: 'D#', f: 311.13, k: 'e', after: 1 },
        { n: 'F#', f: 369.99, k: 't', after: 3 }, { n: 'G#', f: 415.30, k: 'y', after: 4 },
        { n: 'A#', f: 466.16, k: 'u', after: 5 }
    ];
    const SOUNDS = {
        keys:  { parts: [{ t: 'triangle', m: 1, g: .9 }, { t: 'sine', m: 2, g: .25 }], sustain: .55, decay: .6 },
        synth: { parts: [{ t: 'sawtooth', m: 1, g: .5 }, { t: 'square', m: 1.006, g: .25 }], filter: 2200, sustain: .6, decay: .4 },
        bell:  { parts: [{ t: 'sine', m: 1, g: .8 }, { t: 'sine', m: 2.76, g: .3 }, { t: 'sine', m: 5.4, g: .12 }], sustain: .0001, decay: 1.1 },
        organ: { parts: [{ t: 'sine', m: 1, g: .6 }, { t: 'sine', m: 2, g: .4 }, { t: 'sine', m: 3, g: .2 }], sustain: 1, decay: .1 }
    };

    const voices = {};
    const keyMap = {};

    function noteOn(id, freq) {
        if (voices[id]) return;
        const a = audio();
        if (!a) return;
        const snd = SOUNDS[soundSel.value] || SOUNDS.keys;
        const now = a.currentTime;

        const out = a.createGain();
        out.gain.setValueAtTime(0, now);
        out.gain.linearRampToValueAtTime(.3, now + .012);
        out.gain.setTargetAtTime(.3 * snd.sustain, now + .012, snd.decay / 3);
        out.connect(master);

        let target = out;
        if (snd.filter) {
            const filt = a.createBiquadFilter();
            filt.type = 'lowpass';
            filt.frequency.value = snd.filter;
            filt.connect(out);
            target = filt;
        }
        const oscs = snd.parts.map(p => {
            const o = a.createOscillator();
            const g = a.createGain();
            o.type = p.t;
            o.frequency.value = freq * p.m;
            g.gain.value = p.g;
            o.connect(g);
            g.connect(target);
            o.start(now);
            return o;
        });
        voices[id] = { out, oscs };
    }

    function noteOff(id) {
        const v = voices[id];
        if (!v) return;
        delete voices[id];
        const now = ac.currentTime;
        v.out.gain.setTargetAtTime(0, now, .08);
        v.oscs.forEach(o => o.stop(now + .6));
    }

    function press(id, freq, el) { el.classList.add('down'); noteOn(id, freq); }
    function release(id, el) { el.classList.remove('down'); noteOff(id); }

    function addKey(info, id, className, style, label) {
        const el = document.createElement('button');
        el.type = 'button';
        el.className = className;
        if (style) el.style.left = style;
        el.setAttribute('aria-label', `Piano key ${info.n}`);
        el.innerHTML = label;
        el.addEventListener('pointerdown', e => { e.preventDefault(); press(id, info.f, el); });
        el.addEventListener('pointerenter', e => { if (e.buttons & 1) press(id, info.f, el); });
        ['pointerup', 'pointerleave', 'pointercancel'].forEach(t => el.addEventListener(t, () => release(id, el)));
        keyMap[info.k] = { id, freq: info.f, el };
        return el;
    }

    const keysWrap = document.createElement('div');
    keysWrap.className = 'piano-keys';
    WHITE.forEach((w, i) => keysWrap.appendChild(addKey(w, 'w' + i, 'wkey', null, `<span>${w.n}</span><small>${w.k}</small>`)));
    BLACK.forEach((b, i) => {
        const left = `calc(${(b.after + 1) * 12.5}% - 3.3%)`;
        keysWrap.appendChild(addKey(b, 'b' + i, 'bkey', left, b.k));
    });
    pianoBox.appendChild(keysWrap);

    // computer keyboard: only active while the Jam Corner is on screen
    let jamVisible = false;
    const jamSection = document.getElementById('jam');
    if (jamSection && 'IntersectionObserver' in window) {
        new IntersectionObserver(entries => { jamVisible = entries[0].isIntersecting; }, { threshold: 0.05 }).observe(jamSection);
    } else {
        jamVisible = true;
    }
    const typing = e => ['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName);

    document.addEventListener('keydown', e => {
        if (e.repeat || e.ctrlKey || e.metaKey || e.altKey || typing(e) || !jamVisible) return;
        const k = keyMap[e.key.toLowerCase()];
        if (k) press(k.id, k.freq, k.el);
    });
    document.addEventListener('keyup', e => {
        const k = keyMap[e.key.toLowerCase()];
        if (k) release(k.id, k.el);
    });
    const releaseAll = () => Object.values(keyMap).forEach(k => release(k.id, k.el));
    window.addEventListener('blur', releaseAll);

    /* ================= BEAT MAKER ================= */
    const STEPS = 16;
    const ROWS = [
        { id: 'kick',  label: 'Kick',   color: '#ff7a7a' },
        { id: 'snare', label: 'Snare',  color: '#5fb0ff' },
        { id: 'hat',   label: 'Hi-hat', color: '#35d08c' },
        { id: 'bass',  label: 'Bass',   color: '#ffc857' }
    ];
    const BASS_NOTES = [55, 55, 65.41, 55, 73.42, 55, 82.41, 73.42, 55, 55, 65.41, 55, 98, 82.41, 73.42, 65.41];
    const GROOVES = {
        rock:   { bpm: 120, kick: '1000001010000010', snare: '0000100000001000', hat: '1010101010101010', bass: '1000001010000010' },
        jazz:   { bpm: 104, kick: '1000000000100000', snare: '0010000001000010', hat: '1001001010010010', bass: '1000100010001001' },
        opm:    { bpm: 84,  kick: '1000000000100000', snare: '0000100000001000', hat: '1000100010001000', bass: '1000000010000000' },
        rnb:    { bpm: 92,  kick: '1000000100100000', snare: '0000100000001000', hat: '1011101110111011', bass: '1001001000100100' },
        reggae: { bpm: 76,  kick: '0000000010000000', snare: '0000000010000000', hat: '0010001000100010', bass: '1001000010010000' }
    };

    const state = {};
    const cells = {};
    ROWS.forEach(r => { state[r.id] = Array(STEPS).fill(false); cells[r.id] = []; });

    /* ----- drum voices (all synthesized) ----- */
    function noise(t, dur, hp, vol) {
        const s = ac.createBufferSource();
        s.buffer = noiseBuf;
        const f = ac.createBiquadFilter();
        f.type = 'highpass';
        f.frequency.value = hp;
        const g = ac.createGain();
        g.gain.setValueAtTime(vol, t);
        g.gain.exponentialRampToValueAtTime(.001, t + dur);
        s.connect(f); f.connect(g); g.connect(master);
        s.start(t);
        s.stop(t + dur + .02);
    }
    function kick(t) {
        const o = ac.createOscillator(), g = ac.createGain();
        o.type = 'sine';
        o.frequency.setValueAtTime(150, t);
        o.frequency.exponentialRampToValueAtTime(42, t + .14);
        g.gain.setValueAtTime(.95, t);
        g.gain.exponentialRampToValueAtTime(.001, t + .32);
        o.connect(g); g.connect(master);
        o.start(t); o.stop(t + .35);
    }
    function snare(t) {
        noise(t, .18, 1200, .55);
        const o = ac.createOscillator(), g = ac.createGain();
        o.type = 'triangle';
        o.frequency.setValueAtTime(190, t);
        g.gain.setValueAtTime(.4, t);
        g.gain.exponentialRampToValueAtTime(.001, t + .12);
        o.connect(g); g.connect(master);
        o.start(t); o.stop(t + .14);
    }
    function hat(t) { noise(t, .05, 7000, .28); }
    function bass(t, freq) {
        const o = ac.createOscillator(), f = ac.createBiquadFilter(), g = ac.createGain();
        o.type = 'sawtooth';
        o.frequency.value = freq;
        f.type = 'lowpass';
        f.frequency.value = 420;
        g.gain.setValueAtTime(.55, t);
        g.gain.exponentialRampToValueAtTime(.001, t + .28);
        o.connect(f); f.connect(g); g.connect(master);
        o.start(t); o.stop(t + .3);
    }
    function trigger(rowId, step, t) {
        if (rowId === 'kick') kick(t);
        else if (rowId === 'snare') snare(t);
        else if (rowId === 'hat') hat(t);
        else bass(t, BASS_NOTES[step]);
    }

    /* ----- build the grid ----- */
    ROWS.forEach(r => {
        const row = document.createElement('div');
        row.className = 'seq-row';
        row.style.setProperty('--c', r.color);
        row.innerHTML = `<span class="seq-label">${r.label}</span>`;
        for (let i = 0; i < STEPS; i++) {
            const c = document.createElement('button');
            c.type = 'button';
            c.className = 'cell' + (i % 4 === 0 ? ' beat' : '');
            c.setAttribute('aria-label', `${r.label} step ${i + 1}`);
            c.addEventListener('click', () => {
                state[r.id][i] = !state[r.id][i];
                c.classList.toggle('on', state[r.id][i]);
                clearActivePreset();
                if (state[r.id][i] && audio()) trigger(r.id, i, ac.currentTime);   // tiny preview
            });
            cells[r.id].push(c);
            row.appendChild(c);
        }
        seqBox.appendChild(row);
    });

    function refreshCells() {
        ROWS.forEach(r => cells[r.id].forEach((c, i) => c.classList.toggle('on', state[r.id][i])));
    }
    function clearActivePreset() {
        document.querySelectorAll('.preset').forEach(p => p.classList.remove('active'));
    }
    function setTempo(bpm) {
        tempo.value = bpm;
        tempoVal.textContent = tempo.value + ' bpm';
    }

    /* ----- scheduler (plays on time even if the page is busy) ----- */
    let playing = false, step = 0, nextTime = 0, timer = null;

    function highlight(s) {
        ROWS.forEach(r => cells[r.id].forEach((c, i) => c.classList.toggle('playing', playing && i === s)));
    }
    function tick() {
        while (nextTime < ac.currentTime + .12) {
            ROWS.forEach(r => { if (state[r.id][step]) trigger(r.id, step, nextTime); });
            const s = step;
            setTimeout(() => { if (playing) highlight(s); }, Math.max(0, (nextTime - ac.currentTime) * 1000));
            nextTime += 60 / Number(tempo.value) / 4;
            step = (step + 1) % STEPS;
        }
    }
    function start() {
        if (!audio()) return;
        playing = true;
        step = 0;
        nextTime = ac.currentTime + .06;
        timer = setInterval(tick, 25);
        playBtn.textContent = '■ Stop';
        playBtn.classList.add('playing');
    }
    function stop() {
        playing = false;
        clearInterval(timer);
        highlight(-1);
        playBtn.textContent = '▶ Play';
        playBtn.classList.remove('playing');
    }

    playBtn.addEventListener('click', () => (playing ? stop() : start()));
    tempo.addEventListener('input', () => { tempoVal.textContent = tempo.value + ' bpm'; });
    document.addEventListener('visibilitychange', () => { if (document.hidden && playing) stop(); });

    document.getElementById('clearBtn').addEventListener('click', () => {
        ROWS.forEach(r => state[r.id].fill(false));
        refreshCells();
        clearActivePreset();
    });

    document.getElementById('surpriseBtn').addEventListener('click', () => {
        for (let i = 0; i < STEPS; i++) {
            state.kick[i]  = i % 8 === 0 ? true : Math.random() < .15;
            state.snare[i] = i % 8 === 4 ? true : Math.random() < .07;
            state.hat[i]   = i % 2 === 0 ? Math.random() < .9 : Math.random() < .25;
            state.bass[i]  = Math.random() < .3;
        }
        setTempo(80 + Math.floor(Math.random() * 50));
        refreshCells();
        clearActivePreset();
        if (!playing) start();
    });

    function loadGroove(name) {
        const g = GROOVES[name];
        if (!g) return;
        ROWS.forEach(r => { state[r.id] = g[r.id].split('').map(ch => ch === '1'); });
        setTempo(g.bpm);
        refreshCells();
        clearActivePreset();
        const btn = document.querySelector(`.preset[data-groove="${name}"]`);
        if (btn) btn.classList.add('active');
    }
    document.querySelectorAll('.preset').forEach(p => {
        p.addEventListener('click', () => {
            loadGroove(p.dataset.groove);
            if (!playing) start();
        });
    });

    loadGroove('rock');   // start with a groove so the grid is not empty
});
