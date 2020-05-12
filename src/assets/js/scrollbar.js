'use strict'
;(function detectScrollbar(doc) {
  var body = document.body
  var el = body.appendChild(doc.createElement('div'))

  el.style.cssText = `
  width:100px;height:100px;overflow:scroll !important;position:absolute;top:-100vh`

  var hasScrollbar = el.offsetWidth - el.clientWidth > 0
  if (hasScrollbar) document.documentElement.classList.add('has-scrollbar')

  body.removeChild(el)
})(document)
