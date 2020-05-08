const plugin = require('tailwindcss/plugin')
const selectorParser = require('postcss-selector-parser')

module.exports = plugin(function ({ addVariant, config }) {
  const prefixClass = function (className) {
    const prefix = config('prefix')
    const getPrefix = typeof prefix === 'function' ? prefix : () => prefix
    return `${getPrefix(`.${className}`)}${className}`
  }

  const pseudoClassVariant = function (pseudoClass) {
    return ({ modifySelectors, separator }) => {
      return modifySelectors(({ selector }) => {
        return selectorParser((selectors) => {
          selectors.walkClasses((classNode) => {
            classNode.value = `${pseudoClass}${separator}${classNode.value}`
            classNode.parent.insertAfter(
              classNode,
              selectorParser.pseudo({ value: `:${pseudoClass}` })
            )
          })
        }).processSync(selector)
      })
    }
  }

  const groupPseudoClassVariant = function (pseudoClass) {
    return ({ modifySelectors, separator }) => {
      return modifySelectors(({ selector }) => {
        return selectorParser((selectors) => {
          selectors.walkClasses((classNode) => {
            classNode.value = `group-${pseudoClass}${separator}${classNode.value}`
            classNode.parent.insertBefore(
              classNode,
              selectorParser().astSync(`.${prefixClass('group')}:${pseudoClass} `)
            )
          })
        }).processSync(selector)
      })
    }
  }

  addVariant('valid', pseudoClassVariant('valid'))
  addVariant('group-valid', groupPseudoClassVariant('valid'))
})
