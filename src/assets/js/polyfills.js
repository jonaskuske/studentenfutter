'use strict'
;(function loadPolyfills(doc, base) {
  if (!('scrollBehavior' in doc.documentElement.style)) {
    insertScript(base + 'seamless-scroll-polyfill.min.js', function () {
      window.seamless.polyfill()
    })
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

;(function dispatchOfflineEvent(req, done, evt) {
  req.onreadystatechange = function () {
    if (req.readyState === done && (req.status >= 300 || !req.status)) window.dispatchEvent(evt)
  }
  req.open('HEAD', location)
  req.setRequestHeader('cache-control', 'no-store')
  req.send()
})(new XMLHttpRequest(), XMLHttpRequest.DONE, new CustomEvent('offline'))
