import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { PROGRAM_FORMAT_INDEX, PROVIDER_INDEX } from '../../utils/routes'

import axios from 'axios'
import { CREATE_PROGRAM_FORMAT_URL, CREATE_PROVIDER_URL, FETCH_ALL_CATEGORIES } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs, showAlert, showLoader, hideLoader } from '../../redux/actions'

import ProviderForm from './form'
import Portlet from '../../components/portlet/portlet'


const ProviderCreate = () => {
  const dispatch = useDispatch()
  const history = useHistory()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    description: '',
    mainCategories: [],
    categories: [],
  })

  const [categories, setCategories] = useState([])
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    dispatch(setTitle('Добавление провайдера обучения'))
    dispatch(setBreacrumbs([
      {
        title: 'Список провайдеров',
        link: PROVIDER_INDEX,
      }
    ]))

    axios.get(FETCH_ALL_CATEGORIES)
      .then(({data}) => {
        setCategories(data.categories)
        dispatch(hideLoader())
      })
  }, [])

  const save = () => {
    setDisableButton(true)

    axios.post(CREATE_PROVIDER_URL, item)
      .then(() => history.push(PROVIDER_INDEX))
      .catch((error) => {
        dispatch(showAlert(error.response.data.message))
        setDisableButton(false)
      })
  }

  return (
    <Portlet
      width={50}
      title={title}
      titleIcon={'info'}
    >
      <ProviderForm
        item={item}
        setItem={setItem}
        categories={categories}
        save={save}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default ProviderCreate
