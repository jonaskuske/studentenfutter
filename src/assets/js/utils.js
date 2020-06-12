'use strict'

function isIOS() {
  return (
    (/iPad|iPhone|iPod/.test(navigator.platform) ||
      (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)) &&
    !window.MSStream
  )
}

function isIOSChrome() {
  return navigator.userAgent.match('CriOS')
}

function isStandalone() {
  return navigator.standalone || matchMedia('(display-mode: standalone)').matches
}
