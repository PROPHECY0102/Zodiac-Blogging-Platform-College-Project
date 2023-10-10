/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                merriweather: ["Merriweather", "sans-serif"],
                hanken: ['"Hanken Grotesk"', "sans-serif"],
            },
        },
    },
    plugins: [],
};
