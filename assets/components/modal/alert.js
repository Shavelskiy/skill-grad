const alertModal = document.getElementById('alert-modal')
const alertMessage = alertModal.querySelector('.message')

const closeAlert = () => {
  setTimeout(function () {
    alertModal.classList.remove('active')
  }, 1500)
}

closeAlert()

const showAlert = function (message) {
  alertMessage.textContent = message
  alertModal.classList.add('active')
  closeAlert()
}

export default showAlert
