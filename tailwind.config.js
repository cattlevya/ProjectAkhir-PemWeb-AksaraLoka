import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                "brand-cream":   "#fbfbe2",
                "brand-indigo":  "#191c3c",
                "brand-brown":   "#934b19",
                "brand-ochre":   "#c58c2b",
                "surface":                    "#fbfbe2",
                "surface-bright":             "#ffffff",
                "surface-container-lowest":   "#ffffff",
                "surface-container-low":      "#f5f5dc",
                "surface-container":          "#efeed1",
                "surface-container-high":     "#eae8ca",
                "surface-container-highest":  "#e4e2c2",
                "surface-dim":                "#dedec3",
                "surface-variant":            "#e6e1d6",
                "on-surface":          "#191c3c",
                "on-surface-variant":  "#49454f",
                "on-background":       "#191c3c",
                "on-primary":          "#ffffff",
                "on-secondary":        "#ffffff",
                "primary":             "#191c3c",
                "primary-dim":         "#12142d",
                "primary-container":   "#dce1ff",
                "secondary":           "#934b19",
                "secondary-container": "#ffdcbe",
                "tertiary":            "#c58c2b",
                "tertiary-container":  "#f4e2ba",
                "outline":             "#79747e",
                "outline-variant":     "#c9c5b4",
                "error":               "#ba1a1a",
                "background":          "#fbfbe2",
                "inverse-surface":     "#191c3c",
            },
            borderRadius: {
                DEFAULT: "0.5rem",
                lg:  "0.75rem",
                xl:  "1rem",
                "2xl": "1.5rem",
                "3xl": "2rem",
                full: "9999px",
            },
            fontFamily: {
                headline: ["Epilogue", ...defaultTheme.fontFamily.sans],
                body:     ["Manrope", ...defaultTheme.fontFamily.sans],
                label:    ["Manrope", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'bounce-short': 'bounce 1s ease-in-out 3',
                'slide-up': 'slideUp 0.5s ease-out forwards',
            },
            keyframes: {
                slideUp: { '0%': { transform: 'translateY(100%)', opacity: 0 }, '100%': { transform: 'translateY(0)', opacity: 1 } }
            }
        },
    },
    plugins: [forms],
};
