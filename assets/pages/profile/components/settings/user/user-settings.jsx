import React, {useState, useEffect, useRef} from 'react'

import axios from 'axios'
import {USER_INFO_URL} from '@/utils/profile/endpoints'

import {validateUser, phoneFormat} from '../helpers'

import Select from '@/components/react-ui/select'
import {Input, MaskInput, Textarea} from '@/components/react-ui/input'
import {Button, SmallButton} from '@/components/react-ui/buttons'
import {ResultTitle} from '@/components/react-ui/blocks';

import css from './user-settings.scss?module'

import noImage from '@/img/svg/user-no-photo.svg'


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

    if (!validateUser(data, setError)) {
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
      <div className={css.buttons}>
        <SmallButton
          text={'Изменить'}
          blue={true}
          click={() => ref.current.click()}
        />
        <SmallButton
          text={'Удалить'}
          red={true}
          click={() => {
            setImage(null)
            setOldImage(null)
          }}
        />
      </div>
    )
  }

  return (
    <>
      <ResultTitle title={'Настройки пользователя'}/>
      <div className={css.userSettings}>
        <div className={css.settingsSidebar}>
          <input
            ref={ref}
            id={'profile-image'}
            type={'file'}
            onChange={(event) => handleImageUpdate(event)}
          />
          {renderImage(image)}
          {renderImageActions()}
        </div>
        <div className={css.settingsContent}>
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
          <Select
            placeholder={'Выбрать специализацию'}
            value={category}
            setValue={setCategory}
            options={categories}
          />
          <Textarea
            placeholder={'О себе'}
            rows={10}
            value={description}
            setValue={setDescription}
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
          <div>
            <span className={css.error}>{error}</span>
            <span className={css.success}>{showSuccess ? 'Данные обновлены!' : ''}</span>
          </div>
          <Button
            text={'Сохранить настройки'}
            blue={true}
            click={save}
            disabled={disable}
          />
        </div>
      </div>
    </>
  )
}

export default UserSettings
