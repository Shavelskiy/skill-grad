export const validate = (data, setError) => {
  if (data.phone.length > 0 && data.phone.length !== 10) {
    setError('Введите корректный телефон')
    return false
  }

  if (data.fullName.length < 1) {
    setError('Введите ФИО')
    return false
  }

  if (data.email.length < 1) {
    setError('Введите email')
    return false
  }

  if (data.confirmNewPassword.length > 0 || data.newPassword.length > 0) {
    if (data.oldPassword.length < 1) {
      setError('Введите старый пароль')
      return false
    }

    if (data.confirmNewPassword !== data.newPassword) {
      setError('Пароли должны совпадать')
      return false
    }
  }

  return true
}

export const phoneFormat = (phone) => {
  if (phone.substring(0, 1) !== '+') {
    return phone
  }

  return (
    phone.substring(4, 7) +
    phone.substring(9, 12) +
    phone.substring(13, 15) +
    phone.substring(16, 18)
  ).replace('_', '')
}
