import React, { useState, useEffect } from 'react'
import { PROVIDER_INDEX } from '../../utils/routes'

import { CREATE_PROVIDER_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import ProviderForm from './form'
import Portlet from '../../components/portlet/portlet'
import ProviderRequisitesForm from './requisites-form'
import CreatePageTemplate from '../../components/page-templates/create'


const ProviderCreate = () => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    description: '',
    categories: [],
    location: null,
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

  const [uploadImage, setUploadImage] = useState(null)

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Добавление провайдера обучения'))
    dispatch(setBreacrumbs([
      {
        title: 'Список провайдеров',
        link: PROVIDER_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={PROVIDER_INDEX}
      createUrl={CREATE_PROVIDER_URL}
      item={item}
      setDisableButton={setDisableButton}
      needSave={needSave}
      setNeedSave={setNeedSave}
      multipart={true}
      appendExternalData={(formData) => formData.append('uploadImage', uploadImage)}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'info'}
      >
        <ProviderForm
          item={item}
          setItem={setItem}
          uploadImage={uploadImage}
          setUploadImage={setUploadImage}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
      <Portlet
        width={50}
        title="Реквизиты организации"
        titleIcon={'info'}
      >
        <ProviderRequisitesForm
          item={item}
          setItem={setItem}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default ProviderCreate
