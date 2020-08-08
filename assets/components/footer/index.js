import { feedbackModal } from './../modal'

document.querySelectorAll('.feedback-form-modal-btn').forEach(item => item.onclick = () => {
  feedbackModal.classList.add('active')
})
