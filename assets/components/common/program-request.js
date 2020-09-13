import axios from 'axios'

import {ADD_PROGRAM_REQUEST} from '../../utils/api-routes'
import showAlert from "../modal/alert";

const requestButtons = document.querySelectorAll('.add-program-request')

requestButtons.forEach((item) => {
  item.onclick = () => {
    item.disabled = true

    axios.post(ADD_PROGRAM_REQUEST, {id: item.dataset.id})
      .then((response) => showAlert(response.data.message))
      .catch((error) => showAlert(error.response.data.message))
  }
})
