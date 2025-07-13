import './bootstrap';

// Import Alpine.js untuk komponen interaktif Laravel Breeze
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Import jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// Import dan jalankan skrip kalkulator kita
import { initCalculator } from './calculator.js';

// Pastikan DOM sudah siap sebelum menjalankan skrip
$(document).ready(function() {
    initCalculator();
});
