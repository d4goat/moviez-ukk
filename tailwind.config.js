import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.ts',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'dark-bg' : '#171717',
                'gradient-left' : '#00d69a',
                'gradient-right' : '#229ae0',
                component: '#14171c',
                dropdown: '#26272e',
                text: '#000000',
                border: '#414141',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                open_sans: ['Open Sans', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif']
            },
        },
    },

    plugins: [forms],
};
