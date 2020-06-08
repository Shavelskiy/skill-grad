import './index.scss'
import { feedbackModal } from './../modal'

document.querySelector('.footer-feedback-form-modal-btn').onclick = () => {
  feedbackModal.classList.add('active')
}
