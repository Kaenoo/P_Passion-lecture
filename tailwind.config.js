/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}", //"./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    '@tailwindcss/forms',
    require("daisyui"),
    // require('flowbite/plugin'),
  ],
}