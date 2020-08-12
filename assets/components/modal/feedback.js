import { feedbackModal } from './index'
import showAlert from './alert'
import { load as recaptchaLoad } from 'recaptcha-v3/dist/ReCaptchaLoader'
import axios from 'axios'

const form = feedbackModal.querySelector('form')
const formButton = form.querySelector('button[type="submit"]')

form.onsubmit = function (e) {
  e.preventDefault()

  formButton.disabled = true

  const formData = new FormData(this)

  recaptchaLoad(process.env.RECAPTCHA_SITE_KEY).then((recaptcha) => {
    recaptcha.hideBadge()
    recaptcha.execute('feedback').then((token) => {
      formData.append('g_recaptcha_response', token)

      axios.post(form.action, formData)
        .then(response => {
          showAlert(response.data.message)
        })
        .catch(error => {
          showAlert(error.response.data.message)
        })
        .finally(() => {
          feedbackModal.classList.remove('active')
        })
    })
  }).catch((e) => {
    console.log('recapthca error')
  })
}
