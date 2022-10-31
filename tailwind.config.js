const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            'red': '#ED9487',
            'green': '#ABD8AD',
            'blue': '#ADD9E5',
            'gray': '#37302F',
            'white': '#FFFFFF',
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
