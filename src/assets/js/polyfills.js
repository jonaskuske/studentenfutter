'use strict'
;(function loadPolyfills(doc, cdn, smoothscroll) {
  if (!('scrollBehavior' in doc.documentElement.style)) {
    insertScript(cdn + smoothscroll + '-polyfill/dist/' + smoothscroll + '.min.js')
    insertScript(cdn + smoothscroll + '-anchor-polyfill')
  }

  if (!('objectFit' in new Image().style)) {
    insertScript(cdn + 'object-fit-images@3.2.4/dist/ofi.min.js', function () {
      window.objectFitImages()
    })
  }

  // until https://github.com/alpinejs/alpine/issues/468 is fixed
  if (/Trident\//.test(navigator.userAgent)) {
    delete HTMLElement.prototype.contains

    Node.prototype.contains = function contains(node) {
      if (!(0 in arguments)) throw new TypeError('1 argument is required')

      do {
        if (this === node) return true
      } while ((node = node && node.parentNode))

      return false
    }
  }

  function insertScript(src, onload) {
    var script = doc.createElement('script')
    script.src = src
    script.onload = onload
    return doc.head.appendChild(script)
  }
})(document, '//unpkg.com/', 'smoothscroll')
