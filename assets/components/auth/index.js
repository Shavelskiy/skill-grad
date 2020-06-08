import initModalForm from './init-form'
import { loginModal, newPasswordModal, registerModal, resetPasswordModal } from '../modal'

initModalForm(loginModal, false, false, true, 'login')
initModalForm(resetPasswordModal, false, false, false, 'resetPassword')
initModalForm(newPasswordModal, true, true, true, 'newPassword')
initModalForm(registerModal, true, false, false, 'register')
