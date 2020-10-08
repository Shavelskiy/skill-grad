import React, { useEffect, useState } from 'react'

import axios from 'axios'
import { USER_INFO_URL } from '@/utils/profile/endpoints'

import { validateUser, phoneFormat } from '../helpers'

import { Input, MaskInput } from '@/components/react-ui/input'
import { Button } from '@/components/react-ui/buttons'

import css from './scss/provider-settings-user.scss?module'


const ProviderSettingsUser = () => {
  const [error, setError] = useState('')
  const [showSuccess, setShowSuccess] = useState(false)
  const [disable, setDisable] = useState(false)

  const [fullName, setFullName] = useState('')
  const [email, setEmail] = useState('')
  const [phone, setPhone] = useState('')

  const [oldPassword, setOldPassword] = useState('')
  const [newPassword, setNewPassword] = useState('')
  const [confirmNewPassword, setConfirmNewPassword] = useState('')

  useEffect(() => {
    axios.get(USER_INFO_URL)
      .then(({data}) => {
        setFullName(data.full_name)
        setEmail(data.email)
        setPhone(data.phone)
      })
  }, [])

  const save = () => {
    setError('')
    setShowSuccess(false)

    const data = {
      fullName: fullName,
      email: email,
      phone: phoneFormat(phone),
      oldPassword: oldPassword,
      newPassword: newPassword,
      confirmNewPassword: confirmNewPassword,
    }

    if (!validateUser(data, setError)) {
      return
    }

    setDisable(true)
    axios.post(USER_INFO_URL, data)
      .then(() => setShowSuccess(true))
      .catch(({response}) => setError(response.data.error))
      .finally(() => setDisable(false))
  }

  return (
    <>
      <div className={css.alert}>
        <span className={css.error}>{error}</span>
        <span className={css.success}>{showSuccess ? 'Данные обновлены!' : ''}</span>
      </div>
      <div className={css.inputsContainer}>
        <Input
          type={'text'}
          placeholder={'ФИО *'}
          value={fullName}
          setValue={setFullName}
        />
        <Input
          type={'email'}
          placeholder={'E-mail *'}
          value={email}
          setValue={setEmail}
        />
        <MaskInput
          mask={'+7 (999)-999-99-99'}
          value={phone}
          setValue={setPhone}
        />
        <Input
          type={'password'}
          placeholder={'Старый пароль'}
          value={oldPassword}
          setValue={setOldPassword}
        />
        <Input
          type={'password'}
          placeholder={'Новый пароль'}
          value={newPassword}
          setValue={setNewPassword}
        />
        <Input
          type={'password'}
          placeholder={'Повторите новый пароль'}
          value={confirmNewPassword}
          setValue={setConfirmNewPassword}
        />
        <Button
          disabled={disable}
          click={save}
          blue={true}
          text={'Сохранить настройки'}
        />
      </div>
    </>
  )
}

export default ProviderSettingsUser
