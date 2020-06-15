'use strict'

if (!('IntersectionObserver' in window)) {
  const script = document.createElement('script')
  script.src = 'https://cdn.jsdelivr.net/npm/intersection-observer/intersection-observer.min.js'
  script.onload = addScrollListener
  document.head.appendChild(script)
} else addScrollListener()

function addScrollListener() {
  let manualOverride, overrideTimeout

  const items = [].slice.call(document.querySelectorAll('.js-observed')).map(function (section) {
    return {
      section: section,
      anchor: document.querySelector('footer a[href="#' + section.id + '"]'),
      visible: false,
      fullyVisible: false,
    }
  })

  const observer = new IntersectionObserver(handleChanges, {
    rootMargin: '-10% 0px -10% 0px',
    threshold: [0, 1],
  })

  items.forEach(function (item) {
    observer.observe(item.section)
    item.anchor.addEventListener('click', handleOverride)
  })

  function handleChanges(entries) {
    entries.forEach(updateVisibility)

    let firstFullyVisibleEntry, lastVisibleEntry

    items.forEach(function (item) {
      if (item.visible) lastVisibleEntry = item
      if (!firstFullyVisibleEntry && item.fullyVisible) firstFullyVisibleEntry = item
    })

    if (manualOverride) return

    const highlightedEntry = firstFullyVisibleEntry || lastVisibleEntry || items[0]
    colorize(highlightedEntry.anchor)
  }

  function updateVisibility(entry) {
    let item

    for (let i = 0; i < items.length; i++) {
      if (items[i].section === entry.target) {
        item = items[i]
        break
      }
    }

    item.visible = entry.isIntersecting
    item.fullyVisible = entry.intersectionRatio === 1.0
  }

  function colorize(anchor) {
    items.forEach(function (item) {
      item.anchor.classList.add('text-lightgray')
    })
    anchor.classList.remove('text-lightgray')
  }

  function handleOverride(evt) {
    manualOverride = true
    clearTimeout(overrideTimeout)

    colorize(evt.currentTarget)

    overrideTimeout = setTimeout(function () {
      manualOverride = false
    }, 1000)
  }
}
