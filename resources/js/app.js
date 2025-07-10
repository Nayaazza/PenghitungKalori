import './bootstrap';

// Impor dan inisialisasi Alpine.js untuk fungsionalitas dropdown
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Impor dan jalankan fungsi inisialisasi kalkulator kita
import { initCalculator } from './calculator.js';

// Jalankan semua script setelah dokumen siap
$(document).ready(function() {
    initCalculator();

    // Kode untuk mobile menu (dari layout)
    if ($("#mobile-menu-button").length) {
        $("#mobile-menu-button").on("click", function () {
            $("#mobile-menu").slideToggle(300);
            $("#menu-icon").toggleClass("hidden");
            $("#close-icon").toggleClass("hidden");
        });
    }
});