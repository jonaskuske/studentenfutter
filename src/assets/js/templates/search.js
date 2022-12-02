if (!/q=/.test(window.location.search)) {
  const input = document.querySelector('input[type="search"]')
  input && input.focus()
  if (navigator.virtualKeyboard) navigator.virtualKeyboard.show()
}
