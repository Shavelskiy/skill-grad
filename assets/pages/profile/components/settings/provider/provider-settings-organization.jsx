import React, {useState, useEffect, useRef} from 'react'

import axios from 'axios'
import {PROVIDER_INFO_URL} from '@/utils/profile/endpoints'

import {Input, Textarea} from '@/components/react-ui/input'
import {Button, SmallButton} from '@/components/react-ui/buttons'

import ProviderCategories from './provider-categories'
import ProviderRequisites from './provider-requisites'
import ProviderLocations from './provider-locations'

import {validateProviderOrganization} from '../helpers'

import css from './scss/provider-settings-organization.scss?module'

import noImage from '@/img/provider-no-photo.png'


const ProviderSettingsOrganization = () => {
  const ref = useRef()

  const [error, setError] = useState('')
  const [showSuccess, setShowSuccess] = useState(false)
  const [disable, setDisable] = useState(false)

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
    axios.get(PROVIDER_INFO_URL)
      .then(({data}) => {
        setProAccount(data.pro_account)
        setName(data.name)
        setOldImage(data.image)
        setDescription(data.description)
        setSelectedCategories(data.categories)
        setSelectedSubcategories(data.sub_categories)
        setSelectedLocations(data.locations)
        setRequisites(data.requisites)
      })
  }, [])

  const save = () => {
    setError('')
    setShowSuccess(false)

    const data = {
      old_image: oldImage,
      name: name,
      description: description,
      categories: selectedCategories,
      sub_categories: selectedSubcategories,
      locations: selectedLocations,
      requisites: requisites,
    }

    if (!validateProviderOrganization(data, setError)) {
      return
    }

    let formData = new FormData()
    formData.append('image', image)
    formData.append('json_content', JSON.stringify(data))

    setDisable(true)
    axios.post(PROVIDER_INFO_URL, formData, {
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
        <div className={css.alert}>
          <span className={css.error}>{error}</span>
          <span className={css.success}>{showSuccess ? 'Данные обновлены!' : ''}</span>
        </div>

        <Button
          text={'Сохранить настройки'}
          disabled={disable}
          blue={true}
          click={save}
        />
      </div>
    </>
  )
}

export default ProviderSettingsOrganization