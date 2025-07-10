import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // Palet warna tema kuning-oranye
                primary: {
                    light: '#FFD6A5', // Kuning muda
                    DEFAULT: '#FFA500', // Oranye
                    dark: '#FF8C00', // Oranye tua
                },
                secondary: '#4A5568', // Abu-abu untuk teks
                light: '#F7FAFC',    // Latar belakang kartu
            },
            fontFamily: {
                // Menggunakan font yang sudah ada di proyek Anda
                sans: ['"Instrument Sans"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [],
};