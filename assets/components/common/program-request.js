import axios from 'axios'

import {load as recaptchaLoad} from 'recaptcha-v3/dist/ReCaptchaLoader'

import {loginModal, registerRoleModal, initModalFormCloseBtn} from '@/components/modal'
import {isAuth} from '@/helpers/auth';
import showAlert from '@/components/modal/alert';


const requestAuthModal = document.getElementById('program-request-auth-modal')
const requestModal = document.getElementById('program-request-modal')

const form = requestModal.querySelector('form')
const formIdInput = form.querySelector('input[name="id"]')
const formButton = form.querySelector('button[type="submit"]')

let currentRequestButton

window.addEventListener('click', (event) => {
  switch (event.target) {
    case requestAuthModal:
      requestAuthModal.classList.remove('active')
      break
    case requestModal:
      requestModal.classList.remove('active')
  }
})

const initModals = (modal, selector, openModal) => {
  modal.querySelector(selector).onclick = () => {
    modal.classList.remove('active')
    openModal.classList.add('active')
  }
}

initModals(requestAuthModal, '.login-btn', loginModal)
initModals(requestAuthModal, '.register-btn', registerRoleModal)

initModalFormCloseBtn(requestAuthModal)
initModalFormCloseBtn(requestModal)

document.querySelectorAll('.add-program-request').forEach((item) => {
  item.onclick = () => {
    if (!isAuth()) {
      requestAuthModal.classList.add('active')
    } else {
      formIdInput.value = item.dataset.id
      currentRequestButton = item
      requestModal.classList.add('active')
    }
  }
})

form.onsubmit = function (e) {
  e.preventDefault()

  const formData = new FormData(this)

  formButton.disabled = true

  recaptchaLoad(process.env.RECAPTCHA_SITE_KEY).then((recaptcha) => {
    recaptcha.hideBadge()
    recaptcha.execute('programRequest').then((token) => {
      formData.append('g_recaptcha_response', token)

      axios.post(form.action, formData)
        .then(response => {
          requestModal.classList.remove('active')
          showAlert(response.data.message)

          formButton.disabled = false
          currentRequestButton.disabled = true
          form.reset()

          const reviewButton = document.querySelector('.program-review-button')

          if (reviewButton) {
            reviewButton.dataset.hasRequest = '1'
          }
        })
        .catch((error) => showAlert(error.response.data.message))
    })
  })
}
