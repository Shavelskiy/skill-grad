import { load as recaptchaLoad } from 'recaptcha-v3/dist/ReCaptchaLoader'
import showAlert from './../modal/alert'
import axios from 'axios'


const initModalForm = (modal, checkPasswords, closeFormIfError, reloadPageIfSuccess, recaptchaAction) => {
  const form = modal.querySelector('form')
  const formButton = form.querySelector('button[type="submit"]')

  form.onsubmit = function (e) {
    e.preventDefault()

    if (checkPasswords) {
      const passwordInput = form.querySelector('input[name="password"]')
      const confirmPasswordInput = form.querySelector('input[name="confirm-password"]')

      if (passwordInput.value !== confirmPasswordInput.value) {
        showModalFormError(form, 'Пароли должны совпадать')
        return
      }
    }

    formButton.disabled = true
    hideModalFormError(form)

    const formData = new FormData(this)

    recaptchaLoad(process.env.RECAPTCHA_SITE_KEY).then((recaptcha) => {
      recaptcha.hideBadge()
      recaptcha.execute(recaptchaAction).then((token) => {
        formData.append('g_recaptcha_response', token)

        axios.post(form.action, formData)
          .then(response => {
            modal.classList.remove('active')
            showAlert(response.data.message)

            if (reloadPageIfSuccess) {
              document.location.reload()
            }
          })
          .catch(error => {
            if (closeFormIfError) {
              showAlert(error.response.data.message)
              modal.classList.remove('active')
            } else {
              formButton.disabled = false
              showModalFormError(form, error.response.data.message)
            }
          })
      })
    })
  }
}

const showModalFormError = function (form, error) {
  const modalError = form.querySelector('.modal-error')

  if (!modalError) {
    return
  }

  modalError.classList.add('active')
  modalError.textContent = error
}

const hideModalFormError = function (form) {
  const modalError = form.querySelector('.modal-error')

  if (!modalError) {
    return
  }

  modalError.classList.remove('active')
  modalError.textContent = ''
}

export default initModalForm
