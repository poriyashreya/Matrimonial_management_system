import $ from 'jquery';
window.$ = window.jQuery = $;

import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";


// SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Handle Laravel flash messages (global)
document.addEventListener('DOMContentLoaded', () => {

    if (!window.flashData) return;

    const flash = window.flashData;

    if (flash.success) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: flash.success,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            didOpen: () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.disabled = false;
            },
            timer: 3000
        });
    }

    if (flash.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: flash.error,
            confirmButtonColor: '#d33',
            didOpen: () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.disabled = false;
            },
            timer: 3000
        });
    }

    if (flash.warning) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: flash.warning,
            didOpen: () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.disabled = false;
            },
            timer: 3000
        });
    }

    if (flash.info) {
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: flash.info,
            didOpen: () => {
                const confirmBtn = Swal.getConfirmButton();
                confirmBtn.disabled = false;
            },
            timer: 3000
        });
    }
});

$(document).ready(function () {

    const oldCountry = window.profileLocation?.country;
    const oldState = window.profileLocation?.state;
    const oldCity = window.profileLocation?.city;

    /* LOAD STATES */
    function loadStates(countryId, selectedState = null) {
        if (!countryId) return;

        $('#state').html('<option value="">Loading...</option>');
        $('#city').html('<option value="">Select City</option>');

        $.get(`/get-states/${countryId}`, function (states) {
            let options = '<option value="">Select State</option>';

            states.forEach(state => {
                options += `
                    <option value="${state.id}"
                        ${state.id == selectedState ? 'selected' : ''}>
                        ${state.name}
                    </option>`;
            });

            $('#state').html(options);

            if (selectedState) {
                loadCities(selectedState, oldCity);
            }
        });
    }

    /* =========================
       LOAD CITIES
    ========================= */
    function loadCities(stateId, selectedCity = null) {
        if (!stateId) return;

        $('#city').html('<option value="">Loading...</option>');

        $.get(`/get-cities/${stateId}`, function (cities) {
            let options = '<option value="">Select City</option>';

            cities.forEach(city => {
                options += `
                    <option value="${city.id}"
                        ${city.id == selectedCity ? 'selected' : ''}>
                        ${city.name}
                    </option>`;
            });

            $('#city').html(options);
        });
    }

    /* =========================
       EVENTS
    ========================= */
    $('#country').on('change', function () {
        loadStates(this.value);
    });

    $('#state').on('change', function () {
        loadCities(this.value);
    });

    /* =========================
       AUTO LOAD EDIT DATA
    ========================= */
    if (oldCountry) {
        loadStates(oldCountry, oldState);
    }
});



// STEP FORM
window.nextStep = function (step) {
    document.querySelectorAll('[id^="step"]').forEach(el => el.classList.add('hidden'));
    const current = document.getElementById('step' + step);
    if (current) current.classList.remove('hidden');

    updateIndicator(step);

    if (step === 3) {
        setTimeout(() => {
            if ($('.select2').length) {
                $('.select2').select2({
                    placeholder: 'Select personality traits',
                    allowClear: true,
                    closeOnSelect: false,
                    width: '100%',
                    dropdownParent: $('#step3'),
                    minimumResultsForSearch: -1
                });
            }
        }, 100);
    }
};

document.addEventListener("DOMContentLoaded", () => {
    new TomSelect("#skills", {
        plugins: ['remove_button'],
        maxItems: null,
        closeAfterSelect: false,
    });
});

window.prevStep = function (step) {
    nextStep(step);
};

function updateIndicator(step) {
    document.querySelectorAll('[id^="indicator"]').forEach(el => el.classList.remove('active'));
    const active = document.getElementById('indicator' + step);
    if (active) active.classList.add('active');
}

const img = document.getElementById('profileImage');
const upload = document.getElementById('profileUpload');
img.onclick = () => upload.click();
upload.onchange = e => img.src = URL.createObjectURL(e.target.files[0]);

const modal = document.getElementById('activationModal');
modal.addEventListener('show.bs.modal', e => {
    const action = e.relatedTarget.dataset.action;
    document.getElementById('activationInput').value = action;

    if (action === 'deactivate') {
        modalTitle.innerText = 'Deactivate Profile?';
        modalText.innerText = 'Your profile will be hidden from others.';
        modalConfirm.className = 'btn btn-danger';
    } else {
        modalTitle.innerText = 'Activate Profile?';
        modalText.innerText = 'Your profile will be visible to others.';
        modalConfirm.className = 'btn btn-success';
    }
});
