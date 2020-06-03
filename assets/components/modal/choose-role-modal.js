import { registerModal, registerRoleModal } from '../modal'
import { ROLE_PROVIDER, ROLE_USER } from '../../utils/user-roles'

const showRegisterForm = (role) => {
  const registerFormRoleInput = registerModal.querySelector('input[name="role"]')
  registerFormRoleInput.value = role
  registerModal.classList.add('is-visible')
}

document.getElementById('register-user-button').onclick = () => {
  showRegisterForm(ROLE_USER)
  registerRoleModal.classList.remove('is-visible')
}
document.getElementById('register-provider-button').onclick = () => {
  showRegisterForm(ROLE_PROVIDER)
  registerRoleModal.classList.remove('is-visible')
}

export default showRegisterForm
