import AOS from 'aos';
import 'aos/dist/aos.css';
import { Chart, registerables } from 'chart.js';

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
            }
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
            }
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
            }
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
            }
        });
    }
});

Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {

    AOS.init({ duration: 1000, once: true });

    const createChart = (canvas, config) => {
        if (canvas) return new Chart(canvas.getContext('2d'), config);
    };

    // ================= Verification Doughnut =================
    createChart(document.getElementById('verificationChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending','Approved','Rejected'],
            datasets: [{
                data: window.verificationData,
                backgroundColor: ['#C9A24D','#2E7D32','#B71C1C'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { position: 'bottom', labels: { padding: 15, font: { size: 14, weight: '500' } } } }
        }
    });

    // ================= User Registrations Line Chart =================
    const lineCanvas = document.getElementById('userRegistrationChart');
    if (lineCanvas) {
        const ctx = lineCanvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(123,30,30,0.6)');
        gradient.addColorStop(1, 'rgba(123,30,30,0.05)');

        createChart(lineCanvas, {
            type: 'line',
            data: { labels: window.userRegistrations.labels, datasets: [{
                label: 'Users',
                data: window.userRegistrations.data,
                borderColor: '#7B1E1E',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.45,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#F5E6C8',
                pointBorderColor: '#7B1E1E',
                pointHoverRadius: 7
            }]},
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f0e6dc' }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false }, ticks: { font: { weight: '500' } } }
                }
            }
        });
    }

    // ================= Profiles Created Bar Chart =================
    createChart(document.getElementById('profilesCreatedChart'), {
        type: 'bar',
        data: { labels: window.profilesCreated.labels, datasets: [{
            label: 'Profiles Created',
            data: window.profilesCreated.data,
            backgroundColor: '#2b539dff',
            borderRadius: 8
        }]},
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f0e6dc' } },
                x: { grid: { display: false }, ticks: { font: { weight: '500' } } }
            }
        }
    });

    // ================= Profiles by City Horizontal Bar =================
    createChart(document.getElementById('profilesByCityChart'), {
        type: 'bar',
        data: { labels: window.profilesByCityData.labels, datasets: [{
            label: 'Profiles',
            data: window.profilesByCityData.data,
            backgroundColor: '#B71C1C',
            borderWidth: 1
        }]},
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { color: '#f0e6dc' } },
                y: { grid: { display: false } }
            }
        }
    });

    // ================= Equal Height Cards =================
    function fixEqualHeight() {
        const cards = document.querySelectorAll('.equal-card');
        let maxHeight = 0;
        cards.forEach(card => { card.style.height = 'auto'; maxHeight = Math.max(maxHeight, card.offsetHeight); });
        cards.forEach(card => card.style.height = maxHeight + 'px');
    }
    fixEqualHeight();
    window.addEventListener('resize', fixEqualHeight);
});