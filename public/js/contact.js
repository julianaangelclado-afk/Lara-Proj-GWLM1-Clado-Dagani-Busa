document.addEventListener('DOMContentLoaded', () => {
    const $ = s => document.querySelector(s);
    const $$ = s => [...document.querySelectorAll(s)];
    const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRe = /^(\+?63|0)9\d{9}$/;

    const setError = (box, msg) => {
        box.classList.toggle('invalid', !!msg);
        box.querySelector('.error').textContent = msg || '';
        return !msg;
    };

    /* ================= TABS (message / booking) ================= */
    const tabs = $$('#panelTabs .tab');
    const panels = $$('.panel-body');
    function showPanel(name) {
        tabs.forEach(t => t.classList.toggle('active', t.dataset.panel === name));
        panels.forEach(p => { p.hidden = p.dataset.panel !== name; });
    }
    tabs.forEach(t => t.addEventListener('click', () => showPanel(t.dataset.panel)));

    /* ================= MESSAGE FORM ================= */
    const msgFields = [
        { input: $('#cName'),    box: $('#c-name'),    check: v => v ? '' : 'Please enter your name.' },
        { input: $('#cEmail'),   box: $('#c-email'),   check: v => !v ? 'Please enter your email.' : (emailRe.test(v) ? '' : 'Please enter a valid email address.') },
        { input: $('#cSubject'), box: $('#c-subject'), check: v => v ? '' : 'Please enter a subject.' },
        { input: $('#cMessage'), box: $('#c-message'), check: v => !v ? 'Please write a message.' : (v.length < 10 ? 'Message must be at least 10 characters.' : '') }
    ];
    const runField = f => setError(f.box, f.check(f.input.value.trim()));

    msgFields.forEach(f => {
        f.input.addEventListener('blur', () => runField(f));
        f.input.addEventListener('input', () => { if (f.box.classList.contains('invalid')) runField(f); });
    });

    $('#contactForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const success = $('#msgSuccess');
        success.hidden = true;
        const ok = msgFields.map(runField).every(Boolean);   // check every field
        if (ok) {
            success.hidden = false;
            e.target.reset();
            setTimeout(() => { success.hidden = true; }, 5000);
        }
    });

    /* ================= BOOKING FORM ================= */
    const bf = $('#bookingForm');
    const studios = $$('input[name=studio]');
    const gear = $$('.gear-check');
    const bName = $('#bName'), bPhone = $('#bPhone'), bDate = $('#bDate');
    const bTime = $('#bTime'), bHours = $('#bHours'), bMembers = $('#bMembers');

    bDate.min = Bandit.todayISO();

    const fmtHour = h => { const hh = h % 24; return `${hh % 12 || 12}:00 ${hh >= 12 ? 'PM' : 'AM'}`; };
    const fmtDate = iso => new Date(iso + 'T00:00:00').toLocaleDateString('en-PH', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
    const pickedStudio = () => studios.find(s => s.checked);
    const pickedGear = () => gear.filter(g => g.checked);

    /* ---------- live price estimate ---------- */
    function estimate() {
        const st = pickedStudio();
        const hours = Number(bHours.value) || 1;
        const g = pickedGear();
        const gearRate = g.reduce((sum, x) => sum + Number(x.dataset.rate), 0);
        const total = ((st ? Number(st.dataset.rate) : 0) + gearRate) * hours;
        $('#estTotal').textContent = Bandit.peso(total);
        $('#estDetail').textContent = st
            ? `${st.dataset.name} × ${hours}h` + (g.length ? ` + ${g.length} instrument(s)` : '')
            : 'Choose a studio to see the price';
        return total;
    }
    [bHours, bDate, bTime, bMembers].forEach(i => i.addEventListener('input', estimate));
    studios.forEach(s => s.addEventListener('change', () => { $('#studioError').textContent = ''; estimate(); }));
    gear.forEach(g => g.addEventListener('change', estimate));

    /* ---------- prefill from the Home page (?studio= &date= &time= &gear=) ---------- */
    const q = new URLSearchParams(location.search);
    const preStudio = studios.find(s => s.value === q.get('studio'));
    if (preStudio) preStudio.checked = true;
    if (q.get('date') && q.get('date') >= Bandit.todayISO()) bDate.value = q.get('date');
    if (q.get('time')) bTime.value = q.get('time');
    (q.get('gear') || '').split(',').forEach(id => {
        const g = gear.find(x => x.value === id);
        if (g) g.checked = true;
    });
    if (location.hash === '#book' || ['studio', 'date', 'time', 'gear'].some(k => q.has(k))) showPanel('booking');
    estimate();

    /* ---------- validation ---------- */
    function validateBooking() {
        const st = pickedStudio();
        const hours = Number(bHours.value);
        const start = parseInt(bTime.value, 10);
        const members = Number(bMembers.value);
        let ok = true;

        ok = setError($('#b-name'), bName.value.trim().length < 2 ? 'Enter your name or band name.' : '') && ok;
        ok = setError($('#b-phone'), phoneRe.test(bPhone.value.replace(/[\s-]/g, '')) ? '' : 'Enter a valid PH mobile number (09XXXXXXXXX).') && ok;

        $('#studioError').textContent = st ? '' : 'Please choose a studio.';
        ok = !!st && ok;

        let dateMsg = '';
        if (!bDate.value) dateMsg = 'Pick a date.';
        else if (bDate.value < Bandit.todayISO()) dateMsg = 'Date cannot be in the past.';
        ok = setError($('#b-date'), dateMsg) && ok;

        let timeMsg = '';
        if (!bTime.value) timeMsg = 'Pick a start time.';
        else if (start + hours > 24) timeMsg = 'Session must end by 12:00 MN.';
        else if (bDate.value === Bandit.todayISO() && start <= new Date().getHours()) timeMsg = 'That time has already passed today.';
        ok = setError($('#b-time'), timeMsg) && ok;

        let memMsg = '';
        if (!members || members < 1 || members > 10) memMsg = 'Between 1 and 10 members.';
        else if (st && members > Number(st.dataset.cap)) memMsg = `${st.dataset.name} fits up to ${st.dataset.cap}.`;
        ok = setError($('#b-members'), memMsg) && ok;

        return ok;
    }

    // clear a field's error as soon as the user fixes it
    $$('#bookingForm .field input, #bookingForm .field select').forEach(el => {
        el.addEventListener('input', () => el.closest('.field').classList.remove('invalid'));
    });

    /* ---------- submit ---------- */
    bf.addEventListener('submit', (e) => {
        e.preventDefault();
        const success = $('#bookSuccess');
        success.hidden = true;

        if (!validateBooking()) {
            Bandit.toast('Please fix the highlighted fields');
            const bad = bf.querySelector('.field.invalid, .block-error:not(:empty)');
            if (bad) bad.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        const st = pickedStudio();
        const g = pickedGear();
        const hours = Number(bHours.value);
        const start = parseInt(bTime.value, 10);
        const total = estimate();
        const code = 'BNDT-' + Math.random().toString(36).slice(2, 8).toUpperCase();

        success.innerHTML =
            `<strong>✅ Booking request sent!</strong>` +
            `<span class="code">${code}</span>` +
            `<p>${st.dataset.name} · ${fmtDate(bDate.value)}, ${fmtHour(start)} – ${fmtHour(start + hours)}</p>` +
            `<p>${bMembers.value} member(s) · ${g.length} instrument(s) · Estimated total <b>${Bandit.peso(total)}</b></p>` +
            `<p class="small">Show this code when you arrive. We'll confirm by text.</p>`;
        success.hidden = false;
        success.scrollIntoView({ behavior: 'smooth', block: 'center' });

        bf.reset();
        estimate();
    });
});
