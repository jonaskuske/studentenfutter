if (!window.location.search.includes('q=')) {
  const input = document.querySelector('input[type="search"]')
  input && input.focus()
}
