// dashboard.js
window.selectedRating = 0;

document.addEventListener('mouseover', (e) => {
    if (e.target.matches('.swal-rating i')) {
        window.selectedRating = e.target.dataset.value;
    }
});

import Swal from 'sweetalert2';

window.Swal = Swal;

document.addEventListener('DOMContentLoaded', () => {

    console.log("dashboard.js loaded");

    if (!window.ratingData) {
        console.log("ratingData missing");
        return;
    }

    console.log(window.ratingData);

    const ratingStatus = window.ratingData.status;

    if (ratingStatus !== "show") {
        return;
    }

    // Show popup
    if (
        ratingStatus === "show"
    ) {

        let selectedRating = 0;

        Swal.fire({
            title: 'Rate Your Experience',
            width: '600px',

            html: `
                <div class="swal-rating d-flex justify-content-center gap-2 fs-1">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </div>

                <textarea
                    id="swalComment"
                    class="swal2-textarea mt-3"
                    style="width: 400px;"
                    placeholder="Optional comment..."
                ></textarea>
            `,

            showCancelButton: true,
            showDenyButton: true,

            confirmButtonText: 'Submit',
            denyButtonText: 'Do it later',

            confirmButtonColor: '#c59d5f',

            didOpen: () => {

                const popup = Swal.getPopup();

                const stars = popup.querySelectorAll('.swal-rating i');

                const confirmBtn = Swal.getConfirmButton();

                confirmBtn.disabled = true;

                function highlight(value) {

                    stars.forEach(star => {

                        if (star.dataset.value <= value) {

                            star.classList.remove('bi-star');

                            star.classList.add(
                                'bi-star-fill',
                                'text-warning'
                            );

                        } else {

                            star.classList.remove(
                                'bi-star-fill',
                                'text-warning'
                            );

                            star.classList.add('bi-star');
                        }
                    });
                }

                stars.forEach(star => {

                    star.addEventListener('mouseenter', () => {
                        highlight(star.dataset.value);
                    });

                    star.addEventListener('click', () => {

                        selectedRating = star.dataset.value;

                        highlight(selectedRating);

                        confirmBtn.disabled = false;
                    });
                });
            }

        }).then((result) => {

            // SUBMIT RATING
            if (result.isConfirmed) {

                const comment =
                    document.getElementById('swalComment').value;

                fetch(window.routes.rate, {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },

                    body: JSON.stringify({
                        rating: selectedRating,
                        comment: comment
                    })

                })
                    .then(res => res.json())

                    .then(data => {

                        Swal.fire(
                            'Thank You!',
                            data.message,
                            'success'
                        );
                    })

                    .catch(err => {

                        console.error(err);

                        Swal.fire(
                            'Error',
                            'Something went wrong',
                            'error'
                        );
                    });
            }

            // SKIP
            else if (result.isDenied) {

                fetch(window.routes.skip, {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },

                })
                    .then(res => res.json())

                    .then(data => {

                        Swal.fire(
                            'Skipped!',
                            data.message,
                            'info'
                        );
                    })

                    .catch(err => {

                        console.error(err);

                        Swal.fire(
                            'Error',
                            'Skip failed',
                            'error'
                        );
                    });
            }

            // CANCELLED
            else if (result.dismiss === Swal.DismissReason.cancel) {

                fetch(window.routes.cancel, {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }

                });
            }
        });
    }
});


// Counter animation
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.dataset.count;
        const speed = target / 200;

        const update = () => {
            const count = +counter.innerText;
            if (count < target) {
                counter.innerText = Math.ceil(count + speed);
                setTimeout(update, 10);
            } else {
                counter.innerText = target;
            }
        };
        update();
    });
});
