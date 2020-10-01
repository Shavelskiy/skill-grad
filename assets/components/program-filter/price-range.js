const programFilter = document.querySelector('.program-filter')
const priceBlock = programFilter.querySelector('.price')

const inputs = priceBlock.querySelectorAll('.price-range-inputs input')
const minPriceInput = inputs[0]
const maxPriceInput = inputs[1]

const maxPrice = 200000
const minPrice = 0

const formatPrice = (value) => Math.round(value * maxPrice / maxValue)
const formatValue = (value) => Math.round(value * maxValue / maxPrice)

const maxValue = priceBlock.querySelector('.price-range').clientWidth - 12
const minValue = 0

const minThumb = priceBlock.querySelector('.min-price-thumb')
const maxThumb = priceBlock.querySelector('.max-price-thumb')
const progress = priceBlock.querySelector('.range-progress')

let minThumbClicked = false
let minThumbLeft = 0

let maxThumbClicked = false
let maxThumbLeft = 0

const moveMinThumb = (offset) => {
  minThumbLeft += offset

  if (minThumbLeft < minValue) {
    minThumbLeft = minValue
  }

  if (minThumbLeft > maxValue) {
    minThumbLeft = maxValue
  }

  if (minThumbLeft > maxThumbLeft) {
    minThumbLeft = maxThumbLeft
  }

  minPriceInput.value = formatPrice(minThumbLeft)
  moveThumb(minThumb, minThumbLeft)
}

const moveMaxThumb = (offset) => {
  maxThumbLeft += offset

  if (maxThumbLeft < maxThumbLeft) {
    maxThumbLeft = minValue
  }

  if (maxThumbLeft > maxValue) {
    maxThumbLeft = maxValue
  }

  if (maxThumbLeft < minThumbLeft) {
    maxThumbLeft = minThumbLeft
  }

  maxPriceInput.value = formatPrice(maxThumbLeft)
  moveThumb(maxThumb, maxThumbLeft)
}

const moveThumb = (thumb, value) => {
  thumb.style.left = `${value}px`
  updateProgress()
}

const updateProgress = () => {
  progress.style.marginLeft = `${minThumbLeft}px`
  progress.style.width = `${maxThumbLeft - minThumbLeft}px`
}

const getPriceFromEventValue = (event) => {
  const value = Number(event.target.value)

  if (value > maxPrice) {
    return maxPrice
  }

  if (value < minPrice) {
    return minPrice
  }

  return value
}

const initPriceRange = () => {
  minPriceInput.value = String(minPriceInput.value) !== '' ? Number(minPriceInput.value) : minPrice
  maxPriceInput.value = String(maxPriceInput.value) !== '' ? Number(maxPriceInput.value) : maxPrice

  minThumbLeft = formatValue(minPriceInput.value)
  moveThumb(minThumb, minThumbLeft)

  maxThumbLeft = formatValue(maxPriceInput.value)
  moveThumb(maxThumb, maxThumbLeft)

  document.addEventListener('mousedown', (event) => {
    if (event.target === minThumb) {
      minThumbClicked = true
    }

    if (event.target === maxThumb) {
      maxThumbClicked = true
    }
  })

  document.addEventListener('mouseup', () => {
    minThumbClicked = false
    maxThumbClicked = false
  })

  document.addEventListener('mousemove', (event) => {
    if (minThumbClicked) {
      moveMinThumb(event.movementX)
    }

    if (maxThumbClicked) {
      moveMaxThumb(event.movementX)
    }
  })

  minPriceInput.onchange = (event) => {
    let value = getPriceFromEventValue(event)

    if (value > maxPriceInput.value) {
      value = maxPriceInput.value
    }

    minPriceInput.value = value
    minThumbLeft = formatValue(value)
    moveThumb(minThumb, minThumbLeft)
    updateProgress()
  }

  maxPriceInput.onchange = (event) => {
    let value = getPriceFromEventValue(event)

    if (value < minPriceInput.value) {
      value = minPriceInput.value
    }

    maxPriceInput.value = value
    maxThumbLeft = formatValue(value)
    moveThumb(maxThumb, maxThumbLeft)
    updateProgress()
  }
}

initPriceRange()
