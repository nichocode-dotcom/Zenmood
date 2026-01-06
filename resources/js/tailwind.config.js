/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Warna utama
        'primary': '#558B2F',
        'secondary': '#72B940',
        
        // Variant dari warna utama untuk shading
        'primary-dark': '#3D6622',
        'primary-light': '#6FAE3A',
        'secondary-dark': '#5A9A33',
        'secondary-light': '#8BC34A',
        
        // Warna untuk background/text yang tetap menggunakan primary/secondary
        'bg-primary': '#558B2F',
        'bg-secondary': '#72B940',
        'text-primary': '#558B2F',
        'text-secondary': '#72B940',
      },
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'],
      },
      backgroundColor: {
        'primary': '#558B2F',
        'secondary': '#72B940',
      },
      textColor: {
        'primary': '#558B2F',
        'secondary': '#72B940',
      },
      borderColor: {
        'primary': '#558B2F',
        'secondary': '#72B940',
      },
      gradientColorStops: {
        'primary': '#558B2F',
        'secondary': '#72B940',
      },
    },
  },
  plugins: [],
}