import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './vendor/lara-zeus/accordion/resources/views/**/*.blade.php',
        // './vendor/guava/calendar/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                'primaryBtn': '#1bdbe0',
                'bgDark': '#09090b',
                'bgDarkLight': '#18181b',

            },
            animation: {
                'spin-slow': 'spin 3s linear infinite',
            },
            fontFamily: {
                arial: ["Arial"],
            }
        },
    },
    // plugins: [require("daisyui")],
}

