const alertModal = document.getElementById('alert-modal')
const alertMessage = alertModal.querySelector('.message')

const closeAlert = () => {
  setTimeout(function () {
    alertModal.classList.remove('is-visible')
  }, 1500)
}

closeAlert()

const showAlert = function (message) {
  alertMessage.textContent = message
  alertModal.classList.add('is-visible')
  closeAlert()
}

export default showAlert
