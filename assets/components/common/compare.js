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
    })
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
    .finally(() => disableCompareRequest = false)
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
    .finally(() => disableCompareRequest = false)
}

const addCompareButtons = document.querySelectorAll('.compare-program-add')

if (addCompareButtons.length > 0) {
  addCompareButtons.forEach((item) => {
    item.onclick = () => {
      compareAdd(item)
    }
  })
}