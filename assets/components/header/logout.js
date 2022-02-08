import axios from 'axios'
import { LOGOUT_URL } from '@/utils/api-routes'

const logoutBtn = document.querySelector('.logout-link')

if (logoutBtn !== null) {
  logoutBtn.onclick = () => {
    axios.get(LOGOUT_URL).then(() => {
      document.location.reload()
    })
  }
}
