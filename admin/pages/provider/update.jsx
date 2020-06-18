import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { PROVIDER_INDEX } from '../../utils/routes'

import axios from 'axios'
import { FETCH_PROVIDER_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs, showAlert, showLoader, hideLoader } from '../../redux/actions'

import ProviderForm from './form'
import Portlet from '../../components/portlet/portlet'
import ProviderRequisitesForm from './requisites-form'


const ProviderUpdate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  const title = useSelector(state => state.title)

  const [loaded, setLoaded] = useState(false)

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

  const [disableButton, setDisableButton] = useState(false)
  const [uploadImage, setUploadImage] = useState(null)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список провайдеров',
        link: PROVIDER_INDEX,
      }
    ]))

    dispatch(showLoader())
    axios.get(FETCH_PROVIDER_URL.replace(':id', match.params.id))
      .then(({data}) => {
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
        dispatch(setTitle(`Редактирование провайдера обучения "${data.name}"`))
        dispatch(hideLoader())
        setLoaded(true)
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(PROVIDER_INDEX)
      })
  }, [])

  const save = () => {
    setDisableButton(true)

    const formData = new FormData()
    formData.append('uploadImage', uploadImage)
    formData.append('json_content', JSON.stringify(item))

    axios.put(UPDATE_PROVIDER_URL, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then(() => history.push(PROVIDER_INDEX))
      .catch((error) => {
        dispatch(showAlert(error.response.data.message))
        setDisableButton(false)
      })
  }

  if (!loaded) {
    return <></>
  }

  return (
    <>
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
          save={save}
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
    </>
  )
}

export default ProviderUpdate
