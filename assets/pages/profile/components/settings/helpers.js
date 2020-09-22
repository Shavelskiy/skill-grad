export const validateUser = (data, setError) => {
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

export const validateProviderOrganization = (data, setError) => {
  if (data.name < 1) {
    setError('Введите название организации')
    return false
  }

  if (data.categories.filter(category => category !== null).length < 1) {
    setError('Выберите хотя бы одну категорию')
    return false
  }

  if (data.sub_categories.length < 1) {
    setError('Выберите хотя бы одну подкатегорию')
    return false
  }

  if (data.locations.country === null && data.locations.region === null && data.locations.city === null) {
    setError('Выберите регион')
    return false
  }

  if (data.requisites.organizationName < 1) {
    setError('Введите наименование организации')
    return false
  }

  if (data.requisites.legalAddress < 1) {
    setError('Введите юридический адрес')
    return false
  }

  if (data.requisites.ITN < 1) {
    setError('Введите ИНН')
    return false
  }

  if (data.requisites.PSRN < 1) {
    setError('Введите ОГРН')
    return false
  }

  if (data.requisites.checkingAccount < 1) {
    setError('Введите расчетный счет')
    return false
  }

  if (data.requisites.correspondentAccount < 1) {
    setError('Введите корреспондентский счет')
    return false
  }

  if (data.requisites.BIC < 1) {
    setError('Введите БИК')
    return false
  }

  if (data.requisites.bank < 1) {
    setError('Введите банк')
    return false
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
