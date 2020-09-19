import React, {useState, useEffect} from 'react'
import axios from 'axios'
import {USER_INFO_URL} from '../../utils/api/endpoints'

import InputMask from 'react-input-mask'
import Select from '../../../components/react-ui/select';


const Settings = () => {
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
    const resultPhone =
      phone.substring(4, 7) +
      phone.substring(9, 12) +
      phone.substring(13, 15) +
      phone.substring(16, 18)

    const data = {
      fullName: fullName,
      email: email,
      phone: resultPhone,
      description: description,
      oldPassword: oldPassword,
      newPassword: newPassword,
    }

    console.log(data)
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
      <div className="user-settings">
        <div className="settings-sidebar">
          <img src="../../../img/photo-lk.jpg" alt=""/>
          <div className="button-group">
            <button className="button__edit">Изменить</button>
            <button className="button__delete">Удалить</button>
          </div>
        </div>
        <div className="settings-content">
          <div className="form-group">
            <input
              className="input"
              type="text"
              placeholder="ФИО *"
              value={fullName}
              onChange={({target}) => setFullName(target.value)}
            />
            <div className="form-inline">
              <input
                type="email"
                className="input"
                placeholder="E-mail *"
                value={email}
                onChange={({target}) => setEmail(target.value)}
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
              <input
                className="input"
                type="password"
                placeholder="Старый пароль"
                value={oldPassword}
                onChange={({target}) => setOldPassword(target.value)}
              />
              <input
                className="input"
                type="password"
                placeholder="Новый пароль"
                value={newPassword}
                onChange={({target}) => setNewPassword(target.value)}
              />
              <input
                className="input"
                type="password"
                placeholder="Повторите новый пароль"
                value={confirmNewPassword}
                onChange={({target}) => setConfirmNewPassword(target.value)}
              />
            </div>
            <div className="button">
              <button className="button-blue" onClick={save}>Сохранить настройки</button>
            </div>
          </div>
        </div>
      </div>
    </>
  )
}

export default Settings
