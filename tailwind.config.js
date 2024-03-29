const defaultTheme = require('tailwindcss/defaultTheme')
const tailwindPlugins = require('./tailwindcss-plugins')

/** @typedef { typeof import('tailwindcss/defaultConfig') } DefaultConfig */
/** @typedef { typeof import('tailwindcss/defaultTheme') } DefaultTheme */
/** @typedef { Partial<DefaultConfig & { theme: { extend: DefaultTheme } }> } TailwindConfig */

/** @type { TailwindConfig } */
module.exports = {
  purge: { mode: 'layers', content: ['**/*.html', '**/*.php', '**/*.svg'] },
  important: '#tw',
  theme: {
    extend: {
      borderWidth: { 3: '3px', 6: '6px' },
      boxShadow: {
        default: '0px 2px 10px rgba(117, 117, 117, 0.12)',
        sm: '0px 2px 10px rgba(117, 117, 117, 0.12);',
      },
      inset: { '1/2': '50%' },
      maxHeight: { 0: 0, 300: '300px' },
      maxWidth: { form: '271px' },
      minWidth: { 32: '8rem' },
      outline: { blue: ['#4F96D6 dashed 3px', '4px'] },
      scale: { 60: '0.6' },
      screens: {
        'can-hover': { raw: '(hover: hover)' },
      },
      spacing: { 1.5: '0.357rem' },
      transitionDelay: { 0: '0ms' },
      transitionDuration: { 0: '0ms' },
      zIndex: { '-1': '-1' },
    },
    aspectRatio: {
      none: 0,
      square: 1 / 1,
      card: 334 / 202,
      tall: 221 / 396,
      wide: 335 / 250,
    },
    borderRadius: {
      none: '0',
      default: '4px',
      lg: '15px',
      card: '20px',
      full: '9999px',
    },
    colors: {
      rose: '#F28B85',
      yellow: '#EBF47A',
      blue: '#4F96D6',
      white: '#FFFFFF',
      lightgray: '#E0E0E0',
      black: '#000000',
      transparent: 'transparent',
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
      loose: '1.8125rem', // 29px
      wide: '1.9375rem', // 31px
      none: 1,
      zero: 0,
    },
  },
  variants: {
    borderColor: ({ after }) => after(['focus-visible']),
    fontWeight: ({ after }) => after(['focus-visible']),
    highlight: ({ after }) => after(['active', 'hover']),
    margin: ({ after }) => after(['first']),
    opacity: ({ after }) =>
      after(['group-hover', 'no-hover', 'active'], 'hover', after(['group-focus-visible'])),
    outline: ({ after }) => after(['focus-visible', 'focus-visible-within', 'group-focus-visible']),
    scale: ({ after }) =>
      after(
        ['group-hover', 'no-hover', 'active'],
        'hover',
        after(['focus-visible-within', 'group-focus-visible'])
      ),
    textColor: ({ after }) => after(['focus-visible']),
    transitionDelay: ({ after }) => after(['group-hover', 'no-hover', 'group-focus-visible']),
  },
  corePlugins: {
    container: false,
  },
  plugins: [
    require('tailwindcss-aspect-ratio'),
    require('tailwindcss-interaction-variants'),
    tailwindPlugins.container,
    tailwindPlugins.highlight,
    tailwindPlugins.borderCircles,
    tailwindPlugins.focusVisibleWithin,
  ],
}
