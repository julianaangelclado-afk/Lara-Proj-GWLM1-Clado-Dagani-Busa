/* ===== Shared helpers available on every page ===== */
window.Bandit = {
    pad: n => String(n).padStart(2, '0'),
    todayISO() {
        const d = new Date();
        return `${d.getFullYear()}-${this.pad(d.getMonth() + 1)}-${this.pad(d.getDate())}`;
    },
    peso: n => '₱' + Number(n).toLocaleString('en-PH'),
    toast(msg) {
        const t = document.getElementById('toast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(this._t);
        this._t = setTimeout(() => t.classList.remove('show'), 2400);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    /* ---------- Mobile menu ---------- */
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    navToggle.addEventListener('click', () => navLinks.classList.toggle('open'));

    /* ---------- Night / Light mode toggle (all pages) ---------- */
    const html = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    const paintIcon = () => { themeBtn.textContent = html.getAttribute('data-theme') === 'dark' ? '☀️' : '🌙'; };
    paintIcon();
    themeBtn.addEventListener('click', () => {
        const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        try { localStorage.setItem('bandit-theme', next); } catch (e) {}
        paintIcon();
    });

    /* ---------- Scroll reveal ---------- */
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('show'); });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
});
