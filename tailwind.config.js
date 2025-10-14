// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // habilita modo oscuro si lo usas
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js', // ⬅️ por si usas Alpine/JS con clases Tailwind
        './resources/**/*.vue', // ⬅️ por si usas Vue más adelante
    ],
    theme: {
        extend: {
            fontFamily: { sans: ['Figtree', ...defaultTheme.fontFamily.sans] },
        },
    },
    plugins: [forms],

    // (Opcional) Evita que Tailwind purgue clases que pongas por ancla (#password) o generes condicionalmente
    safelist: [
        'hover:bg-amber-500', 'hover:bg-amber-600', 'text-amber-600', 'hover:text-amber-700',
        'ring-amber-400', 'focus:ring-amber-400', 'border-amber-600/60',
        'bg-slate-900', 'hover:bg-slate-800', 'text-white'
    ],
}