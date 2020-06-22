import React, { useEffect } from 'react'

import { useDispatch } from 'react-redux'
import { showAlert } from '../../redux/actions'

import { useHistory } from 'react-router-dom'
import axios from 'axios'
import NotFound from '../not-found/not-found'
import { CREATE_PROVIDER_URL } from '../../utils/api/endpoints'
import { PROVIDER_INDEX } from '../../utils/routes'


const CreatePageTemplate = ({children, indexPageUrl, createUrl, item, setDisableButton, needSave = false, setNeedSave, multipart = false, appendExternalData}) => {
  const dispatch = useDispatch()
  const history = useHistory()

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

      axios.post(createUrl, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(() => history.push(indexPageUrl))
        .catch((error) => handleError(error))
    } else {
      axios.post(createUrl, item)
        .then(() => history.push(indexPageUrl))
        .catch((error) => handleError(error))

    }

  }, [needSave])

  return <>{children}</>
}

export default CreatePageTemplate
