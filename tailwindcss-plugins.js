const plugin = require('tailwindcss/plugin')
const excludeDefault = ([name]) => name !== 'default'

exports.container = plugin(function ({ addUtilities, theme }) {
  addUtilities({
    '.container': {
      width: '100%',
      marginLeft: 'auto',
      marginRight: 'auto',
      maxWidth: theme('maxWidth.5xl'),
    },
  })
})

exports.highlight = plugin(function ({ addUtilities, theme, variants }) {
  const sizes = Object.entries(theme('highlight.sizes') || {}).filter(excludeDefault)
  const colors = Object.entries(theme('highlight.colors') || theme('colors')).filter(excludeDefault)
  const defaultColor = theme('highlight.colors.default') || 'currentColor'

  const baseClass = {
    '.highlight': {
      display: 'inline',
      backgroundPosition: 'bottom',
      backgroundRepeat: 'repeat-x',
      boxDecorationBreak: 'clone',
      backgroundImage: `linear-gradient(${defaultColor} 100%, ${defaultColor} 100%)`,
      backgroundSize: `1px ${theme('highlight.sizes.default.height') || '17px'}`,
      padding: theme('highlight.sizes.default.padding') || '0 5px 2px',
    },
  }

  const colorClasses = Object.fromEntries(
    colors.map(([color, value]) => {
      const className = `.highlight-${color}`
      const styles = { backgroundImage: `linear-gradient(${value} 100%, ${value} 100%)` }
      return [className, styles]
    }),
  )
  const sizingClasses = Object.fromEntries(
    sizes.map(([name, { height, padding }]) => {
      const className = `.highlight-${name}`
      const styles = { padding, backgroundSize: `1px ${height}` }
      return [className, styles]
    }),
  )

  addUtilities({ ...baseClass, ...colorClasses, ...sizingClasses }, variants('highlight'))
})

exports.borderCircles = plugin(function ({ addUtilities, theme }) {
  addUtilities(
    Object.fromEntries(
      Object.entries(theme('colors')).map(([colorName, color]) => [
        `.border-circles-${colorName}`,
        {
          borderImageSlice: '33.333% 33.333%',
          borderImageRepeat: 'round',
          borderImageSource: `url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 25 25" version="1.1" fill="${color}"><circle cx="2.5" cy="2.5" r="2.5"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(0,20)"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(0,10)"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(10,0)"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(10,20)"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(20,0)"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(20,20)"/><circle cx="2.5" cy="2.5" r="2.5" transform="translate(20,10)"/></svg>')`.replace(
            /#/g,
            '%23',
          ),
        },
      ]),
    ),
  )
})
