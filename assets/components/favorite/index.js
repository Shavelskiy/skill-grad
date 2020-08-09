import axios from 'axios'
import { updateFavoriteCount } from '../../components/header'
import { ADD_FAVORITE_PROVIDER } from '../../utils/api-routes'
import showAlert from '../../components/modal/alert'


let disableProviderFavoriteRequests = false

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
