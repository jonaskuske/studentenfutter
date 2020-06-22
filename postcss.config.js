module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
    'postcss-smoothscroll-anchor-polyfill': {},
    'postcss-focus-visible': {},
    'postcss-object-fit-images': {},
    ...(process.env.NODE_ENV === 'production' && {
      cssnano: { preset: ['default', { mergeRules: false }] },
    }),
  },
}
