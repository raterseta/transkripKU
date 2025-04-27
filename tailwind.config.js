/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundImage: {
        'hero': "url('/public/images/background.jpg')",
        'footer': "url('/public/images/footer.jpeg')",
        // 'footer-texture': "url('/images/footer-texture.png')",
      }
    },
  },
  plugins: [],
}