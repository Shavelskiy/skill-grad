import React, {useEffect, useState} from 'react'

import axios from 'axios'
import {USER_INFO_URL} from '../../../utils/api/endpoints'

import {validate, phoneFormat} from '../helpers'

import InputMask from 'react-input-mask'
import Input from '../../ui/input'

import css from './provider-settings-user.scss?module'
import cn from 'classnames'


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

    if (!validate(data, setError)) {
      return
    }

    setDisable(true)
    axios.post(USER_INFO_URL, data)
      .then(() => setShowSuccess(true))
      .catch(({response}) => setError(response.data.error))
      .finally(() => setDisable(false))
  }

  return (
    <div className={css.general}>
      <div className={cn('container-0', css.container0)}>
        <span className={css.error}>{error}</span>
        <span className={css.success}>{showSuccess ? 'Данные обновлены!' : ''}</span>
      </div>
      <div className={cn('container-0', css.container0)}>
        <div className="col-lg-6 col-md-12 col-sm-4">
          <Input
            type={'text'}
            placeholder={'ФИО *'}
            value={fullName}
            setValue={setFullName}
          />
        </div>
        <div className="col-lg-3 col-md-12 col-sm-4">
          <Input
            type={'email'}
            placeholder={'E-mail *'}
            value={email}
            setValue={setEmail}
          />
        </div>
        <div className="col-lg-3 col-md-12 col-sm-4">
          <InputMask
            className="input"
            mask={'+7 (999)-999-99-99'}
            value={phone}
            onChange={({target}) => setPhone(target.value)}
            alwaysShowMask={true}
          />
        </div>
      </div>
      <div className={cn('container-0', css.container0)}>
        <div className="col-lg-3 col-md-12 col-sm-4">
          <Input
            type={'password'}
            placeholder={'Старый пароль'}
            value={oldPassword}
            setValue={setOldPassword}
          />
        </div>
        <div className="col-lg-3 col-md-12 col-sm-4">
          <Input
            type={'password'}
            placeholder={'Новый пароль'}
            value={newPassword}
            setValue={setNewPassword}
          />
        </div>
        <div className="col-lg-3 col-md-12 col-sm-4">
          <Input
            type={'password'}
            placeholder={'Повторите новый пароль'}
            value={confirmNewPassword}
            setValue={setConfirmNewPassword}
          />
        </div>
        <div className="col-lg-3 col-md-12 col-sm-4">
          <button className="button-blue" disabled={disable} onClick={save}>Сохранить настройки</button>
        </div>
      </div>
    </div>
  )
}

export default ProviderSettingsUser
