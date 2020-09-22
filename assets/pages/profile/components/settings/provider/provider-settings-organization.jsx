import React, {useState, useEffect, useRef} from 'react'

import {Input, Textarea} from '@/components/react-ui/input'
import {Button, SmallButton} from '@/components/react-ui/buttons'

import ProviderCategories from './provider-categories'
import ProviderRequisites from './provider-requisites'
import ProviderLocations from './provider-locations'

import css from './scss/provider-settings-organization.scss?module'

import noImage from '@/img/provider-no-photo.png'


const ProviderSettingsOrganization = () => {
  const ref = useRef()

  const [proAccount, setProAccount] = useState(false)

  const [name, setName] = useState('')
  const [description, setDescription] = useState('')
  const [image, setImage] = useState(null)
  const [oldImage, setOldImage] = useState(null)

  const [selectedCategories, setSelectedCategories] = useState([null, null, null])
  const [selectedSubcategories, setSelectedSubcategories] = useState([])
  const [selectedLocations, setSelectedLocations] = useState({
    country: null,
    region: null,
    city: null,
  })

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

  useEffect(() => {
    console.warn('todo Load data')
  }, [])

  const handleImageUpdate = (event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
      return
    }

    setOldImage(null)
    setImage(file)
  }

  const renderImage = () => {
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
        <span>Добавьте логотип организации</span>
      </label>
    )
  }

  const renderImageActions = () => {
    return (
      <div className={css.buttons}>
        <SmallButton
          text={(image === null && oldImage === null) ? 'Загрузить' : 'Изменить'}
          blue={true}
          click={() => ref.current.click()}
        />
        <SmallButton
          text={'Удалить'}
          red={(image !== null || oldImage !== null)}
          grey={(image === null && oldImage === null)}
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
      <div className={css.infoContainer}>
        <div className={css.logoOrganization}>
          <input
            ref={ref}
            id={'profile-image'}
            type={'file'}
            onChange={(event) => handleImageUpdate(event)}
          />
          {renderImage()}
          {renderImageActions()}
        </div>
        <Input
          type={'text'}
          placeholder={'Название организации *'}
          value={name}
          setValue={setName}
        />
        <Textarea
          placeholder={'Описание организации'}
          rows={8}
          value={description}
          setValue={setDescription}
        />
      </div>

      <strong>
        Выберите <span className={'blue-text'}>основные категории</span>&nbsp;
        программ обучения {!proAccount ? '(не более 3-х)' : ''} и подкатегории&nbsp;
        (без ограничений):
      </strong>
      <ProviderCategories
        selectedCategories={selectedCategories}
        setSelectedCategories={setSelectedCategories}
        selectedSubcategories={selectedSubcategories}
        setSelectedSubcategories={setSelectedSubcategories}
        proAccount={proAccount}
      />

      <strong>Выберите регион показа программ обучения:</strong>
      <ProviderLocations
        selectedLocations={selectedLocations}
        setSelectedLocations={setSelectedLocations}
      />

      <strong>Реквизиты организации:</strong>
      <ProviderRequisites
        requisites={requisites}
        setRequisites={setRequisites}
      />

      <div className={css.buttonBlock}>
        <Button
          text={'Сохранить настройки'}
          blue={true}
          click={() => console.log('save')}
        />
      </div>
    </>
  )
}

export default ProviderSettingsOrganization