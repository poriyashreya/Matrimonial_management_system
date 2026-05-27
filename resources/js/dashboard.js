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
    if (!window.ratingData) return;

    const ratingStatus = window.ratingData.status;

    // Show rating popup only for new users
    if (ratingStatus === "new") {
        let selectedRating = 0;
        Swal.fire({
            title: 'Rate Your Experience',
            width: '700px',
            html: `
                <div class="swal-rating d-flex justify-content-center gap-2">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </div>
                <textarea
                    id="swalComment"
                    class="swal2-textarea mt-3"
                    style="width: 100%; max-width: 500px;"
                    placeholder="Optional comment..."></textarea>
            `,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Submit',
            denyButtonText: 'Do it later',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#c59d5f',
            allowOutsideClick: false,

            didOpen: () => {

                const popup = Swal.getPopup();
                const stars = popup.querySelectorAll('.swal-rating i');
                const starWrapper = popup.querySelector('.swal-rating');
                const confirmBtn = Swal.getConfirmButton();

                // Disable submit initially
                confirmBtn.disabled = true;

                // Highlight function
                function highlight(value) {
                    stars.forEach(star => {
                        if (star.dataset.value <= value) {
                            star.classList.remove('bi-star');
                            star.classList.add('bi-star-fill', 'active');
                        } else {
                            star.classList.remove('bi-star-fill', 'active');
                            star.classList.add('bi-star');
                        }
                    });
                }

                // Hover & click logic
                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => highlight(star.dataset.value));
                    star.addEventListener('click', () => {
                        selectedRating = star.dataset.value;
                        highlight(selectedRating);
                        confirmBtn.disabled = false;
                    });
                });

                starWrapper.addEventListener('mouseleave', () => highlight(selectedRating));
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Rating submitted:', selectedRating);
                const comment = document.getElementById('swalComment').value;
                fetch(window.routes.rate, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rating: selectedRating, comment })
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Thank you!', data.success, 'success');
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    });
            } else if (result.isDenied) {
                console.log("Skip URL:", window.routes.skip);
                const comment = null;
                selectedRating = null;
                console.log(JSON.stringify({ skip: 1 }))
                fetch(window.routes.skip, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json", // ✅ REQUIRED
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    },
                    body: JSON.stringify({ skip: 1 })
                })
                    .then(async (res) => {

                        // ✅ If response is NOT JSON, print it
                        if (!res.ok) {
                            const text = await res.text();
                            console.error("Laravel returned HTML:", text);
                            throw new Error("Server did not return JSON");
                        }

                        return res.json();
                    })
                    .then(data => {
                        Swal.fire("Skipped!", data.success, "info");
                    })
                    .catch(err => {
                        console.error("Fetch Error:", err);
                        Swal.fire("Error", "Backend failed. Check laravel.log", "error");
                    });

            }
        });
    }

    // Already skipped
    if (ratingStatus === "skip") {
        let selectedRating = 0;
        Swal.fire({
            title: 'Rate Your Experience',
            width: '700px',
            html: `
                <div class="swal-rating d-flex justify-content-center gap-2">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </div>
                <textarea
                    id="swalComment"
                    class="swal2-textarea mt-3"
                    style="width: 100%; max-width: 500px;"
                    placeholder="Optional comment..."></textarea>
            `,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Submit',
            denyButtonText: 'Do it later',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#c59d5f',
            allowOutsideClick: false,

            didOpen: () => {

                const popup = Swal.getPopup();
                const stars = popup.querySelectorAll('.swal-rating i');
                const starWrapper = popup.querySelector('.swal-rating');
                const confirmBtn = Swal.getConfirmButton();

                // Disable submit initially
                confirmBtn.disabled = true;

                // Highlight function
                function highlight(value) {
                    stars.forEach(star => {
                        if (star.dataset.value <= value) {
                            star.classList.remove('bi-star');
                            star.classList.add('bi-star-fill', 'active');
                        } else {
                            star.classList.remove('bi-star-fill', 'active');
                            star.classList.add('bi-star');
                        }
                    });
                }

                // Hover & click logic
                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => highlight(star.dataset.value));
                    star.addEventListener('click', () => {
                        selectedRating = star.dataset.value;
                        highlight(selectedRating);
                        confirmBtn.disabled = false;
                    });
                });

                starWrapper.addEventListener('mouseleave', () => highlight(selectedRating));
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Rating submitted:', selectedRating);
                const comment = document.getElementById('swalComment').value;
                fetch(window.routes.rate, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rating: selectedRating, comment })
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Thank you!', data.success, 'success');
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    });
            } else if (result.isDenied) {
                console.log("Skip URL:", window.routes.skip);
                const comment = null;
                selectedRating = null;
                console.log(JSON.stringify({ skip: 1 }))
                fetch(window.routes.skip, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json", // ✅ REQUIRED
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    },
                    body: JSON.stringify({ skip: 1 })
                })
                    .then(async (res) => {

                        // ✅ If response is NOT JSON, print it
                        if (!res.ok) {
                            const text = await res.text();
                            console.error("Laravel returned HTML:", text);
                            throw new Error("Server did not return JSON");
                        }

                        return res.json();
                    })
                    .then(data => {
                        Swal.fire("Skipped!", data.success, "info");
                    })
                    .catch(err => {
                        console.error("Fetch Error:", err);
                        Swal.fire("Error", "Backend failed. Check laravel.log", "error");
                    });

            }
        });
    }

    // Already rated
    if (ratingStatus === "rated") {
        let selectedRating = 0;
        Swal.fire({
            title: 'Rate Your Experience',
            width: '700px',
            html: `
                <div class="swal-rating d-flex justify-content-center gap-2">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </div>
                <textarea
                    id="swalComment"
                    class="swal2-textarea mt-3"
                    style="width: 100%; max-width: 500px;"
                    placeholder="Optional comment..."></textarea>
            `,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Submit',
            denyButtonText: 'Do it later',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#c59d5f',
            allowOutsideClick: false,

            didOpen: () => {

                const popup = Swal.getPopup();
                const stars = popup.querySelectorAll('.swal-rating i');
                const starWrapper = popup.querySelector('.swal-rating');
                const confirmBtn = Swal.getConfirmButton();

                // Disable submit initially
                confirmBtn.disabled = true;

                // Highlight function
                function highlight(value) {
                    stars.forEach(star => {
                        if (star.dataset.value <= value) {
                            star.classList.remove('bi-star');
                            star.classList.add('bi-star-fill', 'active');
                        } else {
                            star.classList.remove('bi-star-fill', 'active');
                            star.classList.add('bi-star');
                        }
                    });
                }

                // Hover & click logic
                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => highlight(star.dataset.value));
                    star.addEventListener('click', () => {
                        selectedRating = star.dataset.value;
                        highlight(selectedRating);
                        confirmBtn.disabled = false;
                    });
                });

                starWrapper.addEventListener('mouseleave', () => highlight(selectedRating));
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Rating submitted:', selectedRating);
                const comment = document.getElementById('swalComment').value;
                fetch(window.routes.rate, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rating: selectedRating, comment })
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Thank you!', data.success, 'success');
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    });
            } else if (result.isDenied) {
                console.log("Skip URL:", window.routes.skip);
                const comment = null;
                selectedRating = null;
                console.log(JSON.stringify({ skip: 1 }))
                fetch(window.routes.skip, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json", // ✅ REQUIRED
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    },
                    body: JSON.stringify({ skip: 1 })
                })
                    .then(async (res) => {

                        // ✅ If response is NOT JSON, print it
                        if (!res.ok) {
                            const text = await res.text();
                            console.error("Laravel returned HTML:", text);
                            throw new Error("Server did not return JSON");
                        }

                        return res.json();
                    })
                    .then(data => {
                        Swal.fire("Skipped!", data.success, "info");
                    })
                    .catch(err => {
                        console.error("Fetch Error:", err);
                        Swal.fire("Error", "Backend failed. Check laravel.log", "error");
                    });

            }
        });
    }

    if (ratingStatus === "null") {
        let selectedRating = 0;
        Swal.fire({
            title: 'Rate Your Experience',
            width: '700px',
            html: `
                <div class="swal-rating d-flex justify-content-center gap-2">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </div>
                <textarea
                    id="swalComment"
                    class="swal2-textarea mt-3"
                    style="width: 100%; max-width: 500px;"
                    placeholder="Optional comment..."></textarea>
            `,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Submit',
            denyButtonText: 'Do it later',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#c59d5f',
            allowOutsideClick: false,

            didOpen: () => {

                const popup = Swal.getPopup();
                const stars = popup.querySelectorAll('.swal-rating i');
                const starWrapper = popup.querySelector('.swal-rating');
                const confirmBtn = Swal.getConfirmButton();

                // Disable submit initially
                confirmBtn.disabled = true;

                // Highlight function
                function highlight(value) {
                    stars.forEach(star => {
                        if (star.dataset.value <= value) {
                            star.classList.remove('bi-star');
                            star.classList.add('bi-star-fill', 'active');
                        } else {
                            star.classList.remove('bi-star-fill', 'active');
                            star.classList.add('bi-star');
                        }
                    });
                }

                // Hover & click logic
                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => highlight(star.dataset.value));
                    star.addEventListener('click', () => {
                        selectedRating = star.dataset.value;
                        highlight(selectedRating);
                        confirmBtn.disabled = false;
                    });
                });

                starWrapper.addEventListener('mouseleave', () => highlight(selectedRating));
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Rating submitted:', selectedRating);
                const comment = document.getElementById('swalComment').value;
                fetch(window.routes.rate, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rating: selectedRating, comment })
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Thank you!', data.success, 'success');
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    });
            } else if (result.isDenied) {
                console.log("Skip URL:", window.routes.skip);
                const comment = null;
                selectedRating = null;
                console.log(JSON.stringify({ skip: 1 }))
                fetch(window.routes.skip, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json", // ✅ REQUIRED
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    },
                    body: JSON.stringify({ skip: 1 })
                })
                    .then(async (res) => {

                        // ✅ If response is NOT JSON, print it
                        if (!res.ok) {
                            const text = await res.text();
                            console.error("Laravel returned HTML:", text);
                            throw new Error("Server did not return JSON");
                        }

                        return res.json();
                    })
                    .then(data => {
                        Swal.fire("Skipped!", data.success, "info");
                    })
                    .catch(err => {
                        console.error("Fetch Error:", err);
                        Swal.fire("Error", "Backend failed. Check laravel.log", "error");
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
