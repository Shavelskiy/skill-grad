const translate = (str) => {
  const ru = {
    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
    'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i',
    'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
    'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
    'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh',
    'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya',
    ' ': '-', ',': '', '?': '', '/': '', ':': '',
    ';': '', '.': '', '<': '', '>': '', '[': '', ']': '',
  }

  let newStr = []

  str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i')

  for (var i = 0; i < str.length; ++i) {
    newStr.push(
      ru[str[i]]
      || ru[str[i].toLowerCase()] == undefined && str[i]
      || ru[str[i].toLowerCase()].replace(/^(.)/, (match) => match.toUpperCase()
      )
    )
  }

  return newStr.join('').toLowerCase()
}

export default translate
