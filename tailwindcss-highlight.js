const plugin = require('tailwindcss/plugin')
const excludeDefault = ([name]) => name !== 'default'

module.exports = plugin(function tailwindcssHighlight({ addUtilities, theme, variants }) {
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
    })
  )
  const sizingClasses = Object.fromEntries(
    sizes.map(([name, { height, padding }]) => {
      const className = `.highlight-${name}`
      const styles = { padding, backgroundSize: `1px ${height}` }
      return [className, styles]
    })
  )

  addUtilities({ ...baseClass, ...colorClasses, ...sizingClasses }, variants('highlight'))
})
