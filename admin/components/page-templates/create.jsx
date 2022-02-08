import React, { useEffect } from 'react'

import axios from 'axios'

import { useDispatch } from 'react-redux'
import { showAlert } from '../../redux/actions'

import { useHistory } from 'react-router-dom'


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
