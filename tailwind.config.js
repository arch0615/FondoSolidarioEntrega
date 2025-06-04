import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: { // Paleta de verdes para JAEC
                    50: '#f0f9f4',
                    100: '#dcf2e4',
                    200: '#bce5cd',
                    300: '#8dd1ab',
                    400: '#57b582',
                    500: '#339966', // Verde principal JAEC
                    600: '#2a7d54',
                    700: '#236446',
                    800: '#1e5038',
                    900: '#1a4230',
                    950: '#0d2519', // Un tono más oscuro si es necesario
                },
                secondary: { // Paleta neutral para complementar
                    50: '#f8fafc', // Gris muy claro
                    100: '#f1f5f9', // Gris claro
                    200: '#e2e8f0', // Gris un poco más oscuro
                    300: '#cbd5e1', // Gris medio claro
                    400: '#94a3b8', // Gris medio
                    500: '#64748b', // Gris medio oscuro (bueno para texto secundario) - REVERTIDO
                    600: '#475569', // Gris oscuro
                    700: '#334155', // Gris muy oscuro (bueno para texto principal)
                    800: '#1e293b', // Casi negro
                    900: '#0f172a', // Negro azulado
                    950: '#020617', // Negro profundo
                },
                // Puedes añadir más paletas si es necesario, por ejemplo para alertas:
                danger: {
                    50: '#fff1f2',
                    100: '#ffe4e6',
                    200: '#fecdd3',
                    300: '#fda4af',
                    400: '#fb7185',
                    500: '#f43f5e', // Rojo principal para errores/peligro
                    600: '#e11d48',
                    700: '#be123c',
                    800: '#9f1239',
                    900: '#881337',
                    950: '#4c0519',
                },
                warning: {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#f59e0b', // Amarillo/Naranja para advertencias
                    600: '#d97706',
                    700: '#b45309',
                    800: '#92400e',
                    900: '#78350f',
                    950: '#451a03',
                },
                success: { // Ya tienes una paleta verde como 'primary', pero podrías tener una específica para éxito si difiere
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e', // Verde para éxito
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                }
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-in': 'slideIn 0.3s ease-out',
                'bounce-in': 'bounceIn 0.6s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideIn: {
                    '0%': { transform: 'translateY(-10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                bounceIn: {
                    '0%, 20%, 40%, 60%, 80%': {
                        transform: 'translateY(0)',
                        animationTimingFunction: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
                    },
                    '40%': {
                        transform: 'translateY(-30px) scaleY(1.1)',
                        animationTimingFunction: 'cubic-bezier(0.755, 0.05, 0.855, 0.06)',
                    },
                    '60%': {
                        transform: 'translateY(-15px) scaleY(1.05)',
                        animationTimingFunction: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
                    },
                    '80%': {
                        transform: 'translateY(0) scaleY(0.95)',
                        animationTimingFunction: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
                    },
                    '100%': {
                        transform: 'translateY(0) scaleY(1)',
                        animationTimingFunction: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
                    },
                },
            },
        },
    },

    plugins: [forms],
};