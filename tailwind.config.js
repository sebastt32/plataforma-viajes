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
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                warm: {
                    50: '#FAF8F5',
                    100: '#F3EDE6',
                    200: '#E8DFD4',
                    300: '#D4C8BA',
                    800: '#3D3429',
                    900: '#2A231C',
                },
                accent: {
                    DEFAULT: '#B45309',
                    light: '#FEF3C7',
                    dark: '#92400E',
                },
            },
            borderRadius: {
                DEFAULT: '0.5rem',
                lg: '0.75rem',
                xl: '1rem',
            },
            boxShadow: {
                card: '0 1px 3px 0 rgb(61 52 41 / 0.04)',
                'card-hover': '0 4px 12px 0 rgb(61 52 41 / 0.08)',
            },
        },
    },

    plugins: [forms],
};
