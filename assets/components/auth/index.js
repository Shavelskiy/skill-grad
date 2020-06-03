import initModalForm from './init-form'
import { loginModal, newPasswordModal, registerModal, resetPasswordModal } from '../modal'

import './index.scss'


initModalForm(loginModal, false, false, true, 'login')
initModalForm(resetPasswordModal, false, false, false, 'resetPassword')
initModalForm(newPasswordModal, true, true, false, 'newPassword')
initModalForm(registerModal, true, false, false, 'register')
