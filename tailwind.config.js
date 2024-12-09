/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.{php,js}",
    "./public/assets/**/*.{php,js}",
    "./public/src/**/*.{php,js}",
    "./public/src/views/**/*.{php,js}",
    "./public/views/pages/*.{php,js}",
    "./public/layouts/*.{php,js}",
  ],
  theme: {
    extend: {
      screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1280px',
        '2xl': '1536px',
      },
    },
  },
  plugins: [],
};
