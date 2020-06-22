'use strict'
;(function loadPolyfills(doc, base) {
  // until https://github.com/alpinejs/alpine/pull/469 is merged
  SVGElement.prototype.contains = SVGElement.prototype.contains || HTMLElement.prototype.contains

  if (!('scrollBehavior' in doc.documentElement.style)) {
    insertScript(base + 'smoothscroll-polyfill.min.js')
    insertScript(base + 'smoothscroll-anchor-polyfill.min.js')
  }

  if (!('objectFit' in new Image().style)) {
    insertScript(base + 'object-fit-images.min.js', function () {
      window.objectFitImages()
    })
  }

  try {
    document.querySelector(':focus-visible')
  } catch (err) {
    insertScript(base + 'focus-visible.min.js')
  }

  function insertScript(src, onload) {
    var script = doc.createElement('script')
    script.src = src
    script.onload = onload
    return doc.head.appendChild(script)
  }
})(document, '/assets/js/vendor/')
