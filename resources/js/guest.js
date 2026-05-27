import './bootstrap';

/* ================================
   NAVBAR SCROLL EFFECT (SAFE)
================================ */
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.glass-navbar');

    // ✅ prevent null error
    if (!nav) return;

    if (window.scrollY > 50) {
        nav.style.background = 'rgba(255,255,255,0.95)';
    } else {
        nav.style.background = 'rgba(255,255,255,0.75)';
    }
});


/* ================================
   DOM READY
================================ */
document.addEventListener('DOMContentLoaded', () => {

    /* ==========================
       COUNTER ANIMATION (SAFE)
    ========================== */
    document.querySelectorAll('.counter').forEach(counter => {

        // ✅ ensure data-target exists
        const target = parseInt(counter.dataset.target);
        if (isNaN(target)) return;

        let count = 0;

        const update = () => {
            if (count < target) {
                count += Math.ceil(target / 100);
                counter.innerText = count;
                setTimeout(update, 20);
            } else {
                counter.innerText = target + '+';
            }
        };

        update();
    });

});
