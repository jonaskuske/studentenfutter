'use strict'
;(function detectScrollbar(doc) {
  var el = doc.body.appendChild(doc.createElement('div'))

  el.style.cssText =
    'width:100px;height:100px;overflow:scroll !important;position:absolute;top:-100vh'

  var hasScrollbar = el.offsetWidth - el.clientWidth > 0
  if (hasScrollbar) doc.documentElement.classList.add('has-scrollbar')

  doc.body.removeChild(el)
})(document)
