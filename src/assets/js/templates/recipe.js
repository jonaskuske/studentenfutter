'use strict'

if (!('IntersectionObserver' in window)) {
  const script = document.createElement('script')
  script.src = 'https://cdn.jsdelivr.net/npm/intersection-observer/intersection-observer.min.js'
  script.onload = addScrollListener
  document.head.appendChild(script)
} else addScrollListener()

function addScrollListener() {
  const items = [].slice.call(document.querySelectorAll('.js-observed')).map(function (section) {
    return {
      section: section,
      anchor: document.querySelector('footer a[href="#' + section.id + '"]'),
      visible: false,
    }
  })

  const observer = new IntersectionObserver(handleChanges, { rootMargin: '-33.333% 0px -10% 0px' })
  items.forEach(function (item) {
    observer.observe(item.section)
  })

  function updateVisibility(entry) {
    let item

    for (let i = 0; i < items.length; i++) {
      if (items[i].section === entry.target) {
        item = items[i]
        break
      }
    }

    item.visible = entry.isIntersecting
  }

  function handleChanges(entries) {
    entries.forEach(updateVisibility)

    let lastVisibleEntry = items[0]

    items.forEach(function (item) {
      item.anchor.classList.add('text-lightgray')
      if (item.visible) lastVisibleEntry = item
    })

    lastVisibleEntry.anchor.classList.remove('text-lightgray')
  }
}
