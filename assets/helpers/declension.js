export const declension = (number, variants) => {
  number %= 100
console.log(number)
  if (number >= 5 && number <= 20) {
    return variants[2]
  }

  number %= 10
  if (number === 1) {
    return variants[0]
  }

  if (number >= 2 && number <= 4) {
    return variants[1]
  }

  return variants[2]
}
