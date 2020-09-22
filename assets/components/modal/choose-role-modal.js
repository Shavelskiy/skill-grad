import { registerModal, registerRoleModal } from '../modal'
import showAlert from './alert'
import {isAuth} from '@/helpers/auth'
import { ROLE_PROVIDER, ROLE_USER } from '@/utils/user-roles'

const showRegisterForm = (role) => {
  if (!isAuth()) {
    const registerFormRoleInput = registerModal.querySelector('input[name="role"]')
    registerFormRoleInput.value = role
    registerModal.classList.add('active')
  } else {
    showAlert('Вы уже зарегистрированы!')
  }
}

document.getElementById('register-user-button').onclick = () => {
  showRegisterForm(ROLE_USER)
  registerRoleModal.classList.remove('active')
}

document.getElementById('register-provider-button').onclick = () => {
  showRegisterForm(ROLE_PROVIDER)
  registerRoleModal.classList.remove('active')
}

export default showRegisterForm
