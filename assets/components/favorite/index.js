import axios from 'axios'
import {updateFavoriteCount} from '../../components/header'
import {ADD_FAVORITE_PROVIDER, ADD_FAVORITE_PROGRAM} from '../../utils/api-routes'
import showAlert from '../../components/modal/alert'


let disableProviderFavoriteRequests = false
let disableProgramFavoriteRequests = false

export const addProviderToFavorite = (item) => {
  if (!disableProviderFavoriteRequests) {
    disableProviderFavoriteRequests = true
    axios.post(ADD_FAVORITE_PROVIDER, {id: item.dataset.id})
      .then(({data}) => {
        showAlert(data.message)
        updateFavoriteCount(data.isAdded ? 1 : -1)

        if (item.classList.contains('active')) {
          item.classList.remove('active')
        } else {
          item.classList.add('active')
        }
      })
      .catch((error) => showAlert(error.response.data.message))
      .finally(() => disableProviderFavoriteRequests = false)
  }
}

export const addProgramToFavorite = (item) => {
  if (!disableProgramFavoriteRequests) {
    disableProgramFavoriteRequests = true
    axios.post(ADD_FAVORITE_PROGRAM, {id: item.dataset.id})
      .then(({data}) => {
        showAlert(data.message)
        updateFavoriteCount(data.isAdded ? 1 : -1)

        if (item.classList.contains('icon-heart')) {
          item.classList.remove('icon-heart')
          item.classList.add('icon-love-red')
        } else {
          item.classList.remove('icon-love-red')
          item.classList.add('icon-heart')
        }
      })
      .catch((error) => showAlert(error.response.data.message))
      .finally(() => disableProgramFavoriteRequests = false)
  }
}
