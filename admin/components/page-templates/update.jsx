import React, { useEffect, useState } from 'react'

import axios from 'axios'

import { useDispatch } from 'react-redux'
import { showLoader, hideLoader, showAlert } from '../../redux/actions'
import { useHistory } from 'react-router-dom'
import NotFound from '../not-found/not-found'


export const UpdatePageTemplate = ({children, indexPageUrl, fetchUrl, updateUrl, item, setItem, setDisableButton, needSave = false, setNeedSave, multipart = false, appendExternalData}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  const [loaded, setLoaded] = useState(false)
  const [notFound, setNotFound] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    axios.get(fetchUrl)
      .then(({data}) => {
        setItem(data)
        setLoaded(true)
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(indexPageUrl)
      })
  }, [])

  const handleError = (error) => {
    dispatch(showAlert(error.response.data.message))
    setDisableButton(false)
    setNeedSave(false)
  }

  useEffect(() => {
    if (!needSave) {
      return
    }

    setDisableButton(true)

    if (multipart) {
      const formData = new FormData()

      appendExternalData(formData)
      formData.append('json_content', JSON.stringify(item))

      axios.put(updateUrl, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(() => history.push(indexPageUrl))
        .catch((error) => handleError(error))
    } else {
      axios.put(updateUrl, item)
        .then(() => history.push(indexPageUrl))
        .catch((error) => handleError(error))
    }
  }, [needSave])

  if (!loaded) {
    return <></>
  }

  if (notFound) {
    return <NotFound/>
  }

  return <>{children}</>
}
