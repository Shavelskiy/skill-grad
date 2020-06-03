import { LOGOUT_URL } from '../../utils/api-routes'
import axios from 'axios'

const logoutBtn = document.querySelector('.logout-link')

if (logoutBtn !== null) {
  logoutBtn.onclick = () => {
    axios.get(LOGOUT_URL).then(() => {
      document.location.reload()
    })
  }
}
