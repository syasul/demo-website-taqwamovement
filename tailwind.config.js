import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                brand: {
                    white: '#FAF9F6',
                    primary: '#502E88',
                    secondary: '#7558B1',
                    accent: '#CA80DC',
                    blush: '#E2A5BA',
                    'blush-lt': '#EDCCD7',
                    ink: '#241640',
                    navy: '#0A0F1D',
                    gold: '#C5A880',
                    cream: '#F9F6F0',
                    glass: 'rgba(255, 255, 255, 0.08)',
                }
            },
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                serif: ['Poppins', ...defaultTheme.fontFamily.serif],
                accent: ['Poppins', 'sans-serif'],
            },
            fontSize: {
                'hero': ['3.5rem', { lineHeight: '1.1', letterSpacing: '-0.02em' }],
                'h1': ['2.75rem', { lineHeight: '1.2', letterSpacing: '-0.01em' }],
                'h2': ['2rem', { lineHeight: '1.3' }],
                'h3': ['1.5rem', { lineHeight: '1.4' }],
                'body-lg': ['1.125rem', { lineHeight: '1.5' }],
                'body': ['1rem', { lineHeight: '1.6' }],
                'caption': ['0.875rem', { lineHeight: '1.5' }],
            },
            boxShadow: {
                'brand-soft': '0 8px 30px rgba(80, 46, 136, 0.08)',
                'glow': '0 0 20px rgba(197, 168, 128, 0.15)',
            }
        },
    },

    plugins: [forms],
};
