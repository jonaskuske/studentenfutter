const defaultTheme = require('tailwindcss/defaultTheme')

/** @typedef { import('tailwindcss/defaultConfig') } TailwindConfig */
/** @type { TailwindConfig & { theme: { extend: TailwindConfig['theme'] } } } */
module.exports = {
  purge: ['**/*.html', '**/*.php'],
  theme: {
    extend: {
      boxShadow: { default: '0px 2px 10px rgba(117, 117, 117, 0.12)' },
      maxHeight: { '0': 0, '300': '300px' },
      zIndex: { '-1': '-1' },
    },
    borderRadius: {
      none: '0',
      default: '4px',
      large: '20px',
    },
    colors: {
      rose: '#F28B85',
      yellow: '#EBF47A',
      blue: '#4F96D6',
      black: '#000000',
      white: '#FFFFFF',
    },
    fontFamily: {
      sans: ['Chivo', ...defaultTheme.fontFamily.sans],
    },
    fontSize: {
      xs: '0.75rem', // '12px'
      sm: '0.875rem', // '14px'
      base: '1rem', // '16px'
      md: '1.125rem', // '18px'
      lg: '1.5rem', // '24px'
      xl: '1.625rem', // '26px'
    },
    highlight: {
      sizes: {
        sm: { height: '10px', padding: '0 2px 0' },
        default: { height: '14px', padding: '0 3px' },
        lg: { height: '17px', padding: '0 5px 3px ' },
      },
    },
    lineHeight: {
      tight: '0.875rem', // 14px
      snug: '1.0625rem', // 17px
      normal: '1.1875rem', // 19px
      relaxed: '1.3125rem', // 21px
      loose: '1.9375rem', // 31px
      none: 1,
      zero: 0,
    },
  },
  variants: {
    backgroundColor: ['before'],
  },
  plugins: [require('tailwindcss-pseudo-elements'), require('./tailwindcss-highlight')],
}
