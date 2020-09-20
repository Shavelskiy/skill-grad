import React, {useState, useEffect} from 'react'
import axios from 'axios'
import {USER_INFO_URL} from '../../utils/api/endpoints'

import InputMask from 'react-input-mask'
import Select from '../../../components/react-ui/select';
import Input from '../ui/input'

import css from './user-settings.scss?module'


const UserSettings = () => {
  const [error, setError] = useState('')
  const [showSuccess, setShowSuccess] = useState(false)
  const [disable, setDisable] = useState(false)

  const [fullName, setFullName] = useState('')
  const [email, setEmail] = useState('')
  const [phone, setPhone] = useState('')
  const [description, setDescription] = useState('')

  const [oldPassword, setOldPassword] = useState('')
  const [newPassword, setNewPassword] = useState('')
  const [confirmNewPassword, setConfirmNewPassword] = useState('')

  const [category, setCategory] = useState(null)
  const [categories, setCategories] = useState([])

  const save = () => {
    setError('')
    setShowSuccess(false)

    let resultPhone = phone
    if (phone.substring(0, 1) === '+') {
      resultPhone =
        phone.substring(4, 7) +
        phone.substring(9, 12) +
        phone.substring(13, 15) +
        phone.substring(16, 18)
    }

    const data = {
      fullName: fullName,
      email: email,
      phone: resultPhone.replace('_', ''),
      description: description,
      oldPassword: oldPassword,
      newPassword: newPassword,
      confirmNewPassword: confirmNewPassword,
      category: category,
    }

    if (!validate(data)) {
      return
    }

    setDisable(true)
    axios.post(USER_INFO_URL, data)
      .then(() => setShowSuccess(true))
      .catch(({response}) => setError(response.data.error))
      .finally(() => setDisable(false))
  }

  const validate = (data) => {
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

  useEffect(() => {
    axios.get(USER_INFO_URL)
      .then(({data}) => {
        setFullName(data.full_name)
        setEmail(data.email)
        setPhone(data.phone)
        setDescription(data.description)
        setCategories(data.categories)
        setCategory(data.category)
      })
  }, [])

  return (
    <>
      <h5 className="result-title">Настройки пользователя</h5>
      <div className={css.userSettings}>
        <div className={css.settingsSidebar}>
          <img src="../../../img/photo-lk.jpg" alt=""/>
          <div className="button-group">
            <button className="button__edit">Изменить</button>
            <button className="button__delete">Удалить</button>
          </div>
        </div>
        <div className={css.settingsContent}>
          <Input
            type={'text'}
            placeholder={'ФИО *'}
            value={fullName}
            setValue={setFullName}
          />
          <div className="form-inline">
            <Input
              type={'email'}
              placeholder={'E-mail *'}
              value={email}
              setValue={setEmail}
            />
            <InputMask
              className="input"
              mask={'+7 (999)-999-99-99'}
              value={phone}
              onChange={({target}) => setPhone(target.value)}
              alwaysShowMask={true}
            />
            <div className="select custom-select-wrapper">
              <div className="custom-select">
                <Select
                  placeholder={'Выбрать специализацию'}
                  value={category}
                  setValue={setCategory}
                  options={categories}
                />
                <div className="custom-options scrollbar">
                  <span className="custom-option category-option selected" data-value="tesla">Tesla</span>
                  <span className="custom-option category-option" data-value="volvo">Volvo</span>
                  <span className="custom-option category-option" data-value="mercedes">Mercedes</span>
                </div>
              </div>
            </div>
          </div>
          <textarea
            className="textarea"
            cols="30"
            rows="10"
            placeholder="О себе"
            value={description}
            onChange={({target}) => setDescription(target.value)}
          ></textarea>
          <div className="form-inline">
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
          </div>
          <div className={css.button}>
            <span className={css.error}>{error}</span>
            <span className={css.success}>{showSuccess ? 'Данные обновлены!' : ''}</span>
            <button className="button-blue" disabled={disable} onClick={save}>Сохранить настройки</button>
          </div>
        </div>
      </div>
    </>
  )
}

export default UserSettings
