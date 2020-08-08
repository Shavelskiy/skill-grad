import initModalForm from './init-form'
import { loginModal, newPasswordModal, registerModal, resetPasswordModal } from '../modal'
import showRegisterForm from '../modal/choose-role-modal'
import { ROLE_PROVIDER, ROLE_USER } from '../../utils/user-roles'

initModalForm(loginModal, false, false, true, 'login')
initModalForm(resetPasswordModal, false, false, false, 'resetPassword')
initModalForm(newPasswordModal, true, true, true, 'newPassword')
initModalForm(registerModal, true, false, false, 'register')

document.querySelectorAll('.register-user-btn').forEach(item => item.onclick = () => showRegisterForm(ROLE_USER))
document.querySelectorAll('.register-provider-btn').forEach(item => item.onclick = () => showRegisterForm(ROLE_PROVIDER))
