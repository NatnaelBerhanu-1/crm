module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        'primary': '#183153',
        'primary-dark': '#1A516B'
        }
      },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
