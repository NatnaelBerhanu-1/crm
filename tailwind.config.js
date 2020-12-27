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
        'primary': '#3D68FF',
        'primary-dark': '#1947EE'
        }
      },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
