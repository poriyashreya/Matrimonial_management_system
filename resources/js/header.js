document.addEventListener("DOMContentLoaded", function () {

    // ---- MOBILE MENU ----
    const menuBtn = document.getElementById("menuBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    if (menuBtn) {
        menuBtn.addEventListener("click", function () {
            mobileMenu.style.display =
                mobileMenu.style.display === "block" ? "none" : "block";
        });
    }

    // ---- PROFILE IMAGE CLICK ----

    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-count');
            const count = +counter.innerText;

            const increment = target / 200;

            if(count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 10);
            } else {
                counter.innerText = target;
            }
        }
        updateCount();
    });
});