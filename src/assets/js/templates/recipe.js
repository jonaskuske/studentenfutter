'use strict'

function favorite(initial) {
  return {
    isFavorite: initial,
    online: typeof navigator.onLine === 'boolean' ? navigator.onLine : true,
    submit: function (evt) {
      if (!window.fetch) return

      var _this = this
      evt.preventDefault()

      fetch(location.href, {
        method: 'POST',
        body: 'favorite=' + (this.isFavorite ? 'false' : 'true'),
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      }).then(function (r) {
        if (!r.ok) return

        _this.isFavorite = !_this.isFavorite
        window.REFRESH_ON_NAV = true
        if ('serviceWorker' in navigator) {
          navigator.serviceWorker.ready.then(function (reg) {
            reg.active.postMessage({ type: 'UPDATE_CACHE' })
          })
        }
      })
    },
  }
}

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

  let lastChangedToFullyVisible

  function handleChanges(changedEntries) {
    let firstFullyVisibleInChangedEntries, lastVisible, lastFullyVisible

    changedEntries.forEach(function (entry) {
      let item = getItemFromSection(entry.target)

      item.visible = entry.isIntersecting
      item.fullyVisible = entry.intersectionRatio === 1.0

      if (item.fullyVisible) {
        if (!firstFullyVisibleInChangedEntries) firstFullyVisibleInChangedEntries = item
      } else {
        if (lastChangedToFullyVisible === item) lastChangedToFullyVisible = null
      }
    })

    if (firstFullyVisibleInChangedEntries) {
      lastChangedToFullyVisible = firstFullyVisibleInChangedEntries
    }

    items.forEach(function (item) {
      if (item.visible) lastVisible = item
      if (item.fullyVisible) lastFullyVisible = item
    })

    if (manualOverride) return

    const highlighted = lastChangedToFullyVisible || lastFullyVisible || lastVisible || items[0]
    colorize(highlighted.anchor)
  }

  function getItemFromSection(section) {
    for (let i = 0; i < items.length; i++) {
      if (items[i].section === section) return items[i]
    }
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
