document.addEventListener('DOMContentLoaded', () => {
    /* ---------- Hero equalizer bars ---------- */
    const eq = document.getElementById('heroEq');
    if (eq) {
        for (let i = 0; i < 22; i++) {
            const bar = document.createElement('span');
            bar.style.setProperty('--d', (Math.random() * 0.8 + 0.45).toFixed(2) + 's');
            bar.style.animationDelay = (-Math.random()).toFixed(2) + 's';
            eq.appendChild(bar);
        }
    }

    /* ---------- Quick appointment bar -> Contact page, booking tab ---------- */
    const form = document.getElementById('quickBook');
    if (form) {
        form.querySelector('[name=date]').min = Bandit.todayISO();

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const params = new URLSearchParams();
            ['studio', 'date', 'time'].forEach(name => {
                const v = form.querySelector(`[name=${name}]`).value;
                if (v) params.set(name, v);
            });
            const qs = params.toString();
            window.location.href = form.dataset.action + (qs ? '?' + qs : '') + '#book';
        });
    }

    /* ---------- Studio cards: glow that follows the mouse + soft tilt ---------- */
    if (window.matchMedia('(hover: hover)').matches) {
        document.querySelectorAll('.studio-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const r = card.getBoundingClientRect();
                const x = e.clientX - r.left, y = e.clientY - r.top;
                card.style.setProperty('--mx', x + 'px');
                card.style.setProperty('--my', y + 'px');
                const rx = ((y / r.height) - 0.5) * -5;
                const ry = ((x / r.width) - 0.5) * 6;
                card.style.transform = `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
            });
            card.addEventListener('mouseleave', () => { card.style.transform = ''; });
        });
    }

    /* ---------- Instrument gallery: category filter ---------- */
    const tabs = [...document.querySelectorAll('#gearTabs .tab')];
    const cards = [...document.querySelectorAll('.gear-card')];
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.toggle('active', t === tab));
            cards.forEach(c => {
                c.hidden = !(tab.dataset.filter === 'all' || c.dataset.cat === tab.dataset.filter);
            });
        });
    });
});
