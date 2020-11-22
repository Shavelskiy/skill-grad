import axios from 'axios'
import { LOCATION_SUGGEST_URL } from '@/utils/api-routes'

const cityList = document.querySelector('.change-city-modal .column')
const items = cityList.querySelectorAll('span')

let itemsHeight = 0

items.forEach(item => {
  itemsHeight += item.offsetHeight + 10
})

itemsHeight += 51

cityList.style.maxHeight = `${Math.ceil(itemsHeight / 28 / 4) * 28}px`

const suggestionsSelectorContainer = document.querySelector('.city-selector-suggestions')
const suggestionsContainer = suggestionsSelectorContainer.querySelector('.suggestions-content')

window.addEventListener('click', (event) => {
  if (event.target !== suggestionsSelectorContainer) {
    suggestionsSelectorContainer.classList.remove('active')
  }
})

document.querySelector('.city-modal-search').oninput = (event) => {
  if (event.target.value.length < 3) {
    suggestionsSelectorContainer.classList.remove('active')
    return
  }

  axios.get(LOCATION_SUGGEST_URL, {
    params: {
      query: event.target.value
    }
  })
    .then(({data}) => {
      if (data.suggestions.length < 1) {
        suggestionsSelectorContainer.classList.remove('active')
        return
      }

      suggestionsContainer.innerHTML = ''

      data.suggestions.forEach(suggestion => {
        suggestionsContainer.innerHTML += `<a href="/">${suggestion.name}</a>`
      })

      suggestionsSelectorContainer.classList.add('active')
    })
}
