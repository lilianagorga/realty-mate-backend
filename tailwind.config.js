/** @type {import('tailwindcss').Config} */
export default {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: {
            'pink-100': '#FDE8E8',
            'beige-100': '#F5F5DC',
            'beige-200': '#F2E8C4',
            'beige-600': '#C3A773',
            'green-500': '#A8D5BA',
            'green-600': '#8DB79D',
            'green-700': '#228B22',
            'red-500': '#F28B82',
            'red-600': '#D9534F',
            'gray-100': '#F7F7F7',
        },
        fontFamily: {
            'sans': ['Nunito', 'sans-serif'],
        },
    },
  },
  plugins: [],
}

