import React  from 'react'

const Settings = () => {
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
            <input className="input" type="text" placeholder="ФИО *"/>
            <div className="form-inline">
              <input type="email" className="input" placeholder="E-mail *"/>
              <input type="tel" className="input" placeholder="+7 (_ _ _) - _ _ _ - _ _ - _ _"/>
              <div className="select custom-select-wrapper">
                <div className="custom-select">
                  <div className="custom-select__trigger"><span>Выбрать специализацию</span>
                    <div className="arrow"></div>
                  </div>
                  <div className="custom-options scrollbar">
                    <span className="custom-option category-option selected" data-value="tesla">Tesla</span>
                    <span className="custom-option category-option" data-value="volvo">Volvo</span>
                    <span className="custom-option category-option" data-value="mercedes">Mercedes</span>
                  </div>
                </div>
              </div>
            </div>
            <textarea className="textarea" cols="30" rows="10" placeholder="О себе"></textarea>
            <div className="form-inline">
              <input className="input" type="password" placeholder="Старый пароль"/>
              <input className="input" type="password" placeholder="Новый пароль"/>
              <input className="input" type="password" placeholder="Повторите новый пароль"/>
            </div>
            <div className="button">
              <button className="button-blue">Сохранить настройки</button>
            </div>
          </div>
        </div>
      </div>
    </>
  )
}

export default Settings
