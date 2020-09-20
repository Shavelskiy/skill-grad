import React, {useState, useEffect, useRef} from 'react'

import axios from 'axios'
import {USER_INFO_URL} from '../../../utils/api/endpoints'

import {validate, phoneFormat} from '../helpers'

import InputMask from 'react-input-mask'
import Select from '../../../../components/react-ui/select'
import Input from '../../ui/input'

import css from './user-settings.scss?module'

import noImage from '../../../../img/svg/user-no-photo.svg'


const UserSettings = () => {
  const ref = useRef()

  const [error, setError] = useState('')
  const [showSuccess, setShowSuccess] = useState(false)
  const [disable, setDisable] = useState(false)

  const [fullName, setFullName] = useState('')
  const [email, setEmail] = useState('')
  const [phone, setPhone] = useState('')
  const [description, setDescription] = useState('')

  const [oldImage, setOldImage] = useState(null)
  const [image, setImage] = useState(null)

  const [oldPassword, setOldPassword] = useState('')
  const [newPassword, setNewPassword] = useState('')
  const [confirmNewPassword, setConfirmNewPassword] = useState('')

  const [category, setCategory] = useState(null)
  const [categories, setCategories] = useState([])

  useEffect(() => {
    axios.get(USER_INFO_URL)
      .then(({data}) => {
        setFullName(data.full_name)
        setEmail(data.email)
        setPhone(data.phone)
        setDescription(data.description)
        setCategories(data.categories)
        setCategory(data.category)
        setOldImage(data.image)
      })
  }, [])

  const save = () => {
    setError('')
    setShowSuccess(false)

    const data = {
      fullName: fullName,
      email: email,
      phone: phoneFormat(phone),
      description: description,
      oldPassword: oldPassword,
      newPassword: newPassword,
      confirmNewPassword: confirmNewPassword,
      category: category,
      oldImage: oldImage,
    }

    if (!validate(data, setError)) {
      return
    }

    let formData = new FormData()
    formData.append('image', image)
    formData.append('json_content', JSON.stringify(data))

    setDisable(true)
    axios.post(USER_INFO_URL, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then(() => setShowSuccess(true))
      .catch(({response}) => setError(response.data.error))
      .finally(() => setDisable(false))
  }

  const handleImageUpdate = (event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
      return
    }

    setOldImage(null)
    setImage(file)
  }

  const renderImage = (image) => {
    if (image !== null) {
      return (
        <img src={URL.createObjectURL(image)}/>
      )
    }

    if (oldImage !== null) {
      return (
        <img src={oldImage}/>
      )
    }

    return (
      <label htmlFor={'profile-image'}>
        <img src={noImage}/>
      </label>
    )
  }

  const renderImageActions = () => {
    if (image === null && oldImage === null) {
      return <></>
    }

    return (
      <div className="button-group">
        <button className="button__edit" onClick={() => ref.current.click()}>
          Изменить
        </button>
        <button className="button__delete" onClick={() => {
          setImage(null)
          setOldImage(null)
        }}>
          Удалить
        </button>
      </div>
    )
  }

  return (
    <>
      <h5 className="result-title">Настройки пользователя</h5>
      <div className={css.userSettings}>
        <div className={css.settingsSidebar}>
          {renderImage(image)}
          <input
            ref={ref}
            id={'profile-image'}
            type={'file'}
            onChange={(event) => handleImageUpdate(event)}
          />
          {renderImageActions()}
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
