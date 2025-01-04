/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    '@tailwindcss/forms',
    require("daisyui"),
  ],
}