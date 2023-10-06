/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {
      fontFamily: {
        'montserrat': ['"Montserrat"', 'sans-serif'],
        'cormorant-garamond': ['"Cormorant Garamond"', 'serif'],
      },
    },
    plugins: [],
  }
}
