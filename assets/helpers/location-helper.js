export const insertParam = (key, value) => {
  key = encodeURIComponent(key)
  value = encodeURIComponent(value)

  let kvp = document.location.search.substr(1).split('&')
  let i = 0

  for (; i < kvp.length; i++) {
    if (kvp[i].startsWith(key + '=')) {
      let pair = kvp[i].split('=')
      pair[1] = value
      kvp[i] = pair.join('=')
      break
    }
  }

  if (i >= kvp.length) {
    kvp[kvp.length] = [key, value].join('=')
  }

  window.history.replaceState('', document.title, document.location.pathname + '?' + kvp.join('&'))
}
