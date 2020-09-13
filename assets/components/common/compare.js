import axios from 'axios'
import {COMPARE_ADD, COMPARE_REMOVE, COMPARE_CLEAR} from '../../utils/api-routes'
import showAlert from '../modal/alert'
import {updateCompareCount} from '../header'

let disableCompareRequest = false

const compareAdd = (item) => {
  if (disableCompareRequest) {
    return
  }

  disableCompareRequest = true
  axios.post(COMPARE_ADD, {id: item.dataset.id})
    .then(({data}) => {
      showAlert(data.message)
      updateCompareCount(data.count)
      toggleCompareButton(item)
    })
    .catch((error) => showAlert(error.response.data.message))
    .finally(() => disableCompareRequest = false)
}

const compareRemove = (item) => {
  if (disableCompareRequest) {
    return
  }

  disableCompareRequest = true
  axios.post(COMPARE_REMOVE, {id: item.dataset.id})
    .then(({data}) => {
      showAlert(data.message)
      updateCompareCount(data.count)
    })
    .catch((error) => showAlert(error.response.data.message))
    .finally(() => window.location.reload())
}

const compareClear = () => {
  if (disableCompareRequest) {
    return
  }

  disableCompareRequest = true
  axios.post(COMPARE_CLEAR)
    .then(() => {
      updateCompareCount(0)
    })
    .finally(() => window.location.href = '/')
}

const addCompareButtons = document.querySelectorAll('.compare-program-add')
const removeCompareButtons = document.querySelectorAll('.compare-program-remove')
const clearCompareButton = document.querySelector('.clear-compare-button')

const toggleCompareButton = (button) => {
  const icon = button.querySelector('i')

  if (icon) {
    const tooltip = button.querySelector('.tooltip')

    if (icon.classList.contains('icon-add-file')) {
      icon.classList.remove('icon-add-file')
      icon.classList.add('icon-insurance')
      tooltip.innerHTML = 'Находится в сравнении'
    } else {
      icon.classList.remove('icon-insurance')
      icon.classList.add('icon-add-file')
      tooltip.innerHTML = 'Добавить в сравнение'
    }
  } else {
    if (button.classList.contains('icon-add-file')) {
      button.classList.remove('icon-add-file')
      button.classList.add('icon-insurance')
    } else {
      button.classList.remove('icon-insurance')
      button.classList.add('icon-add-file')
    }
  }
}

if (addCompareButtons.length > 0) {
  addCompareButtons.forEach((item) => {
    item.onclick = () => {
      compareAdd(item)
    }
  })
}

if (removeCompareButtons.length > 0) {
  removeCompareButtons.forEach((item) => {
    item.onclick = () => {
      compareRemove(item)
    }
  })
}

if (clearCompareButton) {
  clearCompareButton.onclick = () => {
    compareClear()
  }
}
