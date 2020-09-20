import React, {useState} from 'react'

import Input from '../../ui/input'
import ProviderCategories from './provider-categories'
import ProviderRequisites from './provider-requisites'

import css from './provider-settings-organization.scss'


const ProviderSettingsOrganization = () => {
  const [name, setName] = useState('')
  const [description, setDescription] = useState('')
  const [selectedCategories, setSelectedCategories] = useState([null, null, null])
  const [selectedSubcategories, setSelectedSubcategories] = useState([])

  const [requisites, setRequisites] = useState({
    organizationName: '',
    legalAddress: '',
    mailingAddress: '',
    ITN: '',
    IEC: '',
    PSRN: '',
    OKPO: '',
    checkingAccount: '',
    correspondentAccount: '',
    BIC: '',
    bank: '',
  })

  return (
    <div className="organ">
      <h3 className="result-title w-100">Настройки организации</h3>
      <div className="container-0">
        <div className="col-lg-12 col-md-12 col-sm-4">
          <div className="container-0">
            <div className="col-lg-2 col-md-12 col-sm-4">
              <div className="logo-organization">
                <img src="../../../../img/orig_(1).jpg" alt=""/>
                <div className="buttons">
                  <button className="button-b">Изменить</button>
                  <button className="button-r">Удалить</button>
                </div>
              </div>
            </div>
            <div className="col-lg-7 col-md-12 col-sm-4">
              <Input
                type={'text'}
                placeholder={'Название организации *'}
                value={name}
                setValue={setName}
              />
              <textarea
                className="textarea"
                placeholder="Описание организации"
                value={description}
                onChange={({target}) => setDescription(target.value)}
                rows="8"
              ></textarea>
            </div>
          </div>
          <ProviderCategories
            selectedCategories={selectedCategories}
            setSelectedCategories={setSelectedCategories}
            selectedSubcategories={selectedSubcategories}
            setSelectedSubcategories={setSelectedSubcategories}
          />
          <div className="container-0">
            <div className="col-lg-12 col-md-12 col-sm-4">
              <strong>Выберите регион показа программ обучения:</strong>
            </div>
            <div className="container-0 mt-20">
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Страна</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                                  <span className="custom-option category-option selected"
                                        data-value="tesla">Россия</span>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Регион</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                                  <span className="custom-option category-option selected"
                                        data-value="tesla">Алтай</span>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Город</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                                  <span className="custom-option category-option selected"
                                        data-value="tesla">Москва</span>
                      <span className="custom-option category-option"
                            data-value="volvo">Санкт-Петербург</span>
                      <span className="custom-option category-option"
                            data-value="mercedes">Нижний Новгород</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="container-0">
            <div className="col-lg-12 col-md-12 col-sm-4">
              <strong>Реквизиты организации:</strong>
            </div>
            <ProviderRequisites requisites={requisites} setRequisites={setRequisites}/>
            <div className="container-0 button-block">
              <div className="col-lg-3 col-md-12 col-sm-4">
                <button className="button-blue">
                  Сохранить настройки
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default ProviderSettingsOrganization