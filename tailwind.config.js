/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                teal: {
                    50: '#f0fdfa', 600: '#0d9488', 700: '#0f766e', 900: '#134e4a',
                },
            },
        },
    },
    plugins: [],
};
