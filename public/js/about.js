document.addEventListener('DOMContentLoaded', () => {
    /* ---------- Read More / Read Less ---------- */
    const btn = document.getElementById('readMoreBtn');
    const more = document.getElementById('moreText');
    btn.addEventListener('click', () => {
        const open = more.classList.toggle('show');
        btn.textContent = open ? 'Read Less' : 'Read More';
    });

    /* ---------- Animated number counters ---------- */
    function runCounter(el) {
        const target = Number(el.dataset.target);
        const duration = 1800;
        const start = performance.now();
        (function tick(now) {
            const p = Math.min((now - start) / duration, 1);
            el.textContent = Math.floor(p * target).toLocaleString();
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    }
    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach(e => {
            if (e.isIntersecting) { runCounter(e.target); obs.unobserve(e.target); }
        });
    }, { threshold: 0.6 });
    document.querySelectorAll('.count').forEach(c => io.observe(c));
});
