import axios from 'axios';
import $ from 'jquery'; // Impor jQuery di sini

window.axios = axios;
window.$ = window.jQuery = $; // Jadikan jQuery global

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Mengambil token CSRF dari meta tag dan menyiapkannya untuk semua permintaan AJAX.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    // Setup untuk Axios (bawaan Breeze)
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

    // Setup untuk jQuery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token.content
        }
    });
} else {
    console.error('CSRF token not found. Pastikan ada <meta name="csrf-token"> di layout Anda.');
}