import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery';
import { initCalculator } from './calculator.js';

window.Alpine = Alpine;
Alpine.start();
window.$ = $;

$(document).ready(function() {
    initCalculator();

    if ($("#mobile-menu-button").length) {
        $("#mobile-menu-button").on("click", function () {
            $("#mobile-menu").slideToggle(300);
            $("#menu-icon").toggleClass("hidden");
            $("#close-icon").toggleClass("hidden");
        });
    }
});