const cityList = document.querySelector('.change-city-modal .column')
const items = cityList.querySelectorAll('span')

let itemsHeight = 0

items.forEach(item => {
  itemsHeight += item.offsetHeight + 10
})

itemsHeight += 51

console.log(itemsHeight)

cityList.style.maxHeight = `${Math.ceil(itemsHeight / 28 /4) * 28}px`
