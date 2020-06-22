import React, { useState, useEffect } from 'react'
import { PROVIDER_INDEX } from '../../utils/routes'

import { FETCH_PROVIDER_URL, UPDATE_PROVIDER_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import ProviderForm from './form'
import Portlet from '../../components/portlet/portlet'
import ProviderRequisitesForm from './requisites-form'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const ProviderUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    description: '',
    mainCategories: [],
    categories: [],
    locations: [],
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
    dispatch(setBreacrumbs([
      {
        title: 'Список провайдеров',
        link: PROVIDER_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование провайдера обучения "${item.name}"`))
  }, [item])

  const setItemFromResponse = (data) => {
    let mainCategories = []
    data.mainCategories.forEach(item => {
      mainCategories.push(item.id)
    })

    let categories = []
    data.categories.forEach(item => {
      categories.push(item.id)
    })

    let locations = []
    data.locations.forEach(item => {
      locations.push(item.id)
    })

    setItem({
      id: data.id,
      name: data.name,
      description: data.description,
      image: data.image,
      mainCategories: mainCategories,
      categories: categories,
      locations: locations,
      organizationName: data.organizationName,
      legalAddress: data.legalAddress,
      mailingAddress: data.mailingAddress,
      ITN: data.ITN,
      IEC: data.IEC,
      PSRN: data.PSRN,
      OKPO: data.PSRN,
      checkingAccount: data.checkingAccount,
      correspondentAccount: data.correspondentAccount,
      BIC: data.BIC,
      bank: data.bank,
    })
  }

  return (
    <UpdatePageTemplate
      indexPageUrl={PROVIDER_INDEX}
      fetchUrl={FETCH_PROVIDER_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_PROVIDER_URL}
      item={item}
      setItem={setItemFromResponse}
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
    </UpdatePageTemplate>
  )
}

export default ProviderUpdate
