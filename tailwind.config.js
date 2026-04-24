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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                blob: 'blob 7s infinite',
                'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'slide-in-bottom': 'slideInBottom 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards',
                'pulse-glow': 'pulseGlow 2s infinite',
                'gradient-x': 'gradientX 4s ease infinite',
            },
            keyframes: {
                blob: {
                    '0%': { transform: 'translate(0px, 0px) scale(1)' },
                    '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                    '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                    '100%': { transform: 'translate(0px, 0px) scale(1)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInBottom: {
                    '0%': { opacity: '0', transform: 'translateY(100px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseGlow: {
                    '0%, 100%': { opacity: '1', filter: 'drop-shadow(0 0 10px rgba(168, 85, 247, 0.6))' },
                    '50%': { opacity: '0.8', filter: 'drop-shadow(0 0 25px rgba(236, 72, 153, 0.8))' },
                },
                gradientX: {
                    '0%, 100%': { 'background-size': '200% 200%', 'background-position': 'left center' },
                    '50%': { 'background-size': '200% 200%', 'background-position': 'right center' },
                },
            },
        },
    },

    plugins: [forms],
};
